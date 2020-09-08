<?php

namespace App\Http\Controllers\Ordens;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\OrdemDeServico;
use App\Http\Resources\OrdemResource;
use Storage;
use App\Repositories\Contracts\OrdemInterface;
use App\Repositories\Eloquent\Criteria\LatestFirst;
use App\Repositories\Eloquent\Criteria\IsLive;
use App\Repositories\Eloquent\Criteria\ForUser;
use Snappy;

class OrdemController extends Controller
{
	protected $ordemInterface;

	public function __construct(OrdemInterface $ordemInterface) {
		$this->ordemInterface = $ordemInterface;
	}

	public function index() {
		$ordens = $this->ordemInterface->withCriteria([
            new LatestFirst(),
            new ForUser(auth()->user()->id)
        ])->all();
		return OrdemResource::collection($ordens);
	}

	public function findOrdem($id) {
		$ordem = $this->ordemInterface->withCriteria([
            new ForUser(auth()->user()->id)
        ])->find($id);
		return new OrdemResource($ordem);
	}

    public function cadastra(Request $request) {

        $this->validate($request, [
            'cliente_id' => ['required'],
            'data_entrada' => ['required', 'max:10'],
            'equipamento' => ['required'],
        ]);

        $servicos = [];
        foreach ($request->servicos as $servico) {
            $servicos[] = $servico;
        }

        $ordem = auth()->user()->ordens()->create([
            'descricao' => $request->descricao,
            'user_id' => $request->user_id,
            'cliente_id' => $request->cliente_id,
            'data_entrada' => new \DateTime($request->data_entrada),
            'data_previsao' => $request->data_previsao,
            'data_entrega' => $request->data_entrega,
            'situacao' => $request->situacao,
            'valor' => $request->valor,
            'equipamento' => $request->equipamento,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'numero_serie' => $request->numero_serie,
            'garantia' => $request->garantia,
            'observacoes' => $request->observacoes,
            'servicos' => json_encode($servicos),
        ]);

        $data = [
            'ordem' => $ordem
        ];
        $pdf = Snappy::loadView('ordem_pdf', $data);
        $pdf->setOption('enable-smart-shrinking', false);
        $pdf->setOption('margin-top', 0);
        $pdf->save(storage_path() . '/uploads/pdfs/ordem_' . $ordem->id . '.pdf', true);

        return response()->json($ordem, 200);
    }

	public function atualiza(Request $request, $id) {

    	$ordem = $this->ordemInterface->find($id);

    	$this->authorize('update', $ordem);

    	$this->validate($request, [
            'cliente' => ['required']
    		// 'email' => ['required', 'string', 'min:10', 'max:150'],
    	]);

        $servicos = [];
        foreach ($request->servicos as $servico) {
            $servicos[] = $servico;
        }

    	$ordem = $this->ordemInterface->update($id, [
            'cliente_id' => $request->cliente,
            'data_entrada' => $request->data_entrada,
            'data_previsao' => $request->data_previsao,
            'data_entrega' => $request->data_entrega,
            'situacao' => $request->situacao,
            'valor' => $request->valor,
            'equipamento' => $request->equipamento,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'numero_serie' => $request->numero_serie,
            'garantia' => $request->garantia,
            'observacoes' => $request->observacoes,
            'servicos' => json_encode($servicos)
    	]);

        $ordem->cliente()->associate($request->cliente);
        $ordem->save();

        $data = [
            'ordem' => $ordem
        ];
        $pdf = Snappy::loadView('ordem_pdf', $data);
        $pdf->setOption('enable-smart-shrinking', false);
        $pdf->setOption('margin-top', 0);
        $pdf->save(storage_path() . '/uploads/pdfs/ordem_' . $ordem->id . '.pdf', true);

        // $pdf = PDF::loadView('ordem_pdf', compact('ordem'));
        // $pdf->setPaper('A4')->setOptions(['dpi' => 100])->save(storage_path() . '/uploads/pdfs/ordem_' . $ordem->id . '.pdf');

    	return new OrdemResource($ordem);
	}

	public function deleta(Request $request, $id) {

    	$ordem = $this->ordemInterface->find($id);

    	$this->authorize('delete', $ordem);

    	$this->ordemInterface->delete($id);

    	return response()->json(['message' => 'Registro deletado'], 200);
	}
}

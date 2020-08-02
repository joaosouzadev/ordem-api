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
		$ordem = $this->ordemInterface->find($id);
		return new OrdemResource($ordem);
	}

    public function cadastra(Request $request) {

        $this->validate($request, [
            'descricao' => ['required', 'max:255'],
            'cliente_id' => ['required'],
        ]);

        $ordem = auth()->user()->ordens()->create([
            'descricao' => $request->descricao,
            'user_id' => $request->user_id,
            'cliente_id' => $request->cliente_id,
        ]);

        return response()->json($ordem, 200);
    }

	public function atualiza(Request $request, $id) {

    	$ordem = $this->ordemInterface->find($id);

    	$this->authorize('update', $ordem);

    	$this->validate($request, [
    		'descricao' => ['required'],
            'cliente_id' => ['required']
    		// 'email' => ['required', 'string', 'min:10', 'max:150'],
    	]);

    	$ordem = $this->ordemInterface->update($id, [
    		'descricao' => $request->descricao
    	]);

        $ordem->cliente()->associate($request->cliente_id);
        $ordem->save();

    	return new OrdemResource($ordem);
	}

	public function deleta(Request $request, $id) {

    	$ordem = $this->ordemInterface->find($id);

    	$this->authorize('delete', $ordem);

    	$this->ordemInterface->delete($id);

    	return response()->json(['message' => 'Registro deletado'], 200);
	}
}

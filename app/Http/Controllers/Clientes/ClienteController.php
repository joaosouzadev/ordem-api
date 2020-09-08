<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Cliente;
use App\Http\Resources\ClienteResource;
use Storage;
use App\Repositories\Contracts\ClienteInterface;
use App\Repositories\Eloquent\Criteria\LatestFirst;
use App\Repositories\Eloquent\Criteria\IsLive;
use App\Repositories\Eloquent\Criteria\ForUser;

class ClienteController extends Controller
{
	protected $clienteInterface;

	public function __construct(ClienteInterface $clienteInterface) {
		$this->clienteInterface = $clienteInterface;
	}

	public function index() {
		$clientes = $this->clienteInterface->withCriteria([
            new LatestFirst(),
            new ForUser(auth()->user()->id)
        ])->all();
		return ClienteResource::collection($clientes);
	}

	public function findCliente($id) {
		$cliente = $this->clienteInterface->withCriteria([
            new ForUser(auth()->user()->id)
        ])->find($id);
		return new ClienteResource($cliente);
	}

    public function cadastra(Request $request) {

        $this->validate($request, [
            'nome' => ['required', 'max:255']
        ]);

        $cliente = auth()->user()->clientes()->create([
            'nome' => $request->nome,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'celular' => $request->celular,
            'cep' => $request->cep,
            'rua' => $request->rua,
            'numero' => $request->numero,
            'complemento' => $request->complemento,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
        ]);

        return response()->json($cliente, 200);
    }

	public function atualiza(Request $request, $id) {

    	$cliente = $this->clienteInterface->find($id);

    	$this->authorize('update', $cliente);

    	$this->validate($request, [
    		'nome' => ['required'],
    		// 'email' => ['required', 'string', 'min:10', 'max:150'],
    	]);

    	$cliente = $this->clienteInterface->update($id, [
    		'nome' => $request->nome,
    		'email' => $request->email,
            'telefone' => $request->telefone,
            'celular' => $request->celular,
            'cep' => $request->cep,
            'rua' => $request->rua,
            'numero' => $request->numero,
            'complemento' => $request->complemento,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
    	]);

    	return new ClienteResource($cliente);
	}

	public function deleta(Request $request, $id) {

    	$cliente = $this->clienteInterface->find($id);

    	$this->authorize('delete', $cliente);

    	$this->clienteInterface->delete($id);

    	return response()->json(['message' => 'Registro deletado'], 200);
	}
}

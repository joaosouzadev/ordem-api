<?php

namespace App\Repositories\Eloquent;

use App\Models\Cliente;
use App\Repositories\Contracts\ClienteInterface;
use App\Repositories\Eloquent\BaseRepository;

class ClienteRepository extends BaseRepository implements ClienteInterface {

	public function model() {
		return Cliente::class;
	}
}
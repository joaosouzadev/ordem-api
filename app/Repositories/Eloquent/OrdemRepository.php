<?php

namespace App\Repositories\Eloquent;

use App\Models\OrdemDeServico;
use App\Repositories\Contracts\OrdemInterface;
use App\Repositories\Eloquent\BaseRepository;

class OrdemRepository extends BaseRepository implements OrdemInterface {

	public function model() {
		return OrdemDeServico::class;
	}
}
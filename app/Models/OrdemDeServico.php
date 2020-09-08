<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdemDeServico extends Model
{
    protected $fillable = [
        'user_id', 
        'cliente_id', 
        'data_entrada',
        'data_previsao',
        'data_entrega',
        'situacao',
        'valor',
        'equipamento',
        'marca',
        'modelo',
        'numero_serie',
        'garantia',
        'observacoes',
        'servicos',
    ];

    protected $dates = ['data_entrada', 'data_previsao', 'data_entrega'];

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function cliente() {
    	return $this->belongsTo(Cliente::class);
    }
}

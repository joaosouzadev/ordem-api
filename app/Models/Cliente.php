<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'user_id', 
        'nome', 
        'email',
        'telefone',
        'celular', 
        'cep',
        'rua',
        'numero', 
        'complemento',
        'bairro',
        'cidade',
    ];

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function ordens() {
        return $this->hasMany(OrdemDeServico::class);
    }
}

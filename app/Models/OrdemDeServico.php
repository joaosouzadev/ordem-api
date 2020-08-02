<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdemDeServico extends Model
{
    protected $fillable = [
        'user_id', 
        'cliente_id', 
        'descricao',
    ];

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function cliente() {
    	return $this->belongsTo(Cliente::class);
    }
}

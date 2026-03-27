<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoPublico extends Model
{
    protected $fillable = ['titulo', 'descricao', 'midias', 'data_realizacao'];
    
    protected $casts = [
        'data_realizacao' => 'date',
        'midias' => 'array', // O Laravel converte magicamente o JSON para Array do PHP
    ];
}
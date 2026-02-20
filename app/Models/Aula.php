<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Aula extends Model
{
    protected $fillable = [
        'curso_id',
        'titulo',
        'descricao',
        'tipo',
        'conteudo',
        'ordem',
        'data_aula'
    ];

    protected $casts = [
        'data_aula' => 'datetime'
    ];

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }
}

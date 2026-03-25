<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialDidatico extends Model
{
    protected $table = 'materiais_didaticos';

    protected $fillable = [
        'materia_id',
        'mentora_id',
        'titulo',
        'descricao',
        'tipo',
        'conteudo',
        'arquivo_path',
        'arquivo_nome',
        'ordem',
    ];

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }

    public function mentora(): BelongsTo
    {
        return $this->belongsTo(Mentora::class);
    }

    /**
     * Retorna o ícone FontAwesome baseado no tipo do material.
     */
    public function getIconeAttribute(): string
    {
        return match ($this->tipo) {
            'video' => 'fas fa-video',
            'pdf' => 'fas fa-file-pdf',
            'documento' => 'fas fa-file-alt',
            'link' => 'fas fa-link',
            'texto' => 'fas fa-align-left',
            default => 'fas fa-file',
        };
    }

    /**
     * Retorna a cor CSS baseada no tipo do material.
     */
    public function getCorTipoAttribute(): string
    {
        return match ($this->tipo) {
            'video' => 'text-red-400',
            'pdf' => 'text-blue-400',
            'documento' => 'text-yellow-400',
            'link' => 'text-green-400',
            'texto' => 'text-gray-400',
            default => 'text-gray-400',
        };
    }
}

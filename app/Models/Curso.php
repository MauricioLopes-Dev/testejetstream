<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Curso extends Model
{
    protected $fillable = [
        'nome',
        'descricao',
        'area_atuacao_id',
        'area_personalizada',
        'data_inicio',
        'data_fim',
        'mentora_id',
        'ativo'
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'ativo' => 'boolean'
    ];

    public function areaAtuacao(): BelongsTo
    {
        return $this->belongsTo(AreaAtuacao::class);
    }

    public function mentora(): BelongsTo
    {
        return $this->belongsTo(Mentora::class);
    }

    public function aulas(): HasMany
    {
        return $this->hasMany(Aula::class)->orderBy('ordem');
    }

    public function inscritos(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'curso_inscricoes')
                    ->withTimestamps()
                    ->withPivot('inscrito_em');
    }

    public function getNomeAreaAttribute()
    {
        return $this->area_personalizada ?? $this->areaAtuacao->nome ?? 'N/A';
    }
}

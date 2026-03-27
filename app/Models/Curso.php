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
        'ativo',
        'max_vagas',
        'duracao_horas',
        'imagem_capa',
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'ativo' => 'boolean',
        'max_vagas' => 'integer',
        'duracao_horas' => 'integer',
    ];

    public function areaAtuacao(): BelongsTo
    {
        return $this->belongsTo(AreaAtuacao::class);
    }

    /**
     * Mentora principal do curso (campo legado).
     */
    public function mentora(): BelongsTo
    {
        return $this->belongsTo(Mentora::class);
    }

    /**
     * Mentoras atribuídas ao curso (pivot).
     */
    public function mentoras(): BelongsToMany
    {
        return $this->belongsToMany(Mentora::class, 'curso_mentora')
                    ->withTimestamps();
    }

    public function aulas(): HasMany
    {
        return $this->hasMany(Aula::class)->orderBy('ordem');
    }

    /**
     * Matérias do curso.
     */
    public function materias(): HasMany
    {
        return $this->hasMany(Materia::class)->orderBy('ordem');
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

    /**
     * Verifica se o curso ainda tem vagas disponíveis.
     */
    public function getTemVagasAttribute(): bool
    {
        return $this->inscritos()->count() < $this->max_vagas;
    }

    /**
     * Retorna o número de vagas restantes.
     */
    public function getVagasRestantesAttribute(): int
    {
        return max(0, $this->max_vagas - $this->inscritos()->count());
    }

    /**
     * Retorna a duração formatada.
     */
    public function getDuracaoFormatadaAttribute(): string
    {
        if (!$this->duracao_horas) {
            return 'N/A';
        }

        if ($this->duracao_horas >= 24) {
            $dias = floor($this->duracao_horas / 24);
            $horas = $this->duracao_horas % 24;
            return $dias . 'd ' . ($horas > 0 ? $horas . 'h' : '');
        }

        return $this->duracao_horas . 'h';
    }
}

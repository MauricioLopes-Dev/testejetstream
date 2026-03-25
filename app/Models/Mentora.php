<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Mentora extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nome', 'email', 'password', 'telefone', 'area_atuacao_id', 
        'nivel_experiencia', 'github_url', 'linkedin_url', 'sobre_mim',
        'codigo_verificacao', 'email_verificado_at', 'status_aprovacao', 'reprovado_em'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verificado_at' => 'datetime',
        'reprovado_em' => 'datetime',
    ];

    public function areaAtuacao()
    {
        return $this->belongsTo(AreaAtuacao::class, 'area_atuacao_id');
    }

    /**
     * Cursos onde é mentora principal (campo legado).
     */
    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }

    /**
     * Cursos atribuídos via pivot.
     */
    public function cursosAtribuidos(): BelongsToMany
    {
        return $this->belongsToMany(Curso::class, 'curso_mentora')
                    ->withTimestamps();
    }

    /**
     * Materiais didáticos criados pela mentora.
     */
    public function materiaisDidaticos()
    {
        return $this->hasMany(MaterialDidatico::class);
    }

    /**
     * Relacionamento com as mensagens enviadas/recebidas pela mentora.
     */
    public function mensagens()
    {
        return $this->hasMany(MensagemChat::class);
    }
}

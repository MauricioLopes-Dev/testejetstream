<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'user_id', 'titulo', 'descricao', 'data_hora', 'local', 'limite_vagas'
    ];

    // O Laravel precisa saber que esse campo é data, para podermos formatar depois
    protected $casts = [
        'data_hora' => 'datetime',
    ];

    // Quem criou o evento
    public function criador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Quem vai participar (Relação Many-to-Many)
    public function participantes()
    {
        return $this->belongsToMany(User::class, 'event_user')->withTimestamps();
    }
    
    // Função auxiliar para saber se está lotado
    public function estaLotado()
    {
        if ($this->limite_vagas == 0) return false; // Ilimitado
        return $this->participantes()->count() >= $this->limite_vagas;
    }
}
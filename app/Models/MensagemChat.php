<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MensagemChat extends Model
{
    protected $table = 'mensagens_chat';
    protected $fillable = ['mentora_id', 'user_id', 'mensagem', 'remetente', 'lida'];

    public function mentora()
    {
        return $this->belongsTo(Mentora::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

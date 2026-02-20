<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'telefone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relacionamento com eventos que o usuário criou.
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Relacionamento com eventos em que o usuário está participando.
     */
    public function eventosParticipando()
    {
        return $this->belongsToMany(Event::class, 'event_user')->withTimestamps();
    }

    /**
     * Relacionamento com cursos em que o usuário está inscrito.
     */
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'curso_inscricoes')
                    ->withPivot('inscrito_em');
    }

    /**
     * Relacionamento com as presenças da aluna.
     */
    public function presencas()
    {
        return $this->hasMany(Presenca::class);
    }

    /**
     * Relacionamento com as mensagens enviadas/recebidas pela aluna.
     */
    public function mensagens()
    {
        return $this->hasMany(MensagemChat::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaAtuacao extends Model
{
    use HasFactory;

    protected $table = 'areas_atuacao';
    protected $fillable = ['nome'];

    public function mentoras()
    {
        return $this->hasMany(Mentora::class, 'area_atuacao_id');
    }
}

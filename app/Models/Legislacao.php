<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Legislacao extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descricao',
        'estatuto_social',
        'certificado_nacional',
        'caminho_arquivo',
    ];
}

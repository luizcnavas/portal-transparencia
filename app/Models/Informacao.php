<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informacao extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'conteudo',
        'informacoes_institucionais',
        'impacto_social',
        'estrutura_administrativa',
        'contatos',
        'caminho_documento',
    ];
}

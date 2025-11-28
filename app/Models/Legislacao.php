<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Legislacao extends Model
{
    use HasFactory;

    // Nome da tabela
    protected $table = 'legislacaos';

    protected $fillable = [
        'titulo',
        'descricao',
        'estatuto_social',
        'certificado_nacional',
        'caminho_arquivo',
    ];
    
    /**
     * Get the route key for the model.
     * Corrige o problema do Laravel pluralizar incorretamente "legislacao" para "legislaco"
     */
    public function getRouteKeyName()
    {
        return 'id';
    }
}

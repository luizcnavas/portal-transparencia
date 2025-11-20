<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informacao extends Model
{
    use HasFactory;

    // Define o nome da tabela explicitamente para evitar problemas de pluralização
    protected $table = 'informacaos';

    protected $fillable = [
        'titulo',
        'conteudo',
        'informacoes_institucionais',
        'impacto_social',
        'estrutura_administrativa',
        'contatos',
        'caminho_documento',
    ];
    
    /**
     * Get the route key for the model.
     * Corrige o problema do Laravel pluralizar incorretamente "informacao" para "informaco"
     */
    public function getRouteKeyName()
    {
        return 'id';
    }
}

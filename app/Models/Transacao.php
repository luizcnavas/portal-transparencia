<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    use HasFactory;

    /**
     * Nome explícito da tabela. O pluralizador em inglês geraria "transacaos",
     * enquanto a migration criou a tabela "transacoes" (português).
     *
     * @var string
     */
    protected $table = 'transacoes';

    /**
     * Atributos que podem ser atribuídos em massa (mass assignment).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'descricao',
        'valor',
        'data',
        'categoria',
        'tipo',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'valor' => 'decimal:2',
        'data' => 'date',
    ];
}

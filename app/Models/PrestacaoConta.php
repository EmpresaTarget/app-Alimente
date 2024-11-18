<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestacaoConta extends Model
{
    use HasFactory;

    // Adicionar as colunas de fotos individuais no $fillable
    protected $fillable = [
        'idOng',
        'balanco',
        'demonstracao',
        'receitas',
        'despesas',
        'foto1', // Coluna para foto 1
        'foto2', // Coluna para foto 2
        'foto3', // Coluna para foto 3
        'foto4', // Coluna para foto 4
        'foto5', // Coluna para foto 5
    ];

    // Relacionamento com a tabela 'ongs'
    public function ong()
    {
        return $this->belongsTo(Ong::class, 'idOng', 'idOng'); // Relaciona com a tabela ongs
    }
}

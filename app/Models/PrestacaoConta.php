<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestacaoConta extends Model
{
    use HasFactory;

    protected $fillable = [
        'idOng',
        'balanco',
        'demonstracao',
        'receitas',
        'despesas',
        'fotos',
    ];

   // app/Models/PrestacaoContas.php

public function ong()
{
    return $this->belongsTo(Ong::class, 'idOng', 'idOng'); // Relaciona com a tabela ongs
}

}

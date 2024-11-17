<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doacao extends Model
{
    use HasFactory;

    protected $table = 'doacoes';

    protected $primaryKey = 'idDoacao';

    protected $fillable = [
        'ongId',
        'valor',
        'mes',
        'ano',
    ];

    // Relacionamento com a tabela ONG
    public function ong()
    {
        return $this->belongsTo(Ong::class, 'ongId', 'idOng');
    }
}

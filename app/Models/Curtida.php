<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curtida extends Model
{
    use HasFactory;

    protected $table = 'curtidas'; // Define o nome da tabela, caso não siga a convenção

    // Defina os campos que podem ser preenchidos em massa
    protected $fillable = [
        'postagem_id',
        'doador_id',
    ];

    // Relacionamento com a tabela Postagem
    public function postagem()
    {
        return $this->belongsTo(Postagem::class, 'postagem_id', 'idPostagem');
    }

    // Relacionamento com a tabela Doador (ou usuário)
    public function doador()
    {
        return $this->belongsTo(Doador::class, 'doador_id', 'idDoador');
    }
}

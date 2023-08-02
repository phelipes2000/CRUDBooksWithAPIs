<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo', 'nome_autor', 
        'data_lancamento','capa','description',
        'quantidade_paginas','cep','endereco',
        'cidade','estado'
    ];
}

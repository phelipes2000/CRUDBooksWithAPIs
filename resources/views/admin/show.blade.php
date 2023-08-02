@extends('admin.layouts.app')

@section('title', 'Detalhes')

@section('header')
<div class="titulo">
    <h1>Detalhes do Livro: {{ $book->titulo }}</h1>
</div>
@endsection

@section('content')
{{-- {{$book->nome_autor}}

{{$book->data_lancamento}} --}}
<main class="cards">
        <section class="card">
            <h2 class="card-titulo">{{ $book->titulo }}</h2>
            
            <div class="container-capa">
                <img class="imagem" src="{{ Storage::disk('s3')->url($book->capa) }}" alt="{{ $book->titulo }}">
            </div>
                <div class="info-book">
                    <h2 class="nome-autor">
                        Autor: {{ $book->nome_autor }}
                     </h2>
                     <h2 class="data-lancamento">
                        Data de Lançamento: {{ $book->data_lancamento }}
                     </h2>
                     <span class="descricao">
                        Descrição: {{ $book->description }}
                     </span>
                     <h2 class="data-lancamento">
                        Quantidade de Páginas: {{ $book->quantidade_paginas }}
                     </h2>

                </div>
        </section>  
        <div class="info-adress">
            <h2 class="endereco">Endereço: {{ $book->endereco}}  </h2>
            <h2 class="cidade">Cidade: {{ $book->cidade}}</h2>
            <h2 class="estado">Estado: {{ $book->estado}}</h2>
        </div>

</main> 

<form action="{{route('books.destroy', $book->id)}}" method="post">
    @csrf
    @method('DELETE')
    <button type="submit">Delete</button>
</form>
@endsection
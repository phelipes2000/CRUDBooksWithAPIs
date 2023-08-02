@extends('admin.layouts.app')

@section('title', 'Books')

@section('header')
<div class="titulo">
    <h1>Lista de Livros</h1>
</div>
@endsection

@section('content')

<div class="add-book">
    <a class="botao" href="{{ route('books.create') }}">Adicionar Livro</a>
</div>
<main class="cards">
    @foreach ($books->items() as $book)
        <section class="card">
            <h2 class="card-titulo">{{ $book->titulo }}</h2>
            
            <div class="container-capa">
                <img class="imagem" src="{{ Storage::disk('s3')->url($book->capa) }}"  alt="{{ $book->titulo }}">
            </div>

            <div class="container-botoes">
                <div class="container-show">
                    <a class="show" href="{{ route('books.show', $book->id) }}">Detalhes</a>
                </div>
                <div class="container-edit">
                    <a href="{{ route('books.edit', $book->id) }}">Editar</a>
                </div>
            </div>
        </section>    
    @endforeach

</main>
<x-pagination :paginator="$books" :appends="$filters" />

@endsection
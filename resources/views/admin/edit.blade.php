@extends('admin.layouts.app')

@section('title', 'Editar')

@section('header')
<div class="titulo">
    <h1>Livro {{ $book->id }}</h1>
</div>
@endsection

@section('content')

<x-alert/>

<form action="{{ route('books.update', $book->id) }}" method="post" enctype="multipart/form-data">
    @method('PUT')
    @include('admin.partials.form')
</form>
@endsection
@extends('admin.layouts.app')

@section('title', 'Novo Livro')

@section('header')

<div class="titulo">
    <h1>Novo Livro</h1>
</div>
    
@endsection

@section('content')
<x-alert/>

<form action="{{ route('books.store') }}" method="post" enctype="multipart/form-data">
    @include('admin.partials.form')
</form>
@endsection
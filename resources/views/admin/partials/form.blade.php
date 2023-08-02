@csrf
<div class="formulario">
    <input type="text" placeholder="Titulo do Livro" name="titulo" id="titulo" value="{{$book->titulo ?? null}}">
    <input type="text" placeholder="Nome do Autor" name="nome_autor" id="nome_autor" value="{{$book->nome_autor ?? null}}">
    {{-- <input type="text" placeholder="Data de Lançamento(dd/mm/yyyy)" name="data_lancamento" id="data_lancamento" value="{{$book->data_lancamento ?? null}}"> --}}
    <input type="text" placeholder="cep" name="cep" id="cep" value="{{$book->cep ?? null}}">
    <input type="file" placeholder="Capa" name="capa" id="capa"  value="{{$book->capa ?? null}}">
    <button type="submit">Enviar</button>
</div>
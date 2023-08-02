<?php

namespace App\DTO;

use App\Http\Requests\StoreUpdateBook;
use App\Models\Book;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UpdateBookDTO {
    public function __construct(
        public string $id,
        public string $titulo,
        public string $nome_autor,
        public string $data_lancamento,
        public string $capa,
        public string $description,
        public int $quantidade_paginas,
        public string $cep,
        public string $endereco,
        public string $cidade,
        public string $estado,
    )
    {
        
    }
    public static function makeFromRequest(StoreUpdateBook $request, string $id = null):self
    {
        $client = new Client();
        $apiKey = 'AIzaSyCJa-ljoVuP-jHyMBAx0L_HGirYv9rKMLk';

        // URL da API do Google Books
        $url = 'https://www.googleapis.com/books/v1/volumes?q=' . urlencode($request->titulo) . '&key=' . $apiKey;

        try {
            // Faz a solicitação GET à API
            $response = $client->get($url);

            // Obtém o corpo da resposta em formato JSON
            $jsonData = $response->getBody();

            // Decodifica o JSON em um array associativo
            $data = json_decode($jsonData, true);

            // Verifica se há resultados e processa as informações
            if (isset($data['items']) && count($data['items']) > 0) {
                $book = $data['items'][0]['volumeInfo'];
                // Obtém a data de lançamento do livro, ou define como "data desconhecida" caso não haja a informação
                $data_lancamento = $book['publishedDate'] ?? 'Data desconhecida';

                // Obtém a descrição do livro, ou define como "sem descrição" caso não haja
                $description = $book['description'] ?? 'Sem descrição';

                // Obtém a quantidade de páginas do livro, ou define como 0 caso não haja a informação
                $quantidade_paginas = $book['pageCount'] ?? 0;

            } else {
                $data_lancamento = 'Data desconhecida';
                $description = 'Sem descrição';
                $quantidade_paginas = 0;
            }
        } catch (\Exception $e) {
            // Em caso de erro, retorna "data desconhecida", "sem descrição" e quantidade de páginas como 0
            $data_lancamento = 'Data desconhecida';
            $description = 'Sem descrição';
            $quantidade_paginas = 0;
        }
        $cep_autor = $request->cep;

        // Faz a solicitação GET à API VIACep
        $client = new Client();
        $response = $client->get('https://viacep.com.br/ws/' . $cep_autor . '/json/');
    
        // Obtém o corpo da resposta em formato JSON
        $jsonData = $response->getBody();
    
        // Decodifica o JSON em um array associativo
        $endereco_data = json_decode($jsonData, true);
    
        // Obtém as informações do endereço, cidade e estado do autor a partir do retorno da API VIACep
        $endereco = $endereco_data['logradouro'] ?? '';
        $cidade = $endereco_data['localidade'] ?? '';
        $estado = $endereco_data['uf'] ?? '';
        
        $book = Book::find($id ?? $request->id);

    // Verifique se o livro existe e se ele possui uma capa
    if ($book && $book->capa) {
        // Deleta o arquivo da imagem da AWS S3
        Storage::disk('s3')->delete($book->capa);
    }

        if($request->hasFile('capa')) {
            $filenamewithextension = $request->file('capa')->getClientOriginalName();

            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            
            $extension = $request->file('capa')->getClientOriginalExtension();
        
            $filenametostore = $filename.'_'.time().'.'.$extension;

            Storage::disk('s3')->put($filenametostore, fopen($request->file('capa'), 'r+'), 'public');
        }
        $capa = $filenametostore;
        return new self(
            $id ?? $request->id,
            $request->titulo,
            $request->nome_autor,
            $data_lancamento,
            $capa,
            $description,
            $quantidade_paginas, 
            $request->cep,
            $endereco,
            $cidade,
            $estado,
        );
    }
}
<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'identify' => $this->id,
            'titulo' => $this->titulo,
            'nome_autor' => $this->nome_autor,
            'data_lancamento' => $this->data_lancamento,
            'capa' => $this->capa,
        ];
    }
}

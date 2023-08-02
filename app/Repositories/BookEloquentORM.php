<?php

namespace App\Repositories;


use App\DTO\CreateBookDTO;
use App\DTO\UpdateBookDTO;
use App\Models\Book;
use App\Repositories\BookRepositoryInterface;
use stdClass;

class BookEloquentORM implements BookRepositoryInterface {
    public function __construct(
        protected Book $model,
    )
    {
        
    }
    public function paginate(int $page = 1, int $totalPelPage = 15,string $filter = null): PaginationInterface {
        $result =  $this->model
                    ->where(function($query) use ($filter){
                        if($filter) {
                                $query->where('titulo', $filter);
                                $query->orWhere('nome_autor', 'like', "%{$filter}%");
                                $query->where('data_lancamento', $filter);
                                $query->where('capa', $filter);
                        }
                    })
                    ->paginate($totalPelPage, ['*'], 'page', $page);
                    return new PaginationPresenter($result);
    }
    
    public function getAll(string $filter = null): array 
    {
        return $this->model
                    ->where(function($query) use ($filter){
                        if($filter) {
                                $query->where('titulo', $filter);
                                $query->orWhere('nome_autor', 'like', "%{$filter}%");
                                $query->where('data_lancamento', $filter);
                                $query->where('capa', $filter);
                        }
                    })
                    ->get()
                    ->toArray();
    }
    public function findOne(string $id): stdClass|null
    {
        $book = $this->model->find($id);
        if (!$book) {
            return null;
        }
        return (object) $book->toArray();
    }
    public function delete(string $id): void
    {
        $this->model->findOrFail($id)->delete();
    }
    public function new(CreateBookDTO $dto): stdClass
    {
        $book = $this->model->create(
            (array) $dto
        );
        return (object) $book->toArray();
    }
    public function update(UpdateBookDTO $dto): stdClass|null
    {
        if(!$book = $this->model->find($dto->id)) {
            return null;
        }
        $book->update(
            (array) $dto
        );
        return (object) $book->toArray();
    }
}
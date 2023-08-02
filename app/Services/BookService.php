<?php

namespace App\Services;
use App\DTO\CreateBookDTO;
use App\DTO\UpdateBookDTO;
use App\Repositories\BookRepositoryInterface;
use App\Repositories\PaginationInterface;
use stdClass;

class BookService {

    public function __construct(
        protected BookRepositoryInterface $repository,
    )
    {
        
    }
    public function paginate(
        string $filter = null,
        int $totalPelPage = 15,
        int $page = 1,
        ): PaginationInterface
    {
        return $this->repository->paginate(
            page: $page,
            totalPelPage: $totalPelPage,
            filter: $filter,
        );
    }

    public function getAll(string $filter = null): array
    {
        return $this->repository->getAll($filter);
    }

    public function findOne(string $id):stdClass|null {
        return $this->repository->findOne($id);
    }
    public function new(CreateBookDTO $dto): stdClass{
            return $this->repository->new($dto);
    }

    public function update(UpdateBookDTO $dto): stdClass|null{
            return $this->repository->update($dto);
    }

    public function delete(string $id): void{
        $this->repository->delete($id);
    }
}
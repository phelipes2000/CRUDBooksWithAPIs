<?php
namespace App\Repositories;

use App\DTO\CreateBookDTO;
use App\DTO\UpdateBookDTO;
use stdClass;

interface BookRepositoryInterface {
    public function paginate(int $page = 1, int $totalPelPage = 15,string $filter = null): PaginationInterface;
    public function getAll(string $filter = null): array;
    public function findOne(string $id): stdClass|null;
    public function delete(string $id): void;
    public function new(CreateBookDTO $dto): stdClass;
    public function update(UpdateBookDTO $dto): stdClass|null;
}
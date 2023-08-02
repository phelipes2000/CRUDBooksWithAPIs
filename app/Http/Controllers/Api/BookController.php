<?php

namespace App\Http\Controllers\Api;

use App\Adapters\ApiAdapter;
use App\DTO\CreateBookDTO;
use App\DTO\UpdateBookDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateBook;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function __construct(
        protected BookService $service,
    )
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $books = $this->service->paginate(
            page: $request->get('page', 1),
            totalPelPage: $request->get('per_page', 3),
            filter: $request->filter,
        );

        return ApiAdapter::toJson($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateBook $request)
    {
        $book = $this->service->new(
            CreateBookDTO::makeFromRequest($request)
        );
        return new BookResource($book);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(!$book = $this->service->findOne($id)) {
            return response()->json([
                'error' => 'Not Found'
            ], 404);
        }
        return new BookResource($book);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateBook $request, string $id)
    {
        dd($id);
        $book = $this->service->update(
            UpdateBookDTO::makeFromRequest($request, $id)
        );
        if (!$book) {
            return response()->json([
                'error' => 'Not Found'
            ], 404);
        }
        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!$this->service->findOne($id)) {
            return response()->json([
                'error' => 'Not Found'
            ], 404);
        }

            // Obtenha o livro pelo ID (supondo que você esteja usando um Eloquent Model)
    $book = Book::find($id);

    // Verifique se o livro existe e se ele possui uma capa
    if ($book && $book->capa) {
        // Deleta o arquivo da imagem da AWS S3
        Storage::disk('s3')->delete($book->capa);
    }

    // Agora você pode excluir o livro do banco de dados (ou qualquer outra lógica que você tenha)

    $this->service->delete($id);

        $this->service->delete($id);

        return response()->json([], 204);
    }
}

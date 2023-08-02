<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateBook;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\DTO\CreateBookDTO;
use App\DTO\UpdateBookDTO;

class BookController extends Controller
{

    public function __construct(
        protected BookService $service
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
        $filters = ['filter' => $request->get('filter', '')];
        return view('books', compact('books', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateBook $request)
    {
        $this->service->new(
            CreateBookDTO::makeFromRequest($request)
        );

        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(!$book = $this->service->findOne($id)) {
            return redirect()->back();
        }
        return view('admin.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(!$book = $this->service->findOne($id)) {
            return redirect()->back();
        }
        return view('admin.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateBook $request, string $id)
    {
        $book = $this->service->update(
            UpdateBookDTO::makeFromRequest($request, $id)
        );
        if (!$book) {
            return back();
        }

        return redirect()->route('books.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         // Obtenha o livro pelo ID (supondo que você esteja usando um Eloquent Model)
    $book = Book::find($id);

    // Verifique se o livro existe e se ele possui uma capa
    if ($book && $book->capa) {
        // Deleta o arquivo da imagem da AWS S3
        Storage::disk('s3')->delete($book->capa);
    }

    // Agora você pode excluir o livro do banco de dados (ou qualquer outra lógica que você tenha)

    $this->service->delete($id);

        return redirect()->route('books.index');
    }
}

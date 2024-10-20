<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\Board;
use App\Models\Author;
use App\Models\Subject;
use App\Models\Standard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BookRepository;
use App\Http\Requests\StoreBookRequest;

class BookController extends Controller
{
    public $book;

    public function __construct(BookRepository $bookRepository)
    {
        $this->book = $bookRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boards = Board::all();
        $standards = Standard::all();
        $subjects = Subject::all();
        $authors = Author::all();
        return view('admin.books.index', compact('boards', 'standards', 'subjects', 'authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $data = $request->validated();
        $book = $this->book->store($data, $request->input('id'));

        if ($request->hasFile('media_file')) {
            $uploadedFile = $this->uploadFile($request->file('media_file'), 'books/img/');
            $book->img = $uploadedFile['name'];
            $book->save();
        }

        return $this->jsonResponse((bool)$book, 'Book ' . ($request->input('id') ? 'updated' : 'created') . ' successfully');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Book $book)
    {
        $bookDeletion = $book->delete();
        return $this->jsonResponse((bool)$bookDeletion, 'Book deleted successfully');
    }

    public function dataTable()
    {
        $data = $this->generateDataTableData($this->book);
        return response()->json($data);
    }
}

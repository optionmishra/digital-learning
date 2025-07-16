<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Http\Resources\BooksResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::query()->with(['subject', 'standard']);

        // Apply filters
        if ($request->has('subject_ids')) {
            $query->whereIn('subject_id', explode(',', $request->subject_ids));
        }

        if ($request->has('standard_ids')) {
            $query->whereIn('standard_id', explode(',', $request->standard_ids));
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        $books = $query->get();

        return $this->sendAPIResponse(BooksResource::collection($books), 'Books fetched successfully.');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::find($id);
        if ($book) {
            return $this->sendAPIResponse(BookResource::make($book, false), 'Book fetched successfully.');
        }

        return $this->sendAPIError('Book not found.');
    }

    public function getBooksBySubjectId(string $id)
    {
        $books = Book::where('subject_id', $id)->get();
        if ($books->count()) {
            return $this->sendAPIResponse(BooksResource::collection($books), 'Books fetched successfully.');
        }

        return $this->sendAPIError('Books not found.');
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
    public function destroy(string $id)
    {
        //
    }
}

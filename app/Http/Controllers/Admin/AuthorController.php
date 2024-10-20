<?php

namespace App\Http\Controllers\Admin;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\AuthorRepository;
use App\Http\Requests\StoreAuthorRequest;

class AuthorController extends Controller
{
    public $author;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->author = $authorRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.authors.index');
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
    public function store(StoreAuthorRequest $request)
    {
        $data = $request->validated();
        $author = $this->author->store($data, $request->input('id'));

        return $this->jsonResponse((bool)$author, 'Author ' . ($request->input('id') ? 'updated' : 'created') . ' successfully');
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
    public function destroy(Request $request, Author $author)
    {
        $authorDeletion = $author->delete();
        return $this->jsonResponse((bool)$authorDeletion, 'Author deleted successfully');
    }

    public function dataTable()
    {
        $data = $this->generateDataTableData($this->author);
        return response()->json($data);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBoardRequest;
use App\Models\Board;
use App\Repositories\BoardRepository;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public $board;

    public function __construct(BoardRepository $boardRepository)
    {
        $this->board = $boardRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.boards.index');
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
    public function store(StoreBoardRequest $request)
    {
        $data = $request->validated();
        $board = $this->board->store($data, $request->input('id'));

        if ($request->hasFile('media_file')) {
            $uploadedFile = $this->uploadFile($request->file('media_file'), 'boards/img/');
            $board->media()->create(['file' => $uploadedFile['name'], 'type' => $uploadedFile['type']]);
        }

        return $this->jsonResponse((bool) $board, 'Board '.($request->input('id') ? 'updated' : 'created').' successfully');
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
    public function destroy(Request $request, Board $board)
    {
        $boardDeletion = $board->delete();

        return $this->jsonResponse((bool) $boardDeletion, 'Board deleted successfully');
    }

    public function dataTable()
    {
        $data = $this->generateDataTableData($this->board);

        return response()->json($data);
    }
}

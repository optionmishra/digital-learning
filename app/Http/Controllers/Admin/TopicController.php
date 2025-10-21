<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTopicRequest;
use App\Models\Book;
use App\Models\Standard;
use App\Models\Subject;
use App\Models\Topic;
use App\Repositories\TopicRepository;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public $topic;

    public function __construct(TopicRepository $topic)
    {
        $this->topic = $topic;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $standards = Standard::all();
        $subjects = Subject::all();
        $books = Book::all();

        return view('admin.topics.index', compact('standards', 'subjects', 'books'));
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
    public function store(StoreTopicRequest $request)
    {
        $data = $request->validated();
        $topic = $this->topic->store($data, $request->input('id'));

        return $this->jsonResponse((bool) $topic, 'Topic '.($request->input('id') ? 'updated' : 'created').' successfully');
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
    public function destroy(Request $request, Topic $topic)
    {
        $topicDeletion = $topic->delete();

        return $this->jsonResponse((bool) $topicDeletion, 'Topic deleted successfully');
    }

    public function dataTable()
    {
        $data = $this->generateDataTableData($this->topic);

        return response()->json($data);
    }
}

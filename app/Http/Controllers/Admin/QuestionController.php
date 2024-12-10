<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\Topic;
use App\Models\Subject;
use App\Models\Question;
use App\Models\Assessment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\QuestionRepository;
use App\Http\Requests\StoreQuestionRequest;

class QuestionController extends Controller
{
    public $question;
    public function __construct(QuestionRepository $question)
    {
        $this->question = $question;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::all();
        $books = Book::all();
        $topics = Topic::all();
        $assessments = Assessment::all();
        return view('admin.questions.index', compact('subjects', 'books', 'topics', 'assessments'));
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
    public function store(StoreQuestionRequest $request)
    {
        $data = $request->validated();
        $question = $this->question->store($data, $request->input('id'));
        foreach (range(1, 4) as $i) {
            $question->options()->create([
                'option_text' => $data["option_$i"],
                'is_correct' => $data['correct_option'] == $i
            ]);
        }

        $assessment = Assessment::find($data['assessment_id']);
        $assessment->questions()->syncWithoutDetaching($question->id);

        return $this->jsonResponse((bool)$question, 'Question ' . ($request->input('id') ? 'updated' : 'created') . ' successfully');
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
    public function destroy(Request $request, Question $question)
    {
        $questionDeletion = $question->delete();
        return $this->jsonResponse((bool)$questionDeletion, 'Question deleted successfully');
    }
    public function dataTable()
    {
        $data = $this->generateDataTableData($this->question);
        return response()->json($data);
    }
}

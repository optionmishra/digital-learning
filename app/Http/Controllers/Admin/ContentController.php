<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\Topic;
use App\Models\Content;
use App\Models\Subject;
use App\Models\Standard;
use App\Models\ContentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ContentRepository;
use App\Http\Requests\StoreContentRequest;

class ContentController extends Controller
{
    public $content;

    public function __construct(ContentRepository $contentRepository)
    {
        $this->content = $contentRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $contentType = ContentType::find($request->input('type'));
        session(['type' => $request->input('type')]);
        $standards = Standard::all();
        $subjects = Subject::all();
        $books = Book::all();
        $topics = Topic::all();

        return view('admin.contents.index', compact('contentType', 'standards', 'subjects', 'books', 'topics'));
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
    public function store(StoreContentRequest $request)
    {
        $data = $request->validated();
        $data['src'] = $data['src_type'] === 'file' ?  '' : $data['url'];
        $content = $this->content->store($data, $request->input('id'));

        if ($request->hasFile('img')) {
            $uploadedFile = $this->uploadFile($request->file('img'), 'contents/img/');
            $content->img = $uploadedFile['name'];
            $content->save();
        }
        if ($request->hasFile('file')) {
            $uploadedFile = $this->uploadFile($request->file('file'), 'contents/file/');
            $content->src = $uploadedFile['name'];
            $content->save();
        }

        return $this->jsonResponse((bool)$content, 'Content ' . ($request->input('id') ? 'updated' : 'created') . ' successfully');
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
    public function destroy(Request $request, Content $content)
    {
        $contentDeletion = $content->delete();
        return $this->jsonResponse((bool)$contentDeletion, 'Content deleted successfully');
    }

    public function generateDataTableData($repository)
    {
        $type = session('type');
        $start = request()->get('start');
        $length = request()->get('length');
        $sortColumn = request()->get('order')[0]['name'] ?? 'id';
        $sortDirection = request()->get('order')[0]['dir'] ?? 'asc';
        $searchValue = request()->get('search')['value'];
        $columns = array_map(fn($column) => $column['data'], request()->get('columns'));
       
        $count = $repository->paginated($columns, $type, $start, $length, $sortColumn, $sortDirection, $searchValue, true);
        $data = $repository->paginated($columns, $type, $start, $length, $sortColumn, $sortDirection, $searchValue);

        return $data = array(
            "draw"            => intval(request()->input('draw')),
            "recordsTotal"    => intval($count),
            "recordsFiltered" => intval($count),
            "data"            => $data
        );
    }

    public function dataTable()
    {
        $data = $this->generateDataTableData($this->content);
        return response()->json($data);
    }
}

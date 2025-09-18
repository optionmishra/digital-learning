<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContentRequest;
use App\Models\Book;
use App\Models\Content;
use App\Models\ContentType;
use App\Models\Series;
use App\Models\Standard;
use App\Models\Subject;
use App\Models\Topic;
use App\Repositories\ContentRepository;
use Illuminate\Http\Request;

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
        $series = Series::all();
        $books = Book::all();
        $topics = Topic::all();

        return view('admin.contents.index', compact('contentType', 'standards', 'subjects', 'series', 'books', 'topics'));
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
    public function store(StoreContentRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $isUpdate = $request->input('id') !== null; // Determine if it's an update operation

        // --- Handle 'src' field (content file/url) ---
        // If src_type is 'file', we avoid saving 'src' in the initial $data payload.
        // It will either remain unchanged (if no new file uploaded), or be updated later
        // after a new file is uploaded.
        if (($data['src_type'] ?? null) === 'file') {
            unset($data['src']);
        } else { // src_type is 'url' or not explicitly set (defaults to URL behavior)
            // Use $data['url'] directly, falling back to an empty string if not present.
            $data['src'] = $data['url'] ?? '';
        }
        // 'url' is a temporary request field used to populate 'src', not a model attribute itself.
        unset($data['url']);

        // --- Handle 'img' field (image file/url) ---
        // If img_type is 'file', we avoid saving 'img' in the initial $data payload.
        // It will either remain unchanged (if no new image uploaded), or be updated later
        // after a new image is uploaded.
        if (($data['img_type'] ?? null) === 'file') {
            unset($data['img']);
        } else { // img_type is 'url' or not explicitly set (defaults to URL behavior)
            // Original code used $data['img_url'] ?? ''. Maintaining this.
            $data['img'] = $data['img_url'] ?? '';
        }
        // 'img_url' is a temporary request field used to populate 'img', not a model attribute itself.
        unset($data['img_url']);

        // Store/update the content model in the database using the repository.
        // By unsetting 'src' and 'img' when their type is 'file' and no new file/image is provided,
        // we ensure the repository does not overwrite existing values with empty strings.
        $content = $this->content->store($data, $request->input('id'));

        // --- Handle actual file uploads and update content model ---
        // If a new image file was provided, upload it and update the 'img' field.
        if ($request->hasFile('img')) {
            $uploadedFile = $this->uploadFile($request->file('img'), 'contents/img/');
            $content->img = $uploadedFile['name'];
            $content->save();
        }
        // If a new content file was provided, upload it and update the 'src' field.
        if ($request->hasFile('file')) {
            $uploadedFile = $this->uploadFile($request->file('file'), 'contents/file/');
            $content->src = $uploadedFile['name'];
            $content->save();
        }

        // Return a JSON response indicating success.
        return $this->jsonResponse((bool) $content, 'Content '.($isUpdate ? 'updated' : 'created').' successfully');
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

        return $this->jsonResponse((bool) $contentDeletion, 'Content deleted successfully');
    }

    public function generateDataTableData($repository)
    {
        $type = session('type');
        $start = request()->get('start');
        $length = request()->get('length');
        $sortColumn = request()->get('order')[0]['name'] ?? 'id';
        $sortDirection = request()->get('order')[0]['dir'] ?? 'asc';
        $searchValue = request()->get('search')['value'];
        $columns = array_map(fn ($column) => $column['data'], request()->get('columns'));

        $count = $repository->paginated($columns, $type, $start, $length, $sortColumn, $sortDirection, $searchValue, true);
        $data = $repository->paginated($columns, $type, $start, $length, $sortColumn, $sortDirection, $searchValue);

        return $data = [
            'draw' => intval(request()->input('draw')),
            'recordsTotal' => intval($count),
            'recordsFiltered' => intval($count),
            'data' => $data,
        ];
    }

    public function dataTable()
    {
        $data = $this->generateDataTableData($this->content);

        return response()->json($data);
    }
}

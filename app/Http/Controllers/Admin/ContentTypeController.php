<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContentTypeRequest;
use App\Models\ContentType;
use App\Repositories\ContentTypeRepository;
use Illuminate\Http\Request;

class ContentTypeController extends Controller
{
    public $contentType;

    public function __construct(ContentTypeRepository $contentTypeRepository)
    {
        $this->contentType = $contentTypeRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.content_types.index');
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
    public function store(StoreContentTypeRequest $request)
    {
        $data = $request->validated();
        $contentType = $this->contentType->store($data, $request->input('id'));

        // if ($request->hasFile('media_file')) {
        //     $uploadedFile = $this->uploadFile($request->file('media_file'), 'contentTypes/img/');
        //     $contentType->media()->create(['file' => $uploadedFile['name'], 'type' => $uploadedFile['type']]);
        //     $contentType->img = $uploadedFile['name'];
        //     $contentType->save();
        // }

        return $this->jsonResponse((bool) $contentType, 'ContentType '.($request->input('id') ? 'updated' : 'created').' successfully');
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
    public function destroy(Request $request, ContentType $contentType)
    {
        $contentTypeDeletion = $contentType->delete();

        return $this->jsonResponse((bool) $contentTypeDeletion, 'ContentType deleted successfully');
    }

    public function dataTable()
    {
        $data = $this->generateDataTableData($this->contentType);

        return response()->json($data);
    }
}

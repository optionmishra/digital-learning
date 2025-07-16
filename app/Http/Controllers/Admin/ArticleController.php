<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public $article;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->article = $articleRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.articles.index');
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
    public function store(StoreArticleRequest $request)
    {
        $data = $request->validated();
        $article = $this->article->store($data, $request->input('id'));

        if ($request->hasFile('img')) {
            $uploadedFile = $this->uploadFile($request->file('img'), 'articles/img/');
            // $article->media()->create(['file' => $uploadedFile['name'], 'type' => $uploadedFile['type']]);
            $article->img = $uploadedFile['name'];
            $article->save();
        }

        return $this->jsonResponse((bool) $article, 'Article '.($request->input('id') ? 'updated' : 'created').' successfully');
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
    public function destroy(Request $request, Article $article)
    {
        $articleDeletion = $article->delete();

        return $this->jsonResponse((bool) $articleDeletion, 'Article deleted successfully');
    }

    public function dataTable()
    {
        $data = $this->generateDataTableData($this->article);

        return response()->json($data);
    }
}

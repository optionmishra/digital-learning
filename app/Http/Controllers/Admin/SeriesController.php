<?php

namespace App\Http\Controllers\Admin;

use App\Models\Series;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SeriesRepository;
use App\Http\Requests\StoreSeriesRequest;

class SeriesController extends Controller
{
    public $series;

    public function __construct(SeriesRepository $seriesRepository)
    {
        $this->series = $seriesRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.series.index');
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
    public function store(StoreSeriesRequest $request)
    {
        $data = $request->validated();
        $series = $this->series->store($data, $request->input('id'));

        // if ($request->hasFile('media_file')) {
        //     $uploadedFile = $this->uploadFile($request->file('media_file'), 'series/img/');
        //     $series->media()->create(['file' => $uploadedFile['name'], 'type' => $uploadedFile['type']]);
        //     $series->img = $uploadedFile['name'];
        //     $series->save();
        // }

        return $this->jsonResponse((bool)$series, 'Series ' . ($request->input('id') ? 'updated' : 'created') . ' successfully');
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
    public function destroy(Request $request, Series $series)
    {
        $seriesDeletion = $series->delete();
        return $this->jsonResponse((bool)$seriesDeletion, 'Series deleted successfully');
    }

    public function dataTable()
    {
        $data = $this->generateDataTableData($this->series);
        return response()->json($data);
    }
}

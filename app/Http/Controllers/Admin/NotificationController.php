<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNotificationRequest;
use App\Models\Notification;
use App\Repositories\NotificationRepository;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public $notification;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notification = $notificationRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.notifications.index');
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
    public function store(StoreNotificationRequest $request)
    {
        $data = $request->validated();
        $notification = $this->notification->store($data, $request->input('id'));

        if ($request->hasFile('media_file')) {
            $uploadedFile = $this->uploadFile($request->file('media_file'), 'notifications/img/');
            $notification->media()->create(['file' => $uploadedFile['name'], 'type' => $uploadedFile['type']]);
        }

        return $this->jsonResponse((bool) $notification, 'Notification '.($request->input('id') ? 'updated' : 'created').' successfully');
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
    public function destroy(Request $request, Notification $notification)
    {
        $notificationDeletion = $notification->delete();

        return $this->jsonResponse((bool) $notificationDeletion, 'Notification deleted successfully');
    }

    public function dataTable()
    {
        $data = $this->generateDataTableData($this->notification);

        return response()->json($data);
    }
}

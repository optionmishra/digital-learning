<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $today = date('Y-m-d');
        $notifications = Notification::where('is_active', 1)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->orderBy('created_at', 'desc')
            ->get();
        if ($notifications->isNotEmpty()) {
            return $this->sendAPIResponse(NotificationResource::collection($notifications), 'Notifications fetched successfully.');
        }

        return $this->sendAPIError('Notifications not found.');
    }
}

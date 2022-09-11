<?php

namespace App\Http\Controllers\Notification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications;
use Carbon\Carbon;
use DB;

class NotificationController extends Controller
{
    /**
     * Get all notifications
     *
     * @return void
     */
    public function get()
    {
        return DB::table('notifications')
                 ->whereNull('read_at')
                 ->orderBy('created_at', 'desc')
                 ->get();
    }

    /**
     * Mark as read notifications
     *
     * @param Request $request
     * @return void
     */
    public function read(Request $request)
    {
       $notification = Notifications::find($request->id);
       $notification->forceFill(['read_at' => Carbon::now()->toDateTimeString()])->save();
    }
}

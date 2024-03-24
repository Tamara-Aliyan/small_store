<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\Api\V1\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AuthNotificationController extends Controller
{
    function index()
    {
        $admin = User::where('role', 'admin')->find(auth()->id());
        return response()->json([
            "notifications" => $admin->notifications
        ]);
    }

    function unread()
    {
        $admin = User::where('role', 'admin')->find(auth()->id());
        return response()->json([
            "notifications" => $admin->unreadNotifications
        ]);
    }

    function markReadAll()
    {
        $admin = User::where('role', 'admin')->find(auth()->id());
        foreach ($admin->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        return response()->json([
            "message" => "success"
        ]);
    }

    function deleteAll()
    {
        $admin = User::where('role', 'admin')->find(auth()->id());
        $admin->notifications()->delete();
        return response()->json([
            "message" => "deleted"
        ]);
    }

    function delete($id)
    {
        DB::table('notifications')->where('id', $id)->delete();
        return response()->json([
            "message" => "deleted"
        ]);
    }
}

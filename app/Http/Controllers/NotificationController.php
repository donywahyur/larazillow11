<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificationController extends Controller
{
    //
    public function index(Request $request)
    {
        return Inertia(
            "Notification/Index",
            [
                'notifications' => $request->user()
                    ->notifications()->paginate(10),
            ]
        );
    }
}

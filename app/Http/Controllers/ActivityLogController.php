<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    //
     public function index()
    {
        $logs = ActivityLog::with('user')->get();
        return response()->json($logs);
    }

    public function store($action, $description = null)
    {
        $user = Auth::user();

        ActivityLog::create([
            'user_id' => $user->id,
            'action' => $action,
            'description' => $description,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $data['complete_count'] = Task::where('user_id', $userId)
            ->where('status', 'completed')
            ->count();

        $data['in_progress_count'] = Task::where('user_id', $userId)
            ->where('status', 'in_progress')
            ->count();

        $data['pending_count'] = Task::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();

        $data['due_count'] = Task::where('user_id', $userId)
            ->where('due_date', '<', now()->toDateString())
            ->count();


        return view('backend.dashboard.index', $data);
    }
}

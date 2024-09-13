<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        $tasks = Task::query()
            ->where('user_id', $userId)
            ->search($request->get('search'))
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('backend.task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.task.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $requestedData = $this->validateTask($request);

            $requestedData['user_id'] = Auth::id();

            Task::create($requestedData);

            Toastr::success('Inserted successfully');

            return redirect()->route('tasks.index');
        } catch (ValidationException $e) {
            // dd($e->getMessage());
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $task->due_date = Carbon::parse($task->due_date);
        return view('backend.task.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $requestedData = $this->validateTask($request);
            // Find the task by ID
            $task = Task::findOrFail($id);

            $task->update($requestedData);

            Toastr::success('Updated successfully');

            return redirect()->route('tasks.index');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Handle other possible exceptions (e.g., record not found)
            Toastr::error('An error occurred. Please try again.');
            return redirect()->back();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        Toastr::success('Deleted successfully');

        return redirect()->route('tasks.index');
    }

    private function validateTask(Request $request)
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'due_date' => 'required|date|after_or_equal:today',
            'status' => 'required|in:pending,in_progress,completed',
        ]);
    }
}

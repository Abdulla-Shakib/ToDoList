@extends('backend.layouts.index')

@section('content')
    <div class="page-content">

        <section class="content-header">
            <div class="row d-flex justify-content-center mt-4">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Task</h3>
                        </div>

                        <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" name="title"
                                        value="{{ old('title', $task->title) }}" placeholder="Enter ...">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" rows="3" name="description" placeholder="Enter ...">{{ old('description', $task->description) }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- {{ dd($task->due_date) }} --}}
                                <div class="form-group">
                                    <label for="due_date">Due date</label>
                                    <input type="date" class="form-control" name="due_date"
                                        value="{{ old('due_date', $task->due_date->format('Y-m-d')) }}"
                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                    @error('due_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Select</label>
                                    <select class="form-control" name="status">
                                        <option value="" {{ old('status', $task->status) == '' ? 'selected' : '' }}>
                                            Select Status</option>
                                        <option value="pending"
                                            {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="in_progress"
                                            {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In
                                            Progress</option>
                                        <option value="completed"
                                            {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed
                                        </option>
                                    </select>

                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection

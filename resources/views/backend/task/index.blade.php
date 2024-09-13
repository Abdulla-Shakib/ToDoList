@extends('backend.layouts.index')

@push('style')
    <style>
        .border-radion-null {
            border-radius: 0;
        }
    </style>
@endpush

@section('content')
    <div class="page-content">
        <section class="content-header">
            <div class="row d-flex justify-content-center mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All your tasks</h3>
                        </div>
                        <div class="card-body">

                            <form method="GET" action="{{ route('tasks.index') }}">
                                <div class="input-group mb-3">
                                    <input type="search" name="search" class="form-control border-radion-null"
                                        placeholder="Search by title or description" value="{{ request()->get('search') }}">
                                    <button type="submit" class="btn btn-success border-radion-null">
                                        <i class="fas fa-search"></i> Search
                                    </button>

                                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary border-radion-null">
                                        <i class="fas fa-times"></i> Clear
                                    </a>
                                </div>
                            </form>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Title</th>
                                        <th>Due date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ($tasks as $item)
                                        <tr>
                                            <td class="text-truncate">{{ serialNumber($tasks, $loop) }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->due_date)->format('d F Y') }}</td>
                                            <td><span
                                                    class="badge bg-{{ $item->status == 'completed' ? 'success' : ($item->status == 'in_progress' ? 'warning' : 'danger') }}">{{ ucfirst($item->status) }}</span>
                                            </td>
                                            <td>
                                                <a class="text-primary" href="{{ route('tasks.edit', $item->id) }}">
                                                    <i class="fas fa-edit"></i> Edit

                                                </a>
                                                <form action="{{ route('tasks.destroy', $item->id) }}" method="post"
                                                    style="display: none;" id="delete-form-{{ $item->id }}">
                                                    @csrf
                                                    @method('Delete')
                                                </form>
                                                <a class="text-danger" href=""
                                                    onclick="if(confirm('Are You Sure To Delete?')){
                                                                        event.preventDefault();
                                                                        getElementById('delete-form-{{ $item->id }}').submit();
                                                                        }else{
                                                                        event.preventDefault();
                                                                        }">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="5">
                                                <h5 class="font-weight-bold">No tasks available</h5>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{ $tasks->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

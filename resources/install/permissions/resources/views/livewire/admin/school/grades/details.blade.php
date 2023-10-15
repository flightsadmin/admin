@extends('components.layouts.admin')
@section('title', __('Class Details'))
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="card-title">Details for: {{ $parent->name }}</h3>
                        <a class="btn btn-sm btn-secondary bi bi-backspace-fill text-decoration-none text-white" 
                            wire:navigate href="{{ URL::previous() }}"> Back </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-md-12 d-flex justify-content-between">
                        <div class="col-md-8 mt-2">
                            <div class="fw-bold">Name: {{ $parent->name }}</div>
                            <div> Email: {{ $parent->email }}</div>
                            <div> Phone: {{ $parent->phone }}</div>
                            <label>Students:</label>
                            <ol>
                                @forelse ($parent->students as $student)
                                    <li>
                                        <a wire:navigate href="{{ route('admin.students.show', ['id' => $student->id]) }}"
                                            style="text-decoration: none">{{ $student->name }}</a>
                                    </li>
                                @empty
                                    <div class="text-warning">No Students</div>
                                @endforelse
                            </ol>
                        </div>
                        <div class="col-md-4 mt-2">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

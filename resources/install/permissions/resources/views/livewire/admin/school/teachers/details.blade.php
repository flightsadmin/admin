@extends('components.layouts.admin')
@section('title', __('Teacher Details'))
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="card-title">Details for: {{ $teacher->name }}</h3>
                        <div class="btn btn-sm btn-secondary bi bi-backspace-fill">
                            <a wire:navigate href="{{ URL::previous() }}" class="text-decoration-none text-white">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-md-12 d-flex justify-content-between">
                        <div class="col-md-8 mt-2">
                            <b><i class="bi bi-person-circle text-info"></i> {{ $teacher->name }} - {{ $teacher->staff_number }}</b>
                                <div>Gender: {{ ucwords($teacher->gender) }}</div>
                                <div>Address: {{ $teacher->address }}</div>
                                <b>Classes:</b>
                                @foreach ($teacher->classes as $item)
                                    <div class="badge rounded-pill text-bg-secondary me-2">{{ $item->name }}</div>
                                @endforeach
                                <hr class="m-1">
                                <b>Subjects:</b>
                                @foreach ($teacher->subjects as $item)
                                    <div class="badge rounded-pill text-bg-secondary me-2">{{ $item->name }}</div>
                                @endforeach
                        </div>
                        <div class="col-md-4 mt-2">
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

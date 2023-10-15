@extends('components.layouts.admin')
@section('title', __('Student Details'))
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="card-title">Details for: {{ $student->name }}</h3>
                        <div class="btn btn-sm btn-secondary bi bi-backspace-fill">
                            <a wire:navigate href="{{ URL::previous() }}" class="text-decoration-none text-white">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-md-12 d-flex justify-content-between">
                        <div class="col-md-8 mt-2">
                            <div class="fw-bold">Name: {{ $student->name }}</div>
                            <div> Class: {{ $student->class->name }}</div>
                            <div> Gender: {{ ucwords($student->gender) }}</div>
                            <div> Address: {{ $student->address }}</div>
                            <label>Parent:</label>
                            <ol>
                                <li>{{ $student->parent->name }}</li>
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

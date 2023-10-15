@extends('components.layouts.admin')
@section('title', __('Teacher Details'))
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="card-title">Details for: {{ $teacher->name }}</h3>
                        <a class="btn btn-sm btn-secondary bi bi-backspace-fill text-decoration-none text-white" 
                            wire:navigate href="{{ URL::previous() }}"> Back </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-md-12 d-flex justify-content-between">
                        <div class="col-md-6 p-4 border">
                                <div class="bi bi-person-square fw-bold"> Name: {{ $teacher->name }}</div>
                                <div class="bi bi-person-vcard"> Staff ID: {{ $teacher->staff_number }}</div>
                                <div class="bi bi-person-standing-dress"> Gender: {{ ucwords($teacher->gender) }}</div>
                                <div class="bi bi-globe"> Address: {{ $teacher->address }}</div>
                        </div>
                        <div class="col-md-3 p-4 border">
                            <b>Classes:</b>
                            <ol>
                            @foreach ($teacher->classes as $item)
                                <li>{{ $item->name }}</li>
                            @endforeach
                            </ol>
                        </div>
                        <div class="col-md-3 p-4 border">
                            <b>Subjects:</b>
                            <ol>
                                @foreach ($teacher->subjects as $item)
                                    <li>{{ $item->name }}</li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

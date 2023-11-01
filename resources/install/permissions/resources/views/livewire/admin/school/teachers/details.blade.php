@extends('components.layouts.admin')
@section('title', __('Teacher Details'))
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="card-title">Details for: {{ $teacher->user->name }}</h3>
                        <a class="btn btn-sm btn-secondary bi-backspace-fill text-decoration-none text-white"
                            wire:navigate href="{{ URL::previous() }}"> Back </a>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="mt-2">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="nav-link active" id="nav-variants-tab" data-bs-toggle="tab"
                                            data-bs-target="#details" type="button">Details</button>

                                        <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab"
                                            data-bs-target="#classes" type="button">Classes</button>

                                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab"
                                            data-bs-target="#subjects" type="button">Subjects</button>
                                    </div>
                                </nav>

                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="details">
                                        <div class="col-lg-6 col-6 p-3">
                                            <div class="bi-person-square fw-bold"> Name: {{ $teacher->user->name }}</div>
                                            <div class="bi-person-vcard"> Staff ID: {{ $teacher->staff_number }}</div>
                                            <div class="bi-person-standing-dress"> Gender: {{ ucwords($teacher->gender) }}</div>
                                            <div class="bi-globe"> Address: {{ $teacher->address }}</div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade show" id="classes">
                                        <div class="col-lg-3 col-6 p-3">
                                            <b>Classes:</b>
                                            <ol>
                                                @foreach ($teacher->classes as $item)
                                                    <li>{{ $item->name }}</li>
                                                @endforeach
                                            </ol>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="subjects">
                                        <div class="col-lg-3 col-6 p-3">
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
                </div>
            </div>
        </div>
    </div>
@endsection

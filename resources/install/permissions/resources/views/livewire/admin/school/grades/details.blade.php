@extends('components.layouts.admin')
@section('title', __('Grade Details'))
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="card-title">Details for: {{ $grade->name }}</h3>
                        <a class="btn btn-sm btn-secondary bi bi-backspace-fill text-decoration-none text-white"
                            wire:navigate href="{{ URL::previous() }}"> Back </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-12">
                        <div class="mt-2">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-variants-tab" data-bs-toggle="tab"
                                        data-bs-target="#details" type="button">Details</button>

                                    <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab"
                                        data-bs-target="#teachers" type="button">Classes</button>

                                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab"
                                        data-bs-target="#subjects" type="button">Subjects</button>
                                </div>
                            </nav>

                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="details">
                                    <div class="col-lg-6 col-6 p-3">
                                        <div class="fw-bold">Name: {{ $grade->name }}</div>
                                        <label>Students:</label>
                                        <ol>
                                            @forelse ($grade->students as $student)
                                                <li>
                                                    <a wire:navigate href="{{ route('admin.students.show', ['id' => $student->id]) }}"
                                                        style="text-decoration: none">{{ $student->name }}</a>
                                                </li>
                                            @empty
                                                <div class="text-warning">No Students</div>
                                            @endforelse
                                        </ol>
                                    </div>
                                </div>

                                <div class="tab-pane fade show" id="teachers">
                                    <div class="col-lg-3 col-6 p-3">
                                        <b>Teachers:</b>
                                        <ol>

                                        </ol>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="subjects">
                                    <div class="col-lg-3 col-6 p-3">
                                        <b>Subjects:</b>
                                        <ol>

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
@endsection
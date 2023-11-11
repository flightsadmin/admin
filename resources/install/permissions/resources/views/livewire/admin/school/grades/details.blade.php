@extends('components.layouts.admin')
@section('title', __('Grade Details'))
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="card-title">Details for: {{ $grade->name }}</h3>
                        <a class="btn btn-sm btn-secondary bi-backspace-fill text-decoration-none text-white"
                            wire:navigate href="{{ URL::previous() }}"> Back </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-12">
                        <div class="mt-2">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-details-tab" data-bs-toggle="tab"
                                        data-bs-target="#details" type="button">Details</button>
                                    <button class="nav-link" id="nav-timetable-tab" data-bs-toggle="tab"
                                        data-bs-target="#timetables" type="button">Timetable</button>
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
                                                        style="text-decoration: none">{{ $student->user->name }}</a>
                                                </li>
                                            @empty
                                                <div class="text-warning">No Students</div>
                                            @endforelse
                                        </ol>
                                    </div>
                                </div>
                                <div class="tab-pane fade show" id="timetables">
                                    <div class="col-lg-12 col-12">
                                        <div class="container mt-2">
                                            <div class="calendar-grid">
                                                @foreach ($days as $item)
                                                    <div class="day">
                                                        <span class="date">{{ $item['date'] }}</span>
                                                        <div class="tasks">
                                                            @foreach ($item['timetable'] as $time)
                                                                <p class="m-0">{{ $time }}</p>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
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
    </div>
@endsection
@push('extra-css')
    <style>
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }

        .day {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 150px;
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
            position: relative;
            overflow: hidden;
        }

        .day:hover {
            background-color: #d5e5f4;
        }

        .date {
            font-weight: bold;
            position: absolute;
            top: 5px;
            left: 5px;
        }

        .tasks {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
@endpush

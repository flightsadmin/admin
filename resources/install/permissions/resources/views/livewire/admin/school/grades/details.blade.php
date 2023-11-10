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
                                    <div class="col-lg-12 col-12 p-3">
                                        <div class="row">
                                            <div class="row grid-calendar">
                                                <div class="row calendar-week-header">
                                                    @foreach ($days->take(7) as $day)
                                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 grid-cell">
                                                            <div>
                                                                <div><span>{{ $day['day'] }}</span></div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="row calendar-week">
                                                    @foreach ($days as $item)
                                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 grid-cell border">
                                                            <div>
                                                                <div>{{ $item['date'] }}</div>
                                                                <ol>
                                                                    @foreach ($item['timetable'] as $time)
                                                                        <li>{{ $time }}</li>
                                                                    @endforeach
                                                                </ol>
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
    </div>
@endsection
@push('extra-css')
    <style>
        :root {
            --min-width: 320px;
            --number-of-days: 7;
            --column-width: calc(100% / var(--number-of-days));
        }

        .grid-calendar {
            min-width: var(--min-width);
        }

        .row {
            margin: 0;
        }

        .calendar-week .grid-cell {
            background-color: #f6f6f6;
            border: 1px solid #fff;
        }

        .calendar-week-header .grid-cell>div>div {
            padding-bottom: 10px;
            height: auto;
        }

        .grid-cell {
            display: inline-block;
            float: left;
            min-height: 1px;
            padding: 0;
            position: relative;
            width: var(--column-width);

            &.previous-month {
                background-color: #e1e1e1;
                color: #a6a6a6;
            }

            &.next-month {
                background-color: #e1e1e1;
            }

            >div {
                display: flex;
                justify-content: center;
                width: 100%;

                >div {
                    height: 0;
                    padding: calc(50% / 1) 0;
                }
            }
        }
    </style>
@endpush

@extends('components.layouts.admin')
@section('title', __('Notice Details'))
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="card-title">Notice Board Details</h3>
                        <a class="btn btn-sm btn-secondary bi bi-backspace-fill text-decoration-none text-white" 
                            wire:navigate href="{{ URL::previous() }}"> Back </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-md-12 d-flex justify-content-between">
                        <div class="col-md-12 mt-2">
                            <h1 class="fw-bold">{{ $board->title }}</h1>
                            <div> {!! $board->body !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('components.layouts.admin')
@section('title', __('User Details'))
@section('content')
    <div class="col-md-4 mx-auto">
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="rounded-circle shadow" height="100" width="100" alt="User Image">
                    <h5 class="fw-bold mt-3">{{ Auth::user()->name }} - {{ Auth::user()->title }}</h5>
                    <h5><small>Member since {{ Auth::user()->created_at->format('M Y') }}</small></h5>
                </div>
            </div>
        </div>
    </div>
@endsection

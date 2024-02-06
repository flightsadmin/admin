@extends('components.layouts.admin')
@section('title', __('Dashboard'))
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5><span class="text-center bi-house-check"></span> @yield('title')</h5>
                </div>
                <div class="card-body">
                    <div class="app-content">
                        <div class="container-fluid">
                            @role('admin|super-admin')
                                @include('livewire.admin.dashboard.admin')
                            @elserole('parent')
                                @include('livewire.admin.dashboard.parent')
                            @elserole('teacher')
                                @include('livewire.admin.dashboard.teacher')
                            @elserole('student')
                                @include('livewire.admin.dashboard.student')
                            @endrole
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

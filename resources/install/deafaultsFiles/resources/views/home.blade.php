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
                            <div class="row">
                                <div class="col-lg-3 col-6">
                                    <div class="small-box text-bg-success small">
                                        <div class="inner">
                                            <h3>{{ count(config('admin.modules')) }}</h3>
                                            <p>Modules</p>
                                        </div>
                                        <i class="bi-person-gear small-box-icon"></i>
                                        <a href="#" wire:navigate
                                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                            More info <i class="bi-link-45deg"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="small-box text-bg-info small">
                                        <div class="inner">
                                            <h3>{{ count(config('admin.modules')) }}</h3>
                                            <p>Modules</p>
                                        </div>
                                        <i class="bi-person-gear small-box-icon"></i>
                                        <a href="#" wire:navigate
                                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                            More info <i class="bi-link-45deg"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="small-box text-bg-danger small">
                                        <div class="inner">
                                            <h3>{{ count(config('admin.modules')) }}</h3>
                                            <p>Modules</p>
                                        </div>
                                        <i class="bi-person-gear small-box-icon"></i>
                                        <a href="#" wire:navigate
                                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                            More info <i class="bi-link-45deg"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="small-box text-bg-warning small">
                                        <div class="inner">
                                            <h3>{{ App\Models\User::count() }}</h3>
                                            <p>User Registrations</p>
                                        </div>
                                        <i class="bi-person-fill-add small-box-icon"></i>
                                        <a href="#" wire:navigate
                                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                            More info <i class="bi-link-45deg"></i>
                                        </a>
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

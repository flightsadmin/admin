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
                                    <div class="small-box text-bg-warning">
                                        <div class="inner">
                                            <h3>{{ App\Models\Post::count() }}</h3>
                                            <p>Total Posts</p>
                                        </div>
                                        <div class="bi-person-fill-add small-box-icon"> </div>
                                        <a href="{{ route('admin') }}" wire:navigate
                                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                            More info <i class="bi-link-45deg"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-6">
                                    <div class="small-box text-bg-info">
                                        <div class="inner">
                                            <h3>{{ App\Models\User::count() }}</h3>
                                            <p>Users</p>
                                        </div>
                                        <div class="bi-person-vcard-fill small-box-icon"> </div>
                                        <a href="{{ route('admin.users') }}" wire:navigate
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
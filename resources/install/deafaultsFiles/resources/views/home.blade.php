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
                                            <h3>{{ App\Models\User::count() }}</h3>
                                            <p>User Registrations</p>
                                        </div>
                                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path
                                                d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                                            </path>
                                        </svg>
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

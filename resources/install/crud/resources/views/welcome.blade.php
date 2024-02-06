@extends('components.layouts.admin')
@section('title', __('Welcome'))
@section('content')
<div class="container-fluid">
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"><h5><span class="text-center bi-house-check"></span> @yield('title')</h5></div>
            <div class="card-body">
              <h5>  
            @guest
				Welcome to {{ config('admin.appName', 'app.name') }} !!! <br>
				Please contact admin to get your Login Credentials or click "Login" to go to your Dashboard.
			@else
				Hi {{ Auth::user()->name }}, Welcome back to {{ config('admin.appName', 'app.name') }}.
            @endif	
				</h5>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
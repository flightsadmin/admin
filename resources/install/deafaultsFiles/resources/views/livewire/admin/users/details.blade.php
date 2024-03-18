@extends('components.layouts.admin')
@section('title', __('User Profile'))
@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid rounded-circle shadow" height="130" width="130"
                            src="{{ asset('storage/' . auth()->user()->photo) }}"
                            alt="User profile picture">
                    </div>
                    <h5 class="profile-username text-center mt-4">{{ auth()->user()->name }} - {{ auth()->user()->title }}</h5>
                    <p class="text-muted text-center">{{ auth()->user()->email }}</p>
                    <p class="text-muted text-center">Member since {{ auth()->user()->created_at->format(setting('date_format')) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active bi-person-check-fill" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit"
                                type="button"
                                role="tab" aria-controls="edit" aria-selected="true"> Edit User</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link bi-key" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button"
                                role="tab" aria-controls="password" aria-selected="false"> Change Password</button>
                        </li>
                    </ul>
                    <div class="tab-content mt-3" id="content">
                        <div class="tab-pane fade show active" id="edit" role="tabpanel" aria-labelledby="edit-tab">
                            <div class="col-md-12">
                                <form wire:submit.prevent="update">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name">Name</label>
                                            <input type="text" id="name" disabled value="{{auth()->user()->name}}" placeholder="Name" class="form-control" autocomplete="off">
                                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>                                                
                                        <div class="col-md-6 mb-3">
                                            <label for="email">Email</label>
                                            <input type="email" id="email" disabled value="{{auth()->user()->email}}" placeholder="Email" class="form-control" autocomplete="off">
                                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div> 
                                        <div class="col-md-6 mb-3">
                                            <label for="phone">Phone</label>
                                            <input type="text" id="phone" disabled value="{{auth()->user()->phone}}" placeholder="Phone" class="form-control" autocomplete="off">
                                            @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div> 
                                        <div class="col-md-6 mb-3">
                                            <label for="title">Title</label>
                                            <input type="text" id="title" disabled value="{{auth()->user()->title}}" placeholder="Title" class="form-control" autocomplete="off">
                                            @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="photo">Photo</label>
                                            <input accept="image/png, image/jpeg, image/jpg" type="file" id="photo" disabled wire:model="photo" placeholder="Photo" class="form-control">
                                            @error('photo') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>                                       
                                    </div>
                                    <button type="submit" disabled class="btn btn-primary">Update</button>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                            <div class="col-md-4">
                                <form wire:submit.prevent="update">
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Current Password</label>
                                        <input type="password" disabled wire:model='current_password' class="form-control form-control-sm"
                                            id="current_password"
                                            name="current_password">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">New Password</label>
                                        <input type="password" disabled wire:model='password' class="form-control form-control-sm" id="password"
                                            name="password">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                        <input type="password" disabled wire:model='password_confirmation' class="form-control form-control-sm"
                                            id="password_confirmation"
                                            name="password_confirmation">
                                    </div>
                                    <button type="submit" disabled class="btn btn-primary">Change Password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

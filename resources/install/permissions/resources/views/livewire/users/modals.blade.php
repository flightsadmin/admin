<!-- View User Modal -->
<div wire:ignore.self class="modal fade" id="viewModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Profile</h5>
                <button wire:click="$refresh" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($userId)
                <div class="col-12 bg-white px-3 mb-3 pb-3">
                    <div class="d-flex flex-column align-items-center border-bottom">
                        <img class="profile-img mb-2" src="{{ asset('storage/' . $photo) }}"  style="height:100px; width:100px;"  alt="{{ $title }}">
                    </div>
                    <div class="d-flex align-items-center justify-content-between border-bottom">
                        <p class="py-2 bi bi-person-vcard-fill"> Full Name</p>
                        <p class="py-2 text-muted">{{ $name }}</p>
                    </div>
                    <div class="d-flex align-items-center justify-content-between border-bottom">
                        <p class="py-2 bi bi-envelope-at-fill"> Email</p>
                        <p class="py-2 text-muted"> {{ $email }}</p>
                    </div>
                    <div class="d-flex align-items-center justify-content-between border-bottom">
                        <p class="py-2 bi bi-telephone-fill"> Phone</p>
                        <p class="py-2 text-muted">{{ $phone }}</p>
                    </div>
                    <div class="d-flex align-items-center justify-content-between border-bottom">
                        <p class="py-2 bi bi-geo-alt-fill"> Title</p>
                        <p class="py-2 text-muted">{{ $title }}</p>
                    </div>
                </div>
                @else
                    <p>Loading User...</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" wire:click="$refresh">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add / Edit User Modal -->
<div wire:ignore.self class="modal fade" id="dataModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><h4>{{ $userId ? 'Edit User' : 'Create New User' }}</h4></h5>
                <button wire:click="$refresh" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name">Name</label>
                            <input type="text" id="name" class="form-control" wire:model.blur="name" placeholder="Name" autocomplete="off">
                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>                                                
                        <div class="col-md-6 mb-3">
                            <label for="email">Email</label>
                            <input type="email" id="email" wire:model.blur="email" placeholder="Email" class="form-control" autocomplete="off">
                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div> 
                        <div class="col-md-6 mb-3">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" wire:model.blur="phone" placeholder="Phone" class="form-control" autocomplete="off">
                            @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div> 
                        <div class="col-md-6 mb-3">
                            <label for="title">Title</label>
                            <input type="text" id="title" wire:model.blur="title" placeholder="Title" class="form-control" autocomplete="off">
                            @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="photo">Photo</label>
                            <input accept="image/png, image/jpeg, image/jpg" type="file" id="photo" wire:model="photo" placeholder="Photo" class="form-control">
                            @error('photo') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        @if ($photo)
                        <div class="col-md-2 text-center" style="position: relative;">
                            <img class="profile-img mb-2" src="{{ $userId ? asset('storage/' . $photo) : $photo->temporaryUrl() }}" style="height:70px; width:70px;">
                            <a href="" wire:click.prevent="$set('photo', null)" class="bi bi-trash3-fill text-danger" style="position: absolute;"></a>
                        </div>
                        @endif
                        <div class="col-md-4 mb-3 d-flex align-items-center justify-content-evenly">
                            @if ($userId)
                                <label for="changePassword"> {{ $userId ? 'Change Password?' : '' }}</label>
                                <input type="checkbox" id="changePassword" class="form-check-input ms-2" wire:model.live="changePassword">
                                @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                            @endif
                        </div>
                        @if (!$userId || $changePassword)
                        <div class="col-md-6 mb-3">
                            <label for="password">Password</label>
                            <input type="password" id="password" wire:model.blur="password" placeholder="Password" class="form-control">
                            @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" id="password_confirmation" wire:model.blur="password_confirmation" placeholder="Confirm Password" class="form-control">
                            @error('password_confirmation') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        @endif
                        @can('editUser')
                        <div class="col-md-12">
                            <div class="col-md-12 mb-3">
                                <label class="h5">Assin Roles</label>
                                <table class="table table-sm table-bordered">
                                    <tbody>
                                        @foreach($roles as $role)
                                        <tr>
                                            <td class="text-center" width="40">
                                                <input type="checkbox" id="selectedRoles.{{ $role->id }}" wire:model.blur="selectedRoles" value="{{ $role->id }}" class="form-check-input"
                                                @checked(in_array($role->id, $selectedRoles))
                                            </td>
                                            <td>
                                                <label class="form-check-label">{{ $role->name }}</label>
                                            </td>
                                        </tr>
                                        @endforeach
                                            @error('selectedRoles') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endcan
                    </div>
                </form>            
            </div>
            <div wire:loading wire:target="submit">
                <div class="custom-spin-overlay">
                    <div class="position-absolute top-50 start-50 translate-middle d-flex justify-content-center">
                        <div class="spinner-border" style="width: 6rem; height: 6rem; border-width: 0.7rem;" role="status">
                            <span class="visually-hidden">Sending User Details</span>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="modal-footer mt-3 d-flex align-items-center justify-content-between">
                <button wire:loading.attr="disabled" wire:click="$refresh" data-bs-dismiss="modal" class="btn btn-sm btn-primary">Back</button>
                <button wire:loading.attr="disabled" wire:click.prevent="submit" class="btn btn-sm btn-primary bi bi-check2-circle"> {{ $userId ? 'Edit Changes' : 'Add User'}}</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Message Toast  -->
<div  id="statusToast" class="toast position-fixed top-0 end-0 p-3 text-bg-success" style="margin-top:5px; margin-bottom:0px;" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-header text-bg-success">
    <i class="me-2 bi bi-send-fill"></i>
    <strong class="me-auto text-black">Success</strong>
    <small class="text-white">{{ now() }}</small>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body text-black text-center">
    {{ session('message') }}
  </div>
</div>
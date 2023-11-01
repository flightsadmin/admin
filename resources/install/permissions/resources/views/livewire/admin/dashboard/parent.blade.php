<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-warning">
            <div class="inner">
                <h3>{{ App\Models\User::count() }}</h3>
                <p>User Registrations</p>
            </div>
            <div class="bi-person-fill-add small-box-icon"> </div>
            <a href="{{ route('admin.users') }}" wire:navigate
                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                More info <i class="bi-link-45deg"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-success">
            <div class="inner">
                <h3>{{ App\Models\Guardian::count() }}</h3>
                <p>Parents</p>
            </div>
            <div class="bi-bar-chart-fill small-box-icon"> </div>
            <a href="{{ route('admin.parents') }}" wire:navigate
                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                More info <i class="bi-link-45deg"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-danger">
            <div class="inner">
                <h3>{{ App\Models\Student::count() }}</h3>
                <p>Total Students</p>
            </div>
            <div class="bi-person-badge small-box-icon"> </div>
            <a href="{{ route('admin.students') }}" wire:navigate
                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                More info <i class="bi-link-45deg"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-info">
            <div class="inner">
                <h3>{{ App\Models\Teacher::count() }}</h3>
                <p>Teachers</p>
            </div>
            <div class="bi-person-vcard-fill small-box-icon"> </div>
            <a href="{{ route('admin.users') }}" wire:navigate
                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                More info <i class="bi-link-45deg"></i>
            </a>
        </div>
    </div>
</div>
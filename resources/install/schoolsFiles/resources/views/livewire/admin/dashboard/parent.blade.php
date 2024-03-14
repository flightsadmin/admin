<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-warning">
            <div class="inner">
                <h3>{{ $parent->students->count() }}</h3>
                <p>Total Students</p>
            </div>
            <div class="bi-person-fill-add small-box-icon"> </div>
            <a href="{{ route('admin.users') }}" wire:navigate
                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                More info <i class="bi-link-45deg"></i>
            </a>
        </div>
    </div>
</div>
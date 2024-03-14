<div>
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-warning">
                <div class="inner">
                    <h3>{{ sprintf('%02d', $teachers->count()) }}</h3>
                    <p>Total Teachers</p>
                </div>
                <div class="bi-person-fill-add small-box-icon"> </div>
                <a href="{{ route('admin.teachers') }}" wire:navigate
                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    More info <i class="bi-link-45deg"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-success">
                <div class="inner">
                    <h3>{{ sprintf('%02d', $parents->count()) }}</h3>
                    <p>Total Parents</p>
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
                    <h3>{{ sprintf('%02d', $students->count()) }}</h3>
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
                    <h3>{{ sprintf('%02d', $classes->count()) }}</h3>
                    <p>Total Classes</p>
                </div>
                <div class="bi-person-vcard-fill small-box-icon"> </div>
                <a href="{{ route('admin.grades') }}" wire:navigate
                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    More info <i class="bi-link-45deg"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="border p-2">
        <div class="mt-2">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-variants-tab" data-bs-toggle="tab"
                        data-bs-target="#teachers" type="button">Teachers</button>

                    <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab"
                        data-bs-target="#parents" type="button">Parents</button>

                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab"
                        data-bs-target="#students" type="button">Students</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="teachers">
                    @foreach ($teachers as $teacher)
                        <div class="col-lg-6 col-6 p-3">
                            <div class="bi-person-square fw-bold"> Name: {{ $teacher->user->name }}</div>
                            <div class="bi-person-vcard"> Staff ID: {{ $teacher->user->username }}</div>
                            <div class="envelope-at-fill"> Email: {{ ucwords($teacher->user->email) }}</div>
                            <div class="bi-person-standing-dress"> Gender: {{ ucwords($teacher->gender) }}</div>
                            <div class="bi-globe"> Address: {{ $teacher->address }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="tab-pane fade show" id="parents">
                    <div class="col-lg-3 col-6 p-3">
                        <ol>
                            @foreach ($parents as $item)
                                <li>{{ $item->user->name }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>

                <div class="tab-pane fade" id="students">
                    <div class="col-lg-3 col-6 p-3">
                        <ol>
                            @foreach ($students as $item)
                                <li>{{ $item->user->name }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

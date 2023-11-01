<div>
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-warning">
                <div class="inner">
                    <h3>{{ sprintf('%02d', $teacher->classes_count) }}</h3>
                    <p>Classes</p>
                </div>
                <div class="bi-person-fill-add small-box-icon"> </div>
                <a href="{{ route('admin.users') }}" wire:navigate
                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    More info <i class="bi-link-45deg"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-info">
                <div class="inner">
                    <h3>{{ sprintf('%02d', $teacher->subjects_count) }}</h3>
                    <p>Subjects</p>
                </div>
                <div class="bi-person-vcard-fill small-box-icon"> </div>
                <a href="{{ route('admin.users') }}" wire:navigate
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
                        data-bs-target="#details" type="button">Details</button>

                    <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab"
                        data-bs-target="#classes" type="button">Classes</button>

                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab"
                        data-bs-target="#subjects" type="button">Subjects</button>
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="details">
                    <div class="col-lg-6 col-6 p-3">
                        <div class="bi-person-square fw-bold"> Name: {{ $teacher->user->name }}</div>
                        <div class="bi-person-vcard"> Staff ID: {{ $teacher->staff_number }}</div>
                        <div class="bi-person-standing-dress"> Gender: {{ ucwords($teacher->gender) }}</div>
                        <div class="bi-globe"> Address: {{ $teacher->address }}</div>
                    </div>
                </div>

                <div class="tab-pane fade show" id="classes">
                    <div class="col-lg-3 col-6 p-3">
                        <b>Classes:</b>
                        <ol>
                            @foreach ($teacher->classes as $item)
                                <li>{{ $item->name }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>

                <div class="tab-pane fade" id="subjects">
                    <div class="col-lg-3 col-6 p-3">
                        <b>Subjects:</b>
                        <ol>
                            @foreach ($teacher->subjects as $item)
                                <li>{{ $item->name }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

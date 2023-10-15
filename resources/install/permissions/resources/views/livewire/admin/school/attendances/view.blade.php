@section('title', __('Attendance'))
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <h3 class="card-title">Student Attendance</h3>
                <div>
                    <input type="date" class="form-control form-control-sm" wire:model.live="attendanceDate">
                </div>
                @if (session()->has('message'))
                    <div wire:poll class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;">
                        {{ session('message') }}
                    </div>
                @endif
                <button type="submit" class="btn btn-sm btn-primary float-end" wire:click="store">
                    <i class="bi bi-save me-2"></i> Save changes
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4 border">
                    Mark Attendance for: {{ $attendanceDate }}
                    <div>
                        Today Attendance: {{ ceil($totalAttendance->count() / $students->count()) * 100 }}%
                    </div>
                </div>
                <form class="col-lg-8 border">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $student->name }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" wire:model="attendance.{{ $student->id }}"
                                                    type="checkbox" role="switch"
                                                    {{ in_array($student->id, array_column($attendance, 'status')) ? 'checked' : '' }}
                                                    >
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script type="module">
        document.addEventListener('livewire:initialized', () => {
            @this.on('closeModal', (event) => {
                Toastify({
                    text: "Attendance record saved successfully!",
                    duration: 3000,
                    close: true,
                }).showToast();
            });
        });
    </script>
@endpush

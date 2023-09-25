@extends('components.layouts.admin')
@section('title', 'Permissions')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @livewire('permissions')
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="module">
    const toast = new bootstrap.Toast('#statusToast');
    window.addEventListener('closeModal', () => {
        toast.show();
    });
</script>
@endpush
@extends('components.layouts.admin')
@section('title', 'Users')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @livewire('users')
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="module">
    const modal = new bootstrap.Modal('#dataModal');
    const servicemodal = new bootstrap.Modal('#viewModal');
    window.addEventListener('closeModal', () => {
        modal.hide();
        servicemodal.hide();
    });

    const toast = new bootstrap.Toast('#statusToast');
    window.addEventListener('closeModal', () => {
        toast.show();
    });
</script>
@endpush
@extends('components.layouts.admin')
@section('title', __('Airlines'))
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @livewire('airlines')
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="module">
    const modal = new bootstrap.Modal('#dataModal');
    const routemodal = new bootstrap.Modal('#routeModal');
    window.addEventListener('closeModal', () => {
        modal.hide();
        routemodal.hide();
    });

    const toast = new bootstrap.Toast('#statusToast');
    window.addEventListener('closeModal', () => {
        toast.show();
    });
</script>
@endpush
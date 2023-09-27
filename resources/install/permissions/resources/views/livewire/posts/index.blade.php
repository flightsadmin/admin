@extends('components.layouts.admin')
@section('title', __('Blog'))
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @livewire('posts')
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="module">
        const quillTextarea = document.getElementById('quill-textarea');
        var quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Write something...',
            modules: {
                toolbar: [
                    [{'font': []}, {'size': []}],
                    ['bold', 'italic', 'underline', 'strike', 'code'],
                    ['link', 'image', 'video'],
                    [{ list: 'ordered' }, { list: 'bullet'}],
                    ['blockquote', 'code-block'],
                    [{ 'align': [] }],
                    [{ 'color': [] }, { 'background': [] }],
                    ['clean'],
                ]
            },
        });

        quill.on('text-change', function() {
            quillTextarea.value = quill.root.innerHTML;
        });

        quillTextarea.addEventListener('input', function() {
            quill.root.innerHTML = quillTextarea.value;
        });

        const modal = new bootstrap.Modal('#dataModal');
        window.addEventListener('closeModal', () => {
            modal.hide();
        });

        const toast = new bootstrap.Toast('#statusToast');
        window.addEventListener('closeModal', () => {
            toast.show();
        });
    </script>
@endpush

@extends('layout.default')
@section('title', 'Edit Workflows')
@section('content')
    <!-- CKEditor 4 from CDN -->
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

    <div class="page-with-help">
        <div class="page-with-help__content">
            <div class="page-with-help__form">
                <form action="{{route('workflowmanagement-update',$help->id)}}" method="post">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="text-sm-bold text-gray">Edit {{$help->title}} Workflow</div>
                <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                <h1 class="mb-4"></h1>
                <form action="{{route('workflowmanagement-update',$help->id)}}" method="post">
                    @csrf <!-- CSRF token for security -->

                    <div class="form-group">
                        <label for="question">Workflow title</label>
                        <input type="text" name="title" value="{{$help->title}}" id="question" disabled class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="question">Guidance Content</label>
                        <textarea name="guidance" id="guidance" placeholder="Enter your note" class="form-control">{{$help->content}}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>



            </div>
        </div>
    </div>
{{--    @section('scripts')--}}
    <script>
        // Wait for the window to load before initializing CKEditor
        window.onload = function() {
            initEditor();
        };
        // Function to be called once CKEditor is loaded
        function initEditor() {
            CKEDITOR.replace('guidance', {
                filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
                filebrowserImageBrowseUrl: '/ckfinder/ckfinder.html?type=Images',
                filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                filebrowserImageUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                height: 800  // Set the height to 400px, adjust as needed

            });
        }
    </script>
@stop

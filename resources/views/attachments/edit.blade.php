@extends('layout.default')
@section('title', 'Upload Attachments')
@section('content')
    <div class="page-with-help">
        <div class="page-with-help__content">
            <div class="page-with-help__form">

                @include('orders/_header')

                <h2 class="mt-4">Upload Attachments</h2>

                @include('attachments._file-buttons', ['project' => $order->project])

                <p class="my-5">
                    After you have added any required material to your OneDrive project folder,
                    click "Done Uploading" to proceed.
                </p>

                <form action="{{ route('attachments-update', $order->id) }}" method="post">
                    {!! csrf_field() !!}
                    <div class="my-4">
                        <button type="submit" class="btn btn-primary">Done Uploading</button>
                    </div>
                </form>

            </div>
            <div class="page-with-help__help">
                <h2 class="mb-4">Help: Attachments</h2>

                @include('attachments._help')
            </div>
        </div>
    </div>
@stop

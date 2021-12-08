@extends('layout/default')
@section('title', 'Project OneDrive Folder')
@section('content')
    <div class="panel panel-ribbon mw-600">

        @include('orders/_header')

        <h2 class="h3 redhead my-3">Project OneDrive Folder</h2>

        <p>
            Project OneDrive folders are assigned automatically based on the user who created the first
            order. In some cases this may not be correct and a fiscal user may manually change the
            OneDrive folder to use for this project (and all of its orders).
        </p>

        <div class="alert alert-warning">
            If you change folders <strong>YOUR ARE RESPONSIBLE</strong> for moving any existing files
            to the correct location for this project.
        </div>

        <form method="post" action="{{ route('folder-update', $order->id) }}">
            {!! csrf_field() !!}

            @inputBlock('url', 'OneDrive Folder')

            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
@stop

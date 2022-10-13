@extends('layout.default')
@section('title', 'Not Authorized')
@section('content')

    <div class="panel-area container mw-800">
        <div class="panel">
            <h1>@icon('user-lock mr-2') Not Authorized</h1>

            <div class="mx-5">
                <p>{{ $exception->getMessage() }}</p>

                <p class="mt-4">
                    This is a fiscal request tracking system for the University of Washington,
                    Information School. If you should have access to this system, email
                    <a href="mailto:uworgtreq@uw.edu">uworgtreq@uw.edu</a> for help.
                </p>
            </div>
        </div>
    </div>

@stop

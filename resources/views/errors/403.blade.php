@extends('layout.default')
@section('title', 'Not Authorized')
@section('content')

    <div class="panel-area container mw-800">
        <div class="panel">
            <h1>@icon('user-lock mr-2') Not Authorized</h1>

            <div class="mx-5">
                <p>{{ $exception->getMessage() }}</p>

                <p class="mt-4">
                    This is a fiscal request tracking system for the {{ config('custom.scl_long') }}. If you should have access to this system, email
                    <a href="mailto:{{ config('custom.scl_email_helpdesk') }}">{{ config('custom.scl_email_helpdesk') }}</a> for help.
                </p>
            </div>
        </div>
    </div>

@stop

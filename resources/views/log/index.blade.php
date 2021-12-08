@extends('layout/default')
@section('title', 'Log')
@section('content')
    <div class="panel panel-ribbon mw-1200">

    @include('orders/_header')

    <h2 class="h4">Log</h2>

    @include('log/_table')

    </div>
@stop

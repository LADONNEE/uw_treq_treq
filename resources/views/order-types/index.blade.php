@extends('layout.default')
@section('title', 'Travel & Requisitions')
@section('content')
    <div class="py-5 bg-white">
        <div class="container mw-1000">

            <div class="float-right"><a href="{{ route('help', 'about') }}">About TREQ</a></div>

            <h1>Travel &amp; Requisitions</h1>

            @include('order-types._menu-annotated')
        </div>
    </div>
@stop

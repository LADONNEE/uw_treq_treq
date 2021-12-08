@extends('layout.default')
@section('title', 'Person')
@section('content')

    <h1>Person</h1>

    <div class="mw-600">
        <input type="text" class="form-control mb-2 person-typeahead" placeholder="Search by name or NetID" value="" data-for="person_id_test">
        <input type="text" id="person_id_test" class="form-control" value="">
    </div>
@stop

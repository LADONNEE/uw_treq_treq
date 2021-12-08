@extends('layout/default')
@section('title', "Pending Tasks: {$fullName}")
@section('content')
    <div class="panel panel-ribbon mw-1000">
        <h1 class="mb-5">Pending Tasks: {{ $fullName }}</h1>

        <table class="table-tight sortable">
            <thead>
            <tr>
                <th style="width: 8rem;">Project #</th>
                <th style="width:15%;">Submitted</th>
                <th>Title</th>
                <th style="width:20%;">Pending Task</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tasks as $task) <?php $order = $task->order; ?>

                <tr>
                    <td><a href="{{ route('order', $order->id) }}" class="js-link-row">@projectNumber($order)</a></td>
                    <td>
                        <div>{{ eDate($order->submitted_at) }}</div>
                        <div class="text-sm text-muted">{{ eFirstLast($order->submitter) }}</div>
                    </td>
                    <td>
                        <div><a href="{{ route('order', $order->id) }}" class="js-link-row">{{ $order->project->title }}</a></div>
                        <div class="text-sm text-muted">{{ $order->typeName() }}</div>
                    </td>
                    <td>
                        <div>{{ $task->name }}</div>
                        <div class="text-sm text-muted">Created {{ eDate($task->created_at) }}</div>
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
    </div>
@stop

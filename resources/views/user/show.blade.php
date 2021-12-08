@extends('layout/default')
@section('title', eFirstLast($user))
@section('content')
    <div class="panel-area container">
        <section class="panel">

            <h1 class="mb-4">User Orders</h1>

            <p>Orders created by {{ eFirstLast($user) }}.</p>

            @if(count($orders) === 0)

                <div class="empty-table my-3">
                    No orders created by {{ eFirstLast($user) }}.
                </div>

            @else

                <div class="panel-full-width mb-5">
                    <table class="table-tight sortable">
                        <thead>
                        <tr>
                            <th style="width: 8rem;">Project #</th>
                            <th style="width:15%;">Submitted</th>
                            <th>Title</th>
                            <th style="width:20%;">Last Action</th>
                            <th style="width:20%;">Stage</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)

                            @if($order->submitted_at)

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
                                        <div>{{ $order->tracking->last_action }}</div>
                                        <div class="text-sm text-muted">{{ $order->tracking->last_actor }} {{ eDate($order->tracking->last_at) }}</div>
                                    </td>
                                    <td>
                                        <div>{{ $order->tracking->next_action }}</div>
                                        <div class="text-sm text-muted">{{ $order->tracking->next_actors }}</div>
                                    </td>
                                </tr>

                            @else

                                <tr>
                                    <td><a href="{{ route('order', $order->id) }}" class="js-link-row">@projectNumber($order)</a></td>
                                    <td><span class="empty">Not Submitted</span></td>
                                    <td>
                                        <div><a href="{{ route('order', $order->id) }}" class="js-link-row">{{ $order->project->title }}</a></div>
                                        <div class="text-sm text-muted">{{ $order->typeName() }}</div>
                                    </td>

                                    <td>
                                        <div>Started</div>
                                        <div class="text-sm text-muted">{{ eFirstLast($order->submitter) }} {{ eDate($order->created_at) }}</div>
                                    </td>
                                    <td>
                                        <div>Finish Submitting</div>
                                        <div class="text-sm text-muted">{{ eFirstLast($order->submitter) }}</div>
                                    </td>
                                </tr>

                            @endif

                        @endforeach

                        </tbody>
                    </table>
                </div>

            @endif


        </section>
    </div>
@stop

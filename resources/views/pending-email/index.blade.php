@extends('layout.default')
@section('title', 'Pending Email')
@section('content')
    <div class="panel-area container">
        <section class="panel">

            <h1>Pending Email</h1>

            <p>
                TREQ sends email on a delay to reduce excess notifications for tasks that were quickly
                completed, orders that were quickly canceled or completed, or mistakes in data entry.
            </p>

            <p>
                TREQ sends pending email notifications once every 15 minutes. During each email cycle TREQ
                sends notifications for Tasks and Approvals that were added at least 15 minutes ago. In the
                extreme case a Task notification email may not be sent for 29 minutes and 59 seconds.
            </p>

            @if($last)
                <div class="alert alert-info my-4">Email was last sent {{ $last }}.</div>
            @endif

            <p>
                Following are Tasks and Approvals in the system on pending orders where the email has not
                yet been sent. These emails will be sent in the next batch after the notification is 15
                minutes old.
            </p>

            @if(count($report) > 0)

                <table class="table-tight">
                    <thead>
                    <tr>
                        <th>Project #</th>
                        <th>Title</th>
                        <th>Email To</th>
                        <th>Notification Type</th>
                    </tr>
                    </thead>

                    @foreach($report as $item)

                        <tr>
                            <td><a href="{{ route('order', $item->order_id) }}">@projectNumber($item->project_id)</a></td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->to }}</td>
                            <td>{{ $item->type }}</td>
                        </tr>

                    @endforeach
                </table>

            @else

                <div class="empty-table">There are no pending messsages.</div>

            @endif


        </section>
    </div>
@stop

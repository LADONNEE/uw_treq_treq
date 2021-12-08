@if(count($logs) > 0)

    <table class="table-tight mt-4">
        <thead>
        <tr>
            <th style="width: 25%;">Timestamp</th>
            <th style="width: 20%;">Actor</th>
            <th>Log message</th>
        </tr>
        </thead>

        <tbody>
        @foreach($logs as $log)
            <tr>
                <td>{{ $log->created_at->format('Y M j D H:i:s') }}</td>
                <td>{{ eFirstLast($log->actor) }}</td>
                <td style="line-break: anywhere;">{{ $log->message }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@else

    <div class="empty-table">
        No log messages. Logging begins when order is submitted.
    </div>

@endif

@extends('layout/default')
@section('title', 'User Tasks')
@section('content')
    <div class="panel panel-ribbon mw-1000">
        <h1>User Tasks</h1>



        <p>Users that have pending tasks assigned.</p>
        <div class="row">
            <div class="col-md-8">
            </div>
            <div class="col-md-4">

                <button id="toggle-filters" class="btn btn-primary mb-2">Toggle Filters</button>
        <div class="download_link">
            <a href="{{ downloadHref() }}">Download CSV spreadsheet</a>
        </div>
            </div>
        </div>

        <p>Users that have pending tasks assigned.</p>

        <table class="table-tight">
            <thead>
            <tr>
                <th>User</th>
                <th>Task Count</th>
                <th>Earliest Task</th>
            </tr>
            </thead>

            <tbody>
            @foreach($usersWithTasks as $user)

                <tr>
                    <td>
                        @if($user->uwnetid)
                            <a href="{{ route('user-tasks', $user->uwnetid) }}">
                                {{ "$user->firstname $user->lastname" }} ({{ $user->uwnetid }})
                            </a>
                        @else
                            {{ "$user->firstname $user->lastname" }} (NO NETID {{ $user->person_id }})
                        @endif
                    </td>
                    <td>{{ $user->num_pending }} pending tasks</td>
                    <td>{{ eDate($user->earliest_at) }}</td>
                </tr>

            @endforeach
            </tbody>
        </table>
    </div>
@stop
<!-- jQuery -->
@section('scripts')
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- DataTables -->
    <script defer type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            console.log('currentTable1')
            // DataTable initialization
            var table = $('.table-tight').DataTable({
                "searching": true,
                "paging": false,
                "info": false,
                "initComplete": function() {
                    var api = this.api();
                    // Ensure the filter-row class is added
                    var row = $('<tr/>', {
                        'class': 'filter-row' // This ensures the row can be toggled
                    }).appendTo(api.table().header());

                    api.columns().eq(0).each(function(index) {
                        var column = api.column(index);
                        var title = $(column.header()).text();
                        $('<th>').append(
                            $('<input>', {
                                type: 'text',
                                'class': 'form-control',
                                placeholder: 'Search ' + title,
                                on: {
                                    keyup: function() {
                                        column.search(this.value).draw();
                                    },
                                    change: function() {
                                        column.search(this.value).draw();
                                    }
                                }
                            })
                        ).appendTo(row);
                    });
                }
            });

            // Toggle functionality
            $('#toggle-filters').on('click', function() {
                $('.filter-row').toggle(); // This should now correctly target the filter row
            });
        });

    </script>

@endsection

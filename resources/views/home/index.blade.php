@extends('layout.default')
@section('title', 'Travel & Requisitions')
@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <style>
        .dataTables_filter {
            display: none;
        }

        .filter-row {
            display: none; /* Hide filter row initially */
        }

        table.dataTable thead .sorting {
            background-image: url("treq/images/sort_both.png")
        }

    </style>
@endsection
@section('content')
    <div class="py-5 bg-white">
        <div class="container mw-1000">

            <div class="float-right text-right">
                <a href="{{ route('help', 'about') }}">About TREQ</a> @bar
                <a href="{{ route('order-types') }}">Help Order Types</a>
            </div>

            <h1>Travel &amp; Requisitions</h1>

            <div class="order-menu my-4">
                @foreach($types as $type)
                    <a class="order-menu__button" href="{{ route('project-create', $type->slug) }}">
                        <span>@icon($type->icon)</span> {{ $type->name }}
                    </a>
                @endforeach
            </div>

        </div>
    </div>

    @include('home._jump-nav')

    <div class="panel-area container">

    <div class="panel">

        @includeWhen($reports->tasks->count > 0, 'home._needs-action', [
            'orders' => $reports->tasks->orders,
            'count' => $reports->tasks->count,
        ])

        @includeWhen($reports->creating->count > 0, 'home._creating', [
            'orders' => $reports->creating->orders,
            'count' => $reports->creating->count,
        ])

        @include('home._my-orders', [
            'orders' => $reports->myOrders->orders,
            'count' => $reports->myOrders->count,
        ])

        @includeWhen($reports->myTrips->count > 0, 'home._my-trips', [
            'projects' => $reports->myTrips->projects,
            'count' => $reports->myTrips->count,
        ])

    </div>

    @if(hasRole('treq:fiscal'))

        <div class="panel mt-4">

            <p class="text-sm text-muted pb-3 border-bottom">
                This section is for the fiscal team and includes orders submitted by all users.
                Shown to users with Fiscal role.
            </p>

            @include('home._on-call', [
                'orders' => $reports->pending->orders,
                'count' => $reports->pending->count,
            ])

            @include('home._pending', [
                'orders' => $reports->pending->orders,
                'count' => $reports->pending->count,
                'countDepartment' => $reports->pending->countDepartment,
                'countBudget' => $reports->pending->countBudget,
                'countTask' => $reports->pending->countTask,
            ])

            @include('home._complete', [
                'orders' => $reports->complete->orders,
                'count' => $reports->complete->count,
            ])

        </div>

    @endif

    </div>

@stop

<!-- jQuery -->
@section('scripts')
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- DataTables -->
    <script defer type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function () {
            // Iterate over each table with the class 'table-tight'
            $('.table-tight').each(function() {
                // Initialize DataTable for the current table in the iteration
                var currentTable = $(this);
                console.log('currentTable8')
                var table = currentTable.DataTable({
                    "searching": true,
                    "paging": false,
                    "info": false,
                    "initComplete": function () {
                        var api = this.api();
                        // Create a filter row at the top of the table header
                        var filterRow = $('<tr/>', {
                            'class': 'filter-row'
                        }).appendTo(api.table().header());

                        // Create a filter cell for each column
                        api.columns().eq(0).each(function (index) {
                            var column = api.column(index);
                            var title = $(column.header()).text();
                            $('<th>').append(
                                $('<input>', {
                                    type: 'text',
                                    'class': 'form-control',
                                    placeholder: 'Search ' + title,
                                    on: {
                                        keyup: function () {
                                            column.search(this.value).draw();
                                        },
                                        change: function () {
                                            column.search(this.value).draw();
                                        }
                                    }
                                })
                            ).appendTo(filterRow);
                        });
                    }
                });
            });
            // Toggle functionality for each table's filter row
            $('.toggle-filters').on('click', function () {

                // Toggle the filter row of the table related to the clicked button
                $(this).closest('.panel-full-width').find('.table-tight .filter-row').toggle();
            });
        });


    </script>

@endsection


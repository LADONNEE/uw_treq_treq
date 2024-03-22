@extends('layout/default')
@section('title', 'Users')
@section('content')
    <div class="panel panel-ribbon mw-1000">
        <h1>Users</h1>

        @if(hasRole('user-mgmt'))

            <div class="my-4 col-12" style="display:flex">

                <div class="p-2 col-6">
                    <span>Search user in Treq database</span>
                <form method="get" action="{{ route('user-create') }}" class="form-inline">
                    {!! csrf_field() !!}
                    <input type="hidden" name="person_id" id="person_id" value="">
                    <input type="text" class="person-typeahead form-control" data-for="person_id"
                           style="width:300px;"
                           placeholder="Search by name or NetID"
                           aria-label="Search by name or NetID">
                    <button class="btn btn-secondary ml-2" type="submit">Add</button>
                </form>
            </div>

                <div class="p-2 col-6 bg-light">
                    <span>if not found, search NetID in all UW (~ 10 seconds)</span>
                    <form method="get" action="{{ route('user-import')  }}" class="form-inline">
                            {!! csrf_field() !!}
                            <input type="hidden" name="uwperson_id" id="uwperson_id" value="">
                            <input type="text" class="uwperson-typeahead form-control" data-for="uwperson_id"
                                style="width:300px;"
                                placeholder="Search by NetID only"
                                aria-label="Search by NetID only">
                        <button class="btn btn-secondary ml-2" type="submit">Import User</button>
                        <div class="input-group-append ml-2">
                            <span class="spinner-border spinner-border-sm text-primary d-none" id="search-spinner"
                                  style="color: #007bff;"></span>
                        </div>
                        </form>

                </div>


            </div>

        @endif

        <table class="table table-tight mt-3">
            <thead>
            <tr>
                <th>User</th>
                <th>UW NetID</th>
                <th>Roles</th>
                <th style="width: 200px;">OneDrive Folder</th>
                <th style="width: 5rem;">&nbsp;</th>
                <th style="width: 5rem;">&nbsp;</th>
            </tr>
            </thead>
            <tbody>

            @foreach($users as $user)

                <tr>
                    <td><a href="{{ route('user-edit', $user->uwnetid) }}">{{ eLastFirst($user) }}</a></td>
                    <td>{{ $user->uwnetid }}</td>
                    <td>{{ implode(', ', $user->getRoles()) }}</td>
                    @if ($user->folderUrl)
                        <td class="text-sm overflow-hidden" style="width: 200px;">{{ $user->folderName }}</td>
                        <td class="text-right">
                            <a href="{{ $user->folderUrl }}" title="Open OneDrive folder" target="_treq_files">
                                @icon('folder-open') Folder
                            </a>
                        </td>
                    @else
                        <td class="text-sm" style="width: 200px;"><span class="empty">(no folder)</span></td>
                        <td class="text-right">&nbsp;</td>
                    @endif
                    <td><a href="{{ route('user-orders', $user->uwnetid) }}">@icon('boxes') Orders</a></td>
                </tr>
            @endforeach

            </tbody>
        </table>

        <h2 class="mt-5">Authorization Logs</h2>

        <p>Authorization changes in the last 30 days.</p>

        @if(count($logs) > 0)

            <table class="table-tight">
                <thead>
                <tr>
                    <th>Timestamp</th>
                    <th>UW NetID</th>
                    <th>Actor</th>
                    <th>Log message</th>
                </tr>
                </thead>

                <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->created_at->format('Y M j D H:i:s') }}</td>
                        <td>{{ $log->uwnetid }}</td>
                        <td>{{ eFirstLast($log->actor) }}</td>
                        <td>{{ $log->message }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        @else

            <div class="empty-table">
                No authorization log messages.
            </div>

        @endif
    </div>
@stop

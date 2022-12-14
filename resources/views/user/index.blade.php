@extends('layout/default')
@section('title', 'Users')
@section('content')
    <div class="panel panel-ribbon mw-1000">
        <h1>Users</h1>

        @if(hasRole('user-mgmt'))

            <div class="my-4">
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

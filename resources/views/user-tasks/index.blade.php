@extends('layout/default')
@section('title', 'User Tasks')
@section('content')
    <div class="panel panel-ribbon mw-1000">
        <h1>User Tasks</h1>

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

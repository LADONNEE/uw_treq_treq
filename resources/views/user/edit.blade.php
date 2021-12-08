@extends('layout/default')
@section('title', eFirstLast($user))
@section('content')
    <div class="panel panel-ribbon mw-600">

        <h1>Edit User</h1>

        <h2 class="h3 redhead my-3">{{ eFirstLast($user) }}</h2>

        <form method="post" action="{{ action('UserController@update', $user->uwnetid) }}">
            {!! csrf_field() !!}

            <div class="form-group">
                <label for="user-file-folder">OneDrive Folder</label>
                <input type="text"
                       class="form-control"
                       id="user-file-folder"
                       name="file_folder"
                       value="{{ $userFolder->url }}"
                       aria-describedby="user-file-folder__help">
                @if($userFolder->exists)
                    <div class="my-2 text-sm text-muted" style="padding: 0 14px;">
                        Set by {{ eFirstLast($userFolder->created_by) }} {{ eDate($userFolder->updated_at) }}
                    </div>
                @endif
                <div id="user-file-folder__help" class="form-group__help">
                    Users that will enter orders should have a OneDrive folder where they will upload attachments.
                    <a href="{{ route('help', 'one-drive') }}" target="treq_help">More...</a>
                </div>
            </div>

            <dl class="help user-roles">

                <dt>
                    <input type="radio" @if($noAuth){{ 'checked' }}@endif name="role" value="" id="role-user"/>
                    <label class="user-roles__label" for="role-user">No Authorization</label>
                </dt>
                <dd>
                    <ul class="user-roles__detail">
                        <li>Remove user access to TREQ</li>
                    </ul>
                </dd>

                <dt>
                    <input type="radio" @if($user->hasRole('treq:user')){{ 'checked' }}@endif name="role" value="treq:user" id="role-user"/>
                    <label class="user-roles__label" for="role-user">User</label>
                </dt>
                <dd>
                    <ul class="user-roles__detail">
                        <li>View orders</li>
                        <li>Respond to approvals</li>
                        <li>Add notes</li>
                    </ul>
                </dd>

                <dt>
                    <input type="radio" @if($user->hasRole('treq:requester')){{ 'checked' }}@endif name="role" value="treq:requester" id="role-requester"/>
                    <label class="user-roles__label" for="role-requester">Requester</label>
                </dt>
                <dd>
                    <ul class="user-roles__detail">
                        <li>Permissions of <strong>User</strong> plus...</li>
                        <li>Create new orders and projects</li>
                        <li>Request approvals</li>
                        <li>Requesters should have OneDrive folder</li>
                    </ul>
                </dd>

                <dt>
                    <input type="radio" @if($user->hasRole('treq:fiscal')){{ 'checked' }}@endif name="role" value="treq:fiscal" id="role-fiscal"/>
                    <label class="user-roles__label" for="role-fiscal">Fiscal</label>
                </dt>
                <dd>
                    <ul class="user-roles__detail">
                        <li>Permissions of <strong>Requester</strong> plus...</li>
                        <li>Provide fiscal approvals</li>
                        <li>Approve on behalf of another user</li>
                        <li>Cancel other user's requests</li>
                    </ul>
                </dd>

                <dt>
                    <input type="radio" @if($user->hasRole('treq:admin')){{ 'checked' }}@endif name="role" value="treq:admin" id="role-admin"/>
                    <label class="user-roles__label" for="role-admin">Admin</label>
                </dt>
                <dd>
                    <ul class="user-roles__detail">
                        <li>Permissions of <strong>Fiscal</strong> plus...</li>
                        <li>Manage users</li>
                        <li>Settings</li>
                    </ul>
                </dd>

            </dl>

            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
@stop

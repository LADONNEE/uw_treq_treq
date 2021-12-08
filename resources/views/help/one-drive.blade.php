@extends('help.help-layout')
@section('title', 'Help: OneDrive Folders')
@section('help-content')

    <h1 class="mb-4">OneDrive Folders</h1>

    <p>
        This page describes the fiscal team's role in managing TREQ attachments.
    </p>

    <h2 class="mt-4">Fiscal Team Responsibilities</h2>

    <ol style="list-style-type: decimal;">
        <li>
            <strong>Create folder in OneDrive.</strong>
        </li>
        <li>
            <strong>Set folder permissions.</strong>
        </li>
        <li>
            <strong>Update user folder in TREQ.</strong>
        </li>
    </ol>


    <h2 class="mt-4">Folder Assignment</h2>

    <p>
        TREQ expects that you will use a single OneDrive folder per Project / Trip. If
        multiple Orders are added to a Project (e.g. a Travel Pre-Auth order &plus; a
        Travel Reimbursement order) files for both those orders go in the same folder.
    </p>

    <p>
        Each user can be set up with a default folder. The OneDrive folder must be
        created by the fiscal team, permissions set, then go to TREQ user management
        and set each user's default folder.
    </p>

    <p>
        When a user creates a new Project &plus; Order their default folder will be made
        the Project's OneDrive folder.
    </p>

    <p>
        If a user adds a second Order to an existing Project, the Project folder is not
        changed. If two different users create Orders on the same Project the fiscal team
        may need to move folders, change permissions, or help uploading files.
    </p>

    <p>
        Fiscal team had permission in TREQ to change what folder to use for any given
        Project. If fiscal team decides to change folders, they are responsible for
        moving any existing attachments to the new location.
    </p>

@stop

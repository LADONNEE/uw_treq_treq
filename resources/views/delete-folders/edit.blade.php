@extends('layout.default')
@section('title', projectNumber($project) . ' Delete Folder')
@section('content')
    <div class="order-show panel-area">
        <div class="order-show__title">
            @if($project->is_travel)
                <h1>@icon('plane-departure pr-2') {{ $project->title }}</h1>
            @else
                <h1>@icon('receipt pr-2') {{ $project->title }}</h1>
            @endif
        </div>

        <div class="order-show__project">
            @if($project->is_travel)
                @include('trips._summary')
            @else
                @include('projects._summary')
            @endif
            @include('projects._files')
        </div>

        <div class="order-show__orders">
            @foreach($project->orders as $o)
                @include('orders._order-collapsed', ['order' => $o])
            @endforeach

            <section>
                <form action="{{ route('delete-folder-update', $project->id) }}" method="post">
                    {{ csrf_field() }}
                    <div class="panel mb-3">
                        <p>You must delete the old OneDrive folder for this project.</p>

                        <table class="numbered-steps">
                            <tbody>
                            <tr>
                                <th>1</th>
                                <td><a href="{{ $project->folder_url }}" target="_treq_files">Go to OneDrive</a></td>
                            </tr>
                            <tr>
                                <th>2</th>
                                <td>Delete folder @projectNumber($project)</td>
                            </tr>
                            <tr>
                                <th>3</th>
                                <td>
                                    <button type="submit" class="btn btn-primary">Mark Folder Deleted in TREQ</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </section>
        </div>

    </div>
@stop

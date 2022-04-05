@if (count($projects) > 0)

    <div class="panel-full-width mb-5">
        <table class="table-tight sortable">
            <thead>
            <tr>
                <th style="width: 8rem;">Project #</th>
                <th style="width:25%;">Trip Dates</th>
                <th>Title</th>
                <th style="width:25%;">Traveler</th>
            </tr>
            </thead>
            <tbody>
            @foreach($projects as $project)

                <tr>
                    <td><a href="{{ route('project', $project->id) }}" class="js-link-row">@projectNumber($project)</a></td>
                    <td>
                        <div>{{ eDate($project->trip->depart_at) }} &mdash; {{ eDate($project->trip->return_at) }}</div>
                    </td>
                    <td>
                        <div><a href="{{ route('project', $project->id) }}" class="js-link-row">{{ $project->title }}</a></div>
                        <div class="text-sm text-muted">{{ $project->trip->destination }}</div>
                    </td>
                    <td>
                        {{ $project->trip->traveler }}
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
    </div>

@else

    <div class="empty-table my-3">
        No matching trips.
    </div>

@endif

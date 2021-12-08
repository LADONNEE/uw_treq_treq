@if(count($projects) > 0)

    <div class="panel-full-width mb-5">
        <table class="table-tight sortable">
            <thead>
            <tr>
                <th style="width: 8rem;">Project #</th>
                <th style="width:25%;">Dates</th>
                <th>Title</th>
                <th style="width:25%;">Principle</th>
            </tr>
            </thead>
            <tbody>
            @foreach($projects as $project)

                @if($project->trip)

                    <tr>
                        <td><a href="{{ route('project', $project->id) }}" class="js-link-row">@projectNumber($project)</a></td>
                        <td>
                            <div>{{ eDate($project->trip->return_at) }} &mdash; {{ eDate($project->trip->return_at) }}</div>
                            <div class="text-sm text-muted">Travel Dates</div>
                        </td>
                        <td>
                            <div><a href="{{ route('project', $project->id) }}" class="js-link-row">{{ $project->title }}</a></div>
                            <div class="text-sm text-muted">{{ $project->trip->destination }}</div>
                        </td>
                        <td>
                            <div>{{ $project->trip->traveler }}</div>
                            <div class="text-sm text-muted">Traveler</div>
                        </td>
                    </tr>

                @else

                    <tr>
                        <td><a href="{{ route('project', $project->id) }}" class="js-link-row">@projectNumber($project)</a></td>
                        <td>
                            <div>{{ eDate($project->created_at) }}</div>
                            <div class="text-sm text-muted">Project created {{ $project->created_at->diffForHumans() }}</div>
                        </td>
                        <td>
                            <a href="{{ route('project', $project->id) }}" class="js-link-row">{{ $project->title }}</a>
                        </td>
                        <td>
                            <div>{{ eFirstLast($project->person_id) }}</div>
                            <div class="text-sm text-muted">Project Owner</div>
                        </td>
                    </tr>

                @endif

            @endforeach

            </tbody>
        </table>
    </div>

@else

    <div class="empty-table">
        {{ $empty ?? 'No matching projects or trips' }}
    </div>

@endif

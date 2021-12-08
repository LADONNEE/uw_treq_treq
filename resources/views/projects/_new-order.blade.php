<div class="two-boxes">
    <div class="two-boxes__front">
        <div id="_menu_">
            <span class="font-weight-bold">Add Order to this project:</span><br>
            {{ $project->title }}
        </div>
        <form action="{{ route('project-add-store', $project->id) }}" method="post">
            {!! csrf_field() !!}
            <input type="hidden" name="type" value="{{ '' }}">

            <div class="my-4">
                @foreach($types as $type)
                    <button class="order-add__btn order-add--primary" name="type" value="{{ $type->slug }}">
                        <span>@icon($type->icon)</span> {{ $type->name }}
                    </button>
                @endforeach
            </div>
        </form>

        <hr class="my-3">

        <p>
            You can add multiple orders to a single project. This will keep your orders organized
            and save you data entry.
        </p>

        <p>
            For example if you have a project with a Travel Pre-Authorization, request Travel
            Reimbursement on the existing project.
        </p>
    </div>

    <div class="two-boxes__back">
        <div>
            <span class="font-weight-bold">Start a new project:</span>
        </div>

        <div class="my-4">
            @foreach($types as $type)
                <a class="order-add__btn" href="{{ route('project-create', $type->slug) }}">
                    <span>@icon($type->icon)</span> {{ $type->name }}
                </a>
            @endforeach
        </div>

        <hr class="my-3">

        <p>
            If the new order is not related to the same project (it has a different owner, different
            business purpose, or is travel related to a different trip) start a new project.
        </p>
    </div>
</div>

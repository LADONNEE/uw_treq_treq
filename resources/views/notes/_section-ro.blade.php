<section class="note__column">
    @foreach($notes as $note)

        <div class="section-note mb-3">
            <div class="card-body">
                <p class="author">{{ eFirstLast($note->person) }} <span>{{ $note->created_at->diffForHumans() }}</span></p>
                <p>
                    <span class="pre-line">{{ $note->note }}</span>
                </p>
                @if($note->wasEdited())
                    <p style="font-size:11px;">{{ $note->editedMessage() }}</p>
                @endif
            </div>
        </div>

    @endforeach
</section>

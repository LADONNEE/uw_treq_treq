@if($canEdit)
    <div class="text-right text-sm-bold m-2">
        <a href="{{ route('trip-notes', $order->id) }}">Change Post Travel</a>
    </div>
@endif
<section class="mb-4 border rounded">
    @foreach($notes as $tn)

        <div class="post-travel {{ $tn->answerClass() }}">
            <div class="post-travel__label">{{ $tn->label }}</div>
            <div class="post-travel__answer">{{ eYesNo($tn->answer) }}</div>
            @if($tn->answer === 'Y' && $tn->note)
                <div class="post-travel__note">{{ $tn->note }}</div>
            @endif
        </div>

    @endforeach
</section>

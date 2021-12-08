<section class="ariba">
    @foreach($order->aribas as $ariba)

        <div class="ariba__item">
            <div class="ariba__ref">{{ $ariba->ref }}</div>
            <div class="ariba__description">
                {{ eFirstLast($ariba->person) }}
                @bar {{ $ariba->created_at }}
                @if($ariba->description)
                    @bar {{ $ariba->description }}
                @endif
            </div>
        </div>

    @endforeach

</section>

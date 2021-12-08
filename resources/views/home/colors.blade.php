@extends('layout.default')
@section('title', 'Colors')
@section('content')

    <h1>Colors</h1>

    <p>
        Color palette developed by Steve Schoger for
        <a href="https://tailwindcss.com/docs/customizing-colors">Tailwind CSS</a>.
    </p>

    <p>
        Project includes utility classes for content color "color-red-700", background color "bg-indigo-200",
        and border colors "border-green-600". It also provides SASS variables "$color-orange-700" for use in
        other components.
    </p>

    <table style="width: 100%;">
        <tr>
            @foreach($colors as $color)
                <th class="bg-{{ $color }}-700 color-{{ $color }}-100 p-4" style="width: 10%;">
                    {{ $color }}
                </th>
            @endforeach
        </tr>
        @foreach($ranks as $num)
            <tr>
                @foreach($colors as $color)
                    <td class="bg-{{ $color }}-{{ $num }} color-{{ $color }}-{{ ($num > 500) ? '100' : '900' }} p-4">
                        {{ $num }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>

@stop

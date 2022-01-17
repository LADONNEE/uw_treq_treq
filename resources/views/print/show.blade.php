<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="Cache-Control" content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $project->pageTitle() }} - TREQ - COENV - UW</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
          crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/app.css{{ $cacheBusting = '?v=' . config('view.resource_cache') }}" media="all" />
    <script defer src="/js/app.js{{ $cacheBusting }}"></script>
    <script defer src="https://kit.fontawesome.com/96343af987.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>
<body class="print-layout">
<div id="vue_app">
    @include('orders/_header')

    <div class="field">
        <div class="field__label">Business Purpose</div>
        <div class="field__value">{{ $project->purpose }}</div>
    </div>

    @include('print._order')

    @foreach($project->orders as $o)
        @if($o->id != $order->id && !$order->isCanceled())
            @include('print._order', ['order' => $o])
        @endif
    @endforeach

    <hr>

    <p>Printed {{ date('D, M j, Y g:i A') }}. Source {{ route('order', $order->id) }}</p>

</div>
</body>
</html>

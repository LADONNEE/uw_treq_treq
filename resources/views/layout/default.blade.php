<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="Cache-Control" content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - TREQ - UWORG - UW</title>
    <link rel="icon" type="image/x-icon" href="/treq/images/favicon.ico"/>
    @yield('style')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
          crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('treq/css/app.css') }}{{ $cacheBusting = '?v=' . config('view.resource_cache') }}" media="all" />
    <link rel="stylesheet" type="text/css" href="/treq/uworg-util/css/env-warning.css" type="text/css" media="all" />
    <script defer src="{{ asset('treq/js/app.js') }}{{ $cacheBusting }}"></script>
    <script defer src="https://kit.fontawesome.com/96343af987.js" crossorigin="anonymous"></script>
    <script defer type="text/javascript" src="/treq/uworg-util/js/env-warning.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>
<body>
<div class="layout__all" id="vue_app">
    <nav class="layout__header nav-uw js-scroll-lock-padding">
        <div class="nav-uw__menu">
            <button id="js-app-menu--trigger" class="nav-uw__btn" aria-label="Show Menu">@icon('bars')</button>
            <a href="{{ route('home') }}" class="nav-uw__home-link">TREQ</a>
        </div>
        <div class="nav-uw__search">
            <button class="nav-uw__btn js-search-show" aria-label="Search">
                <div class="nav-uw__mock-search">
                    @icon('search') <span>Search</span>
                </div>
            </button>
        </div>
        <div class="nav-uw__other-menu">
            
                <img src="/treq/images/iSchoolPrimary_RGB_White.svg" height="38px" style="margin-top:4px;margin-right:24px" />
            
        </div>
    </nav>
    <div id="search-bar" class="layout__search js-scroll-lock-padding" {!! (isset($searchOpen) || false) ? '' : 'style="display:none;"' !!}>
        <div class="float-right">
            <button aria-label="Close Search" class="btn-close btn-close-lg js-search-close" tabindex="0">&times;</button>
        </div>
        <div class="search-form-container">
            <form class="search-form" method="get" action="{{ route('search') }}">
                <div class="search-input-box">
                    <label for="search_bar_input" style="display:none;">Search query</label>
                    <input type="text" class="search-input" name="q" id="search_bar_input" placeholder="Search..." />
                </div>
                <button type="submit" class="search-submit-button">Go</button>
            </form>
            <a class="advanced-search-link" href="{{route('advanced-search')}}">Advanced</a>
        </div>
    </div>
    <div class="layout__menu">
        @include('layout/_app-menu')
    </div>
    <div class="layout__wrapper js-scroll-lock-padding">

        @include('layout/_flash-message')

        @yield('content')

    </div> <!-- /.layout__wrapper -->
    <div class="layout__footer footer js-scroll-lock-padding">
        <div>
            <a href="mailto:uworgtreq@uw.edu?subject=UWORG%20Website%20Question">@icon('envelope') Contact</a> &bull;
            <a href="https://uworg.uw.edu/intranet/technology-resources/">Help</a> &bull;
            <a href="http://www.washington.edu/online/privacy">Privacy</a> &bull;
            <a href="http://www.washington.edu/online/terms">Terms</a>
        </div>
        <div class="copyright">
            <a href="http://uworg.uw.edu/">&#169;{{ date('Y') }} UW Information School</a>,
            <a href="http://www.seattle.gov/">Seattle, Washington</a>
        </div>
    </div>
    <div class="modal right fade" id="_modal" tabindex="-1" role="dialog" style="display:none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div id="_modal_content"></div>
                <div id="_modal_content_panel" class="modal-content js-panel"></div>
            </div>
        </div>
    </div>
</div>

@if(config('app.env') !== 'production')
    <div id="env-warning-trigger" data-include="/env-warning.html"></div>
@endif

@yield('state')
@yield('scripts')
</body>
</html>

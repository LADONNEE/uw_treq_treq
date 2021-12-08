{{--

  Example markup for a Home Page Section
  ---------------------------------------

  div#nav-something supports the jump menu at the top of the page.

  .jump-nav__anchor positions the linked item higher to deal with the fixed top header.

  .js-collapse__button and .js-collapse__content are the hooks for the collapsible content
    javascript. .js-collapse__content must be the next sibling of .js-collapse__button.

  --}}
<section>
    <div id="nav-{{ $name }}" class="jump-nav__anchor"></div>
    <div class="js-collapse__button open" role="button" tabindex="0" aria-pressed="true">
        <h2>{{ $title }} {{ $badge ?? '' }}</h2>
    </div>
    <div class="js-collapse__content">
        {{ $slot }}
    </div>
</section>

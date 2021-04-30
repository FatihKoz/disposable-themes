<ul class="navbar-nav ml-auto d-flex align-items-center">
  {{-- Menu Items --}}
  @if(Auth::check())
    @if(Theme::getSetting('utc_clock'))
      <li class="nav-item nav-link" style="font-weight: 500;">
        <i class="fas fa-clock mr-1"></i><span id="clock"></span> UTC
      </li>
    @endif

    <li class="nav-item">
      <a class="nav-link m-1 p-1" href="{{ route('frontend.dashboard.index') }}">
        <i class="fas fa-house-user mr-1"></i>
        @lang('common.dashboard')
      </a>
    </li>

    @if(Dispo_Modules('DisposableAirlines'))
      <li>
        <a class="nav-link m-1 p-1" href="{{ route('DisposableAirlines.aindex') }}">
          <i class="fas fa-calendar-alt mr-1"></i>
          @lang('DisposableAirlines::common.airlines')
        </a>
      </li>

      <li>
        <a class="nav-link m-1 p-1" href="{{ route('DisposableAirlines.dfleet') }}">
          <i class="fas fa-plane mr-1"></i>
          @lang('DisposableAirlines::common.fleet')
        </a>
      </li>
    @endif

    @if(Dispo_Modules('DisposableHubs'))
      <li>
        <a class="nav-link m-1 p-1" href="{{ route('DisposableHubs.hindex') }}">
          <i class="fas fa-calendar-day mr-1"></i>
          {{ trans_choice('DisposableHubs::common.hub', 2) }}
        </a>
      </li>
    @endif

    <li class="nav-item">
      <a class="nav-link m-1 p-1" href="{{ route('frontend.pilots.index') }}">
        <i class="fas fa-users mr-1"></i>
        {{ trans_choice('common.pilot', 2) }}
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link m-1 p-1" href="{{ route('frontend.flights.index') }}">
        <i class="fas fa-paper-plane mr-1"></i>
        {{ trans_choice('common.flight', 2) }}
      </a>
    </li>

    @if(Dispo_Modules('DisposableTours'))
      <li>
        <a class="nav-link m-1 p-1" href="{{ route('DisposableTours.dtours') }}">
          <i class="fas fa-map-signs mr-1"></i>
          @lang('DisposableTours::common.tours')
        </a>
      </li>
    @endif

    @if(Dispo_Modules('DisposableAirlines'))
      <li>
        <a class="nav-link m-1 p-1" href="{{ route('DisposableAirlines.dpireps') }}">
          <i class="fas fa-upload mr-1"></i>
          {{ trans_choice('common.pirep', 2) }}
        </a>
      </li>
    @endif

    <li class="nav-item">
      <a class="nav-link m-1 p-1" href="{{ route('frontend.livemap.index') }}">
        <i class="fas fa-globe mr-1"></i>
        @lang('common.livemap')
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link m-1 p-1" href="{{ route('frontend.downloads.index') }}">
        <i class="fas fa-download mr-1"></i>
        {{ trans_choice('common.download', 2) }}
      </a>
    </li>

    @if(Dispo_Modules('DisposableRanks'))
      <li>
        <a class="nav-link m-1 p-1" href="{{ route('DisposableRanks.dranks') }}">
          <i class="fas fa-tags mr-1"></i>
          @lang('DisposableRanks::common.ranks')
        </a>
      </li>

      <li>
        <a class="nav-link m-1 p-1" href="{{ route('DisposableRanks.dawards') }}">
          <i class="fas fa-trophy mr-1"></i>
          @lang('DisposableRanks::common.awards')
        </a>
      </li>
    @endif

    @if(Dispo_Modules('DisposableHubs'))
      <li>
        <a class="nav-link m-1 p-1" href="{{ route('DisposableHubs.dstats') }}">
          <i class="fas fa-cog mr-1"></i>
          @lang('DisposableHubs::common.stats')
        </a>
      </li>
    @endif

    {{-- Show the module links for logged in users / auth --}}
    @foreach($moduleSvc->getFrontendLinks($logged_in=true) as &$link)
      <li class="nav-item">
        <a class="nav-link m-1 p-1" href="{{ url($link['url']) }}">
          <i class="{{ $link['icon'] }} mr-1"></i>{{ ($link['title']) }}
        </a>
      </li>
    @endforeach
  @endif

  {{-- Show the module links that don't require login / public --}}
  @foreach($moduleSvc->getFrontendLinks($logged_in=false) as &$link)
    <li class="nav-item">
      <a class="nav-link m-1 p-1" href="{{ url($link['url']) }}">
        <i class="{{ $link['icon'] }} mr-1"></i>{{ ($link['title']) }}
      </a>
    </li>
  @endforeach

  {{-- Show page links --}}
  @foreach($page_links as $page)
    <li class="nav-item">
      <a class="nav-link m-1 p-1" href="{{ $page->url }}" target="{{ $page->new_window ? '_blank':'_self' }}">
        <i class="{{ $page['icon'] }} mr-1"></i>{{ $page['name'] }}
      </a>
    </li>
  @endforeach

  {{-- Show public links for visitors --}}
  @if(!Auth::check())
    <li class="nav-item">
      <a class="nav-link m-1 p-1" href="{{ route('frontend.livemap.index') }}">
        <i class="fas fa-globe mr-1"></i>
        @lang('common.livemap')
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link m-1 p-1" href="{{ route('frontend.pilots.index') }}">
        <i class="fas fa-users mr-1"></i>{{ trans_choice('common.pilot', 2) }}
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link m-1 p-1" href="{{ url('/register') }}">
        <i class="far fa-id-card mr-1"></i>
        @lang('common.register')
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link m-1 p-1" href="{{ url('/login') }}">
        <i class="fas fa-sign-in-alt mr-1"></i>
        @lang('common.login')
      </a>
    </li>
  @endif

  {{-- Show the module links that don't require being logged in --}}
  @foreach($moduleSvc->getFrontendLinks($logged_in=false) as &$link)
    <li class="nav-item">
      <a class="nav-link m-1 p-1" href="{{ url($link['url']) }}">
        <i class="{{ $link['icon'] }} mr-1"></i>{{ ($link['title']) }}
      </a>
    </li>
  @endforeach

  @foreach($page_links as $page)
    <li class="nav-item">
      <a class="nav-link m-1 p-1" href="{{ $page->url }}" target="{{ $page->new_window ? '_blank':'_self' }}">
        <i class="{{ $page['icon'] }} mr-1"></i>{{ $page['name'] }}
      </a>
    </li>
  @endforeach

  @if(Auth::check())
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        @if (Auth::user()->avatar == null)
          <img src="{{ public_asset('/disposable/nophoto.jpg') }}" class="rounded img-mh40 border border-dark"/>
        @else
          <img src="{{ Auth::user()->avatar->url }}" class="rounded img-mh40 border border-dark">
        @endif
      </a>
      <div class="dropdown-menu bg-dropdown dropdown-menu-right">

        <a class="dropdown-item" href="{{ route('frontend.profile.index') }}">
          <i class="far fa-id-badge mr-1"></i>@lang('disposable.myprofile')
        </a>

        @if(Dispo_Modules('DisposableAirlines'))
          <a class="dropdown-item" href="{{ route('DisposableAirlines.ashow', [Auth::user()->airline->icao]) }}">
            <i class="fas fa-calendar-week mr-1"></i>@lang('disposable.myairline')
          </a>
        @endif

        @if(setting('pilots.home_hubs_only') && Dispo_Modules('DisposableHubs') && Auth::user()->home_airport_id)
          <a class="dropdown-item" href="{{ route('DisposableHubs.hshow', [Auth::user()->home_airport_id]) }}">
            <i class="fas fa-calendar-day mr-1"></i>@lang('disposable.myhub')
          </a>
        @endif

        <a class="dropdown-item" href="{{ route('frontend.pireps.index') }}">
          <i class="fas fa-file-upload mr-1"></i>@lang('disposable.mypireps')
        </a>

        @ability('admin', 'admin-access')
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ url('/admin') }}">
            <i class="fas fa-cogs mr-1"></i>@lang('common.administration')
          </a>
        @endability
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ url('/logout') }}">
          <i class="fas fa-sign-out-alt mr-1"></i>@lang('common.logout')
        </a>
      </div>
    </li>
  @endif
</ul>
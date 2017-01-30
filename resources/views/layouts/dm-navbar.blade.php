{{--<div><nav class="navbar navbar-default navbar-static-top">--}}
      {{--<div class="container">--}}
        {{--<div class="navbar-header">--}}
          {{--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">--}}
            {{--<span class="sr-only">Toggle navigation</span>--}}
            {{--<span class="icon-bar"></span>--}}
            {{--<span class="icon-bar"></span>--}}
            {{--<span class="icon-bar"></span>--}}
          {{--</button>--}}
          {{--<a class="navbar-brand" href="#">{{ config('app.name', 'Laravel') }}</a>--}}
        {{--</div>--}}
        {{--<div id="navbar" class="collapse navbar-collapse">--}}
          {{--<ul class="nav navbar-nav">--}}
            {{--<li class="active"><a href="#">Home</a></li>--}}
            {{--<li><a href="#about">About</a></li>--}}
            {{--<li><a href="#contact">Contact</a></li>--}}
            {{--<li class="dropdown">--}}
              {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>--}}
              {{--<ul class="dropdown-menu">--}}
                {{--<li><a href="#">Action</a></li>--}}
                {{--<li><a href="#">Another action</a></li>--}}
                {{--<li><a href="#">Something else here</a></li>--}}
                {{--<li role="separator" class="divider"></li>--}}
                {{--<li class="dropdown-header">Nav header</li>--}}
                {{--<li><a href="#">Separated link</a></li>--}}
                {{--<li><a href="#">One more separated link</a></li>--}}
              {{--</ul>--}}
            {{--</li>--}}
          {{--</ul>--}}
        {{--</div><!--/.nav-collapse -->--}}
      {{--</div>--}}
{{--</nav>--}}
{{--</div>--}}

<nav class="navbar navbar-default navbar-static-top">
  <div class="container">
    <div class="navbar-header">

      <!-- Collapsed Hamburger -->
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
        <span class="sr-only">Toggle Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <!-- Branding Image -->
      <a class="navbar-brand" href="{{ url('/') }}">
        {{ config('app.name', 'Laravel') }}
      </a>
    </div>

    <div class="collapse navbar-collapse" id="app-navbar-collapse">
      <!-- Left Side Of Navbar -->
      <ul class="nav navbar-nav">
        &nbsp;
      </ul>

      <!-- Right Side Of Navbar -->
      <ul class="nav navbar-nav navbar-right">
        <!-- Authentication Links -->
        @if (Auth::guest())
          <li><a href="{{ url('/login') }}">Login</a></li>
          <li><a href="{{ url('/register') }}">Register</a></li>
        @else
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
              {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <ul class="dropdown-menu" role="menu">
              <li>
                <a href="{{ url('/logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                  Logout
                </a>

                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
              </li>
            </ul>
          </li>
        @endif
      </ul>
    </div>
  </div>
</nav>
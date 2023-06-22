<nav>
    <a href="{{route('home')}}" id="logo">کارن</a>
    <i class="bx bx-menu" id="ham-menu"></i>
    <ul id="nav-bar">
      <li>
        <a href="{{route('home')}}">خانه</a>
      </li>
      <li>
        <a href="{{route('shop')}}">فروشگاه</a>
      </li>
      @if (request()->route()->getName() == 'home')
      <li>
        <a href="#about">درباره ما</a>
      </li>
      <li>
        <a href="#contact">تماس با ما</a>
      </li>
      @endif
      @auth
      @if (! auth()->user()->roles->contains('name', 'admin'))
      <li>
        <a href="{{route('panel')}}">ناحیه کاربری</a>
      </li>
      @endif
      @endauth

      @guest
        <li>
          <a href="{{route('login')}}">ورود به سیستم</a>
        </li>
      @endguest
    </ul>
  </nav>

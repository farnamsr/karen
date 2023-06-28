
  <nav id="navigation" class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button"
      data-bs-toggle="offcanvas"
      data-bs-target="#mob-side"
      aria-controls="mob-side">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <a class="navbar-brand" href="#">صنایع چوب کارن - کیا</a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin-right: 20px;">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="{{route('home')}}">خانه</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('shop')}}">فروشگاه</a>
                </li>
                @if (request()->route()->getName() == 'home')
                <li class="nav-item">
                  <a class="nav-link" href="#about">درباره ما</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#contact">تماس با ما</a>
                </li>
                @endif
                @guest
                <li class="nav-item">
                  <a class="nav-link" href="{{route('login')}}">ورود به سیستم</a>
                </li>
                @endguest
                @auth
                  @if (auth()->user()->roles->contains('name', 'admin'))
                  <li class="nav-item">
                    <a class="nav-link" href="{{route('dashboard-orders')}}">پنل مدیریت</a>
                  </li>
                  @else
                  <li class="nav-item">
                    <a class="nav-link" href="{{route('panel')}}">ناحیه کاربری</a>
                  </li>
                  @endif
                @endauth
              </ul>
      </div>
    </div>
  </nav>



  <button style="display: none"
          class="btn btn-primary"
          type="button"
          data-bs-toggle="offcanvas"
          data-bs-target="#mob-side"
          aria-controls="mob-side"
          id="mob-sidebar-btn">
    Button with data-bs-target
  </button>
  
  <div class="offcanvas offcanvas-start" tabindex="-1" id="mob-side" aria-labelledby="mob-side">
    <div class="offcanvas-header">
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <ul class="list-group list-group-flush"
              style="font-size: 18px;
              text-align: center;
              margin-top: 40px;">
              <li class="list-group-item">
                <a class="nav-link active" aria-current="page" href="{{route('home')}}">خانه</a>
              </li>
              <li class="list-group-item">
                <a class="nav-link" href="{{route('shop')}}">فروشگاه</a>
              </li>
              @guest
              <li class="list-group-item">
                <a class="nav-link" href="{{route('login')}}">ورود به سیستم</a>
              </li>
              @endguest

              @auth
              @if (auth()->user()->roles->contains('name', 'admin'))
              <li class="list-group-item">
                <a class="nav-link" href="{{route('dashboard-orders')}}">پنل مدیریت</a>
              </li>
                
              @else
              <li class="list-group-item">
                <a class="nav-link" href="{{route('panel')}}">ناحیه کاربری</a>
              </li>
              @endif
              @endauth
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
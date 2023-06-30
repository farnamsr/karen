
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
    <div class="offcanvas-header" style="display: none">
      <button id="side-close" type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <ul class="list-group list-group-flush"
              style="font-size: 18px;
              text-align: center;
              margin-top: 40px;">
              <li class="list-group-item" style="border: none;" id="mob-home">
                <a class="nav-link active" aria-current="page" href="{{route('home')}}">
                  <i class='bx bx-home-alt-2 text-secondary' ></i>
                  <span class="text-dark" style="margin-right: 6px;">خانه</span>
                </a>
              </li>
              <li class="list-group-item" style="border: none;" id="mob-shop">
                <a class="nav-link" href="{{route('shop')}}">
                  <i class='bx bx-shopping-bag text-secondary' ></i>
                  <span class="text-dark" style="margin-right: 6px;">فروشگاه</span>
                </a>
              </li>
              @guest
              <li class="list-group-item" style="border: none;" id="mob-login">
                <a class="nav-link" href="{{route('login')}}">
                  <i class='bx bx-log-in text-secondary' ></i>
                  <span class="text-dark" style="margin-right: 6px;">ورود به سیستم</span>
                </a>
              </li>
              @endguest

              @auth
              @if (auth()->user()->roles->contains('name', 'admin'))
              <li class="list-group-item">
                <a class="nav-link" href="{{route('dashboard-orders')}}">
                  <i class='bx bxs-dashboard text-secondary'></i>
                  <span class="text-dark" style="margin-right: 6px;">پنل مدیریت</span>
                </a>
              </li>
                
              @else
              <li class="list-group-item">
                <a class="nav-link" href="{{route('panel')}}">
                  <i class='bx bxs-dashboard text-secondary'></i>
                  <span class="text-dark" style="margin-right: 6px;">ناحیه کاربری</span>
                </a>
              </li>
              @endif
              @endauth
              <li class="list-group-item mt-4" id="mob-side-close" style="cursor: pointer">
                  <span class="text-danger" style="margin-right: 6px;">بستن</span>
              </li>
            </ul>
            <hr class="mt-5">
          </div>
          <div class="col-sm-12">
            <div class="d-flex justify-content-center">
              <div>
                <img height="120" src="{{asset("img/logo.png")}}" alt="">
              </div>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="d-flex justify-content-center">
              <div>
                <div class="h4">K&K Wood Works</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    .mob-active{
      background: #e8e8fb;
      border-radius: 10px;
    }
  </style>

  <script>
    let splited = window.location.href.split("/");
    let len = splited.length - 1;
    let active = splited[len];
    if (active.length < 1) {
      active = "home";
    }
    let nav = document.getElementById("mob-" + active).classList.add("mob-active");

    let mobSideClose = document.getElementById("mob-side-close");
    let sideClose = document.getElementById("side-close");
    mobSideClose.addEventListener("click", function() { sideClose.click(); })

</script>


      <nav id="sidebarMenu"
      class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse" style="font-size: 18px">
       <div class="position-sticky pt-3">
         <ul class="nav flex-column">
           <li class="nav-item">
             <a id="orders" class="nav-link" aria-current="page" href="{{route('dashboard-orders')}}">
               <span data-feather="home"></span>
                 <i class='bx bx-cart'></i> سفارشات
             </a>
           </li>
           <li class="nav-item">
             <a id="products" class="nav-link" href="{{route('dashboard-products')}}">
               <span data-feather="file"></span>
                 <i class='bx bx-library'></i> محصولات
             </a>
           </li>
           <li class="nav-item">
             <a id="users" class="nav-link" href="{{route('dashboard-users')}}">
               <span data-feather="shopping-cart"></span>
                 <i class='bx bx-user'></i> کاربران
             </a>
           </li>
           <li class="nav-item">
             <a class="nav-link" href="#">
               <span data-feather="users"></span>
                 <i class='bx bx-calculator'></i>حسابداری
             </a>
           </li>
           <li class="nav-item">
             <a class="nav-link" href="#">
               <span data-feather="bar-chart-2"></span>
                 <i class='bx bxs-store'></i> مدیریت انبار
             </a>
           </li>
{{--           <li class="nav-item">--}}
{{--             <a class="nav-link" href="#">--}}
{{--               <span data-feather="layers"></span>--}}
{{--               کارکنان--}}
{{--             </a>--}}
{{--           </li>--}}
         </ul>
       </div>
     </nav>

    <script>
        let splited = window.location.href.split("/");
        let len = splited.length - 1;
        let active = splited[len];
        let nav = document.getElementById(active).classList.add("active");
    </script>

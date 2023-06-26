

      <nav id="sidebarMenu"
      class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse" style="font-size: 18px">
       <div class="position-sticky pt-3">
         <ul class="nav flex-column">
           <li class="nav-item">
             <a id="orders" class="nav-link" aria-current="page" href="{{route('dashboard-orders')}}">
               <span data-feather="home"></span>
               سفارشات
             </a>
           </li>
           <li class="nav-item">
             <a id="products" class="nav-link" href="{{route('dashboard-products')}}">
               <span data-feather="file"></span>
               محصولات
             </a>
           </li>
           <li class="nav-item">
             <a id="users" class="nav-link" href="{{route('dashboard-users')}}">
               <span data-feather="shopping-cart"></span>
               کاربران
             </a>
           </li>
           <li class="nav-item">
             <a class="nav-link" href="#">
               <span data-feather="users"></span>
               حسابداری
             </a>
           </li>
           <li class="nav-item">
             <a class="nav-link" href="#">
               <span data-feather="bar-chart-2"></span>
               مدیریت انبار
             </a>
           </li>
           <li class="nav-item">
             <a class="nav-link" href="#">
               <span data-feather="layers"></span>
               کارکنان
             </a>
           </li>
         </ul>
       </div>
     </nav>

    <script>
        let splited = window.location.href.split("/");
        let len = splited.length - 1;
        let active = splited[len];
        let nav = document.getElementById(active).classList.add("active");
    </script>

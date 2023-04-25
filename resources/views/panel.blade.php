@extends("main")

@section("styles")
<link rel="stylesheet" href="{{asset("css/home.css")}}">
<link rel="stylesheet" href="{{asset("css/fonts.css")}}">
<link rel="stylesheet" href="{{asset("css/bootstrap.css")}}">
<style>
    .list-ic{
        margin-left: 5px;
        font-size: 25px;
        color: #007eff;
    }
</style>
@endsection

@section("navbar")
<header>
@include("components.navbar")
</header>
@endsection

@section("content")
<section>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-4 col-sm-12 mt-4">
                <div class="card w-100" style="width: 18rem; background: #f3f3f391">
                    <div class="card-body">
                      <h5 class="card-title">{{$user->name . " " . $user->lastname}}</h5>
                      <h6 class="card-subtitle mb-2 text-muted">{{$user->phone_number}}</h6>
                      <div class="wallet-info" style="display: flex; justify-content: space-between">
                        <small class="card-text">اعتبار کیف پول</small>
                        <small>1200 تومان</small>
                      </div>
                    </div>
                  </div>
                    <button class="btn btn-danger  w-100 mt-4" type="button">ثبت سفارش اختصاصی</button>
                    <button class="btn btn-primary  w-100 mt-2" type="button">پرداخت و تکمیل سفارشات</button>

                    {{-- <div class="btn-group w-100 mt-4" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-outline-primary" style="margin-left: 10px">ثبت سفارش اختصاصی</button>
                        <button type="button" class="btn btn-outline-success">پرداخت و تایید سفارشات</button>
                      </div> --}}

                    <ul class="list-group mt-5">
                        <li style="cursor: pointer;" class="list-group-item d-flex  align-items-center">
                            <i class='bx bx-cart list-ic'></i>
                          سفارشات
                        </li>
                        <li style="cursor: pointer;" class="list-group-item d-flex align-items-center">
                            <i class='bx bx-user list-ic' ></i>
                          اطلاعات حساب کاربری
                        </li>
                        <li style="cursor: pointer;" class="list-group-item d-flex align-items-center">
                            <i class='bx bx-directions list-ic' ></i>
                          آدرس ها
                        </li>
                        <li style="cursor: pointer;" class="list-group-item d-flex align-items-center">
                            <i class='bx bx-exit list-ic' ></i>
                          خروج از سیستم
                        </li>
                      </ul>
            </div>
            <div class="col-md-8 col-sm-12 mt-4">
                <div class="card">
                    <div class="card-body">
                      <h5 class="card-title text-secondary">سفارش های من</h5>
                      <div class="orders-status" style="display: flex; justify-content: space-around">
                        <div class="icon-cont text-center">
                            <i class='bx bx-cloud text-primary' style="font-size: 50px"></i>
                            <p class="text-center">12 &nbsp; جاری</p>
                        </div>
                        <div class="icon-cont text-center">
                            <i class='bx bxs-check-circle text-success' style="font-size: 50px"></i>
                            <p class="text-center">1 &nbsp; تحویل شده</p>
                        </div>
                        <div class="icon-cont text-center">
                            <i class='bx bx-arrow-back text-warning' style="font-size: 50px"></i>
                            <p class="text-center">3 &nbsp; مرجوعی</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <ul class="nav nav-tabs mt-5" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">تکمیل نشده</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">جاری</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">تحویل شده</button>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <table class="table table-striped table-hover mt-4 text-center">
                            <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">نام محصول</th>
                                  <th scope="col">تعداد</th>
                                  <th scope="col">قیمت واحد (تومان)</th>
                                  <th scope="col">قابل پرداخت</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <th scope="row">1</th>
                                  <td>Mark</td>
                                  <td>Otto</td>
                                  <td>Otto</td>
                                  <td>@mdo</td>
                                </tr>
                                <tr>
                                  <th scope="row">2</th>
                                  <td>Jacob</td>
                                  <td>Thornton</td>
                                  <td>Thornton</td>
                                  <td>@fat</td>
                                </tr>
                                <tr>
                                  <th scope="row">3</th>
                                  <td>Thornton</td>
                                  <td >Larry the Bird</td>
                                  <td >Larry the Bird</td>
                                  <td>@twitter</td>
                                </tr>
                              </tbody>
                          </table>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                  </div>
                  {{-- <div class="list-group mt-5">
                    <a href="#" class="list-group-item list-group-item-action" aria-current="true">
                      <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">List group item heading</h5>
                        <small>3 days ago</small>
                      </div>
                      <p class="mb-1">Some placeholder content in a paragraph.</p>
                      <small>And some small print.</small>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                      <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">List group item heading</h5>
                        <small class="text-muted">3 days ago</small>
                      </div>
                      <p class="mb-1">Some placeholder content in a paragraph.</p>
                      <small class="text-muted">And some muted small print.</small>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                      <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">List group item heading</h5>
                        <small class="text-muted">3 days ago</small>
                      </div>
                      <p class="mb-1">Some placeholder content in a paragraph.</p>
                      <small class="text-muted">And some muted small print.</small>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                          <h5 class="mb-1">List group item heading</h5>
                          <small class="text-muted">3 days ago</small>
                        </div>
                        <p class="mb-1">Some placeholder content in a paragraph.</p>
                        <small class="text-muted">And some muted small print.</small>
                      </a>
                  </div> --}}
            </div>
        </div>
    </div>
</section>
@endsection

@section("scripts")
<script src="{{asset("js/navbar.js")}}"></script>
@endsection

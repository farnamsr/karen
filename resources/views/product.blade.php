@extends("main")

@section("styles")
<link rel="stylesheet" href="{{asset("css/home.css")}}">
<link rel="stylesheet" href="{{asset("css/fonts.css")}}">
<link rel="stylesheet" href="{{asset("css/bootstrap.css")}}">
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
            <div class="col-md-5 col-sm-12">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img src="{{asset("img/p2.jpg")}}" class="d-block w-100" alt="...">
                      </div>
                      <div class="carousel-item">
                        <img src="{{asset("img/p3.jpg")}}" class="d-block w-100" alt="...">
                      </div>
                      <div class="carousel-item">
                        <img src="{{asset("img/p4.jpg")}}" class="d-block w-100" alt="...">
                      </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                    </button>
                  </div>
            </div>
            <div class="col-md-7 col-sm-12 mt-4"
            style="border: 1px solid #e9e9e9;padding: 30px;border-radius: 5px;">
                <div class="h2">عنوان محصول</div>
                    <p style="padding: 15px;">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت
                        چاپ و با استفاده از طراحان گرافیک است</p>
                <div class="price-text text-center">
                    <span style="padding: 15px;">قیمت: </span>
                    <span style="font-size: 20px; font-weight: bold;" class="text-success">3,500,000</span>
                    <span style="margin-right: 10px;">&nbsp;تومان&nbsp;</span>
                </div>
                <input class="form-control text-center mt-4 w-50 mx-auto" type="text" placeholder="تعداد محصول" aria-label=".form-control-sm example">
                <div class="d-grid gap-2 w-50 mt-4 mx-auto">
                    <button class="btn btn-primary" type="button">افزودن به لیست سفارشات</button>
                  </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section("scripts")
<script src="{{asset("js/navbar.js")}}"></script>
@endsection

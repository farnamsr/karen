@extends("main")

@section("styles")
<link rel="stylesheet" href="{{asset("css/home.css")}}">
<link rel="stylesheet" href="{{asset("css/fonts.css")}}">
<link rel="stylesheet" href="{{asset("css/bootstrap.css")}}">
<style>
    .img-rat {
        width: 100%;
        height: 600px;
        object-fit: cover;
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
            <div class="col-md-5 col-sm-12">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @for ($i = 0; $i < count($product->images); $i++)
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$i}}"
                          @if($i == 0) aria-current="true" class="active" @endif() aria-label="Slide {{$i + 1}}"></button>
                        @endfor
                      {{-- <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button> --}}
                    </div>
                    <div class="carousel-inner">
                        @for ($i = 0; $i < count($product->images); $i++)
                            <div class="carousel-item @if($i == 0) active @endif()">
                                @php
                                    $img = $product->images[$i];
                                    $imgName = "{$img->product_id}_{$img->id}_{$img->created_at}.{$img->ext}"
                                @endphp
                            <img src="{{asset("storage/products/{$imgName}")}}" class="d-block w-100 img-rat" alt="">
                            </div>
                            {{-- <div class="carousel-item">
                            <img src="{{asset("img/p3.jpg")}}" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                            <img src="{{asset("img/p4.jpg")}}" class="d-block w-100" alt="...">
                            </div> --}}
                        @endfor
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
                <div class="h2">{{$product->name}}</div>
                    <p style="padding: 15px;">{{$product->description}}</p>
                <div class="price-text text-center">
                    <span style="padding: 15px;">قیمت: </span>
                    <span style="font-size: 20px; font-weight: bold;" class="text-success">{{$product->price}}</span>
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

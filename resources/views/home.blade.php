@extends('main')

@section("styles")
<link rel="stylesheet" href="{{asset("css/home.css")}}">
<link rel="stylesheet" href="{{asset("css/fonts.css")}}">
<link rel="stylesheet" href="{{asset("css/bootstrap.css")}}">
<style>
    .btn-home{
        background: #339b6b;
        border-color:#339b6b;
    }
    .btn-home:hover, .btn-home:active, .btn-home:focus{
        background: #339b6b;
        border-color:#339b6b;
        box-shadow: none;
    }
</style>
@endsection

@section("navbar")
<header>
{{-- @include("components.navbar") --}}
@include("components.navbar")
</header>
@endsection

@section("content")
<section class="home" id="home">
    <div class="home-text">
        <h1><Span style="">تست متن</Span> ساختگی برای نمایش <br> در وبسایت <span>متن نمونه</span></h1>
        <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده<br> از طراحان گرافیک است</p>
        <a href="shop" class="btn btn-primary btn-home">برو به فروشگاه</a>
    </div>
</section>

<section class="shop" id="shop">
    <div class="heading">
        <span>پر فروش ترین ها</span>
        <h2>همین الان سفارش بده !</h2>
    </div>
    <div class="shop-container">
        @foreach ($mostSelled as $product)
        <div class="box" data-href="{{route('getProduct', $product->id)}}" style="cursor: pointer">
            <div class="box-img">
                <img src="{{$product->img_path}}" alt="">
            </div>
            <div class="title-price">
                <h3>{{$product->name}}</h3>
            </div>
            <span class="price">
                @auth
                    @if (auth()->user()->hasWholeDisc == 1 AND $product->wholesaleـdiscount != null)
                        <small style="color: gray; font-size: 12px;">تومان</small>
                        <span style="text-decoration: line-through; color:rgb(241, 167, 148);">
                            {{fa_number(number_format($product->price))}}
                        </span>
                        <br>
                        <small style="color: gray; font-size: 12px;">تومان</small>
                        <span style="">
                            @php $disc = ($product->wholesaleـdiscount * $product->price) / 100 @endphp
                            {{fa_number(number_format($product->price - $disc))}}
                        </span>
                    @else
                        <small style="color: gray; font-size: 12px;">تومان</small>
                        {{fa_number(number_format($product->price))}}
                    @endif
                @endauth
                @guest
                {{fa_number(number_format($product->price))}}
                <small style="color: gray; font-size: 12px;">تومان</small>
                @endguest
            </span>        
        </div>
        @endforeach
    </div>
</section>

<section class="new" id="new">
    <div class="heading" style="text-align: center">
        <span style="color: #518306">جدید ترین محصولات</span>
        <h2>همین الان سفارش بده !</h2>
    </div>
    <div class="new-container">
        @foreach ($newest as $product)
        <div class="box" data-href="{{route('getProduct', $product->id)}}" style="cursor: pointer">
            <div class="box-img">
                <img src="{{$product->img_path}}" alt="">
            </div>
            <div class="title-price">
                <h3>{{$product->name}}</h3>
            </div>
            <span class="price" style=" margin-bottom: 10px;">
                @auth
                    @if (auth()->user()->hasWholeDisc == 1 AND $product->wholesaleـdiscount != null)
                        <small style="color: gray; font-size: 12px;">تومان</small>
                        <span style="text-decoration: line-through; color:rgb(241, 167, 148);">
                            {{fa_number(number_format($product->price))}}
                        </span>
                        <br>
                        <small style="color: gray; font-size: 12px;">تومان</small>
                        <span style="">
                            @php $disc = ($product->wholesaleـdiscount * $product->price) / 100 @endphp
                            {{fa_number(number_format($product->price - $disc))}}
                        </span>
                    @else
                        <small style="color: gray; font-size: 12px;">تومان</small>
                        {{fa_number(number_format($product->price))}}
                    @endif
                @endauth
                @guest
                {{fa_number(number_format($product->price))}}
                <small style="color: gray; font-size: 12px;">تومان</small>
                @endguest
            </span>
        </div>
        @endforeach
    </div>
</section>

<section class="about" id="about">
    <div class="about-img">
        <img src="{{asset("img/about.jpg")}}" alt="">
    </div>
    <div class="about-text">
        <span>درباره ما</span>
        <h2>عنوان نمونه جهت نمایش <br> در این قسمت</h2>
        <p>صنایع چوب کارن تولیدکننده محصولات تمام چوب و روکش چوب در انواع سبک های مدرن، کلاسیک و نئوکلاسیک می باشد.</p>
        <p>صنعت چوب یا صنعت الوار، صنعتی است که به جنگلداری، چوب‌بری، تجارت
            چوب و تولید محصولات اولیه جنگلی و محصولات چوبی (به عنوان مثال مبلمان) و محصولات ثانویه ..</p>
        <a href="#shop" class="btn">بیشتر بدانید</a>
    </div>
</section>

@include("components.footer")
@endsection

@section("scripts")
<script src="{{asset("js/jquery.js")}}"></script>
{{-- <script src="{{asset("js/navbar.js")}}"></script> --}}

<script>
    $(document).ready(function() {
        $(".box").on("click", function() {
            var win = window.open($(this).attr('data-href'));
        })
    })
</script>
@endsection

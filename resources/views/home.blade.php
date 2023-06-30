@extends('main')

@section("styles")
<link rel="stylesheet" href="{{asset("css/home.css")}}">
<link rel="stylesheet" href="{{asset("css/fonts.css")}}">
<link rel="stylesheet" href="{{asset("css/bootstrap.css")}}">
<link rel="stylesheet" href="{{asset("css/animate.css")}}">
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
    #home-mobile{
        display: none;
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

<section class="text-center animate__bounceIn" id="home-mobile">
    <div style="font-size: 20px; margin-top: 70px;">
        <span>صنایع چوب کارن کیا</span>
    </div>
    <div class="mt-3">
        <span style="font-size: 16px;">تولید و رنگ کاری انواع محصولات چوبی</span>
    </div>
    <div>
        <a href="shop" class="btn btn-lg btn-primary btn-home mt-5">برو به فروشگاه</a>
    </div>
</section>

<section class="shop" id="shop" style="display: none;">
    <div id="h-sale" class="heading mt-3 mb-3" style="font-size: 30px;">
        <span>پر فروش ترین ها</span>
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

<section class="new" id="new" style="display: none;">
    <div class="heading  mb-3" style="text-align: center; font-size: 30px;" id="h-new">
        <span style="color: #518306">جدید ترین محصولات</span>
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

<section class="about" id="about" style="display: none;">
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
        mobileSize();
        $(".box").on("click", function() {
            var win = window.open($(this).attr('data-href'));
        });

        $(window).on("resize", function() {
            mobileSize();
        });

        function mobileSize() {
            if($(window).width() < 768) {
                $("#home").hide();
                $("#home-mobile").show();
                $("#h-new").css("font-size", "20px");
                $("#h-sale").css("font-size", "20px");
                $(".box").css("margin-top", "10px");
            }
            else{
                $("#home").show();
                $("#home").css("display", "flex");
                $("#home-mobile").hide();
                $("#h-new").css("font-size", "30px");
                $("#h-sale").css("font-size", "30px");
                $(".box").css("margin-top", "1px");
            }
        }


        setTimeout(() => {
            $("#shop").fadeIn("slow");
            $("#new").fadeIn("slow");
            $("#about").fadeIn("slow");
            $("#footer").fadeIn("slow");
        }, 200);


    })
</script>
@endsection

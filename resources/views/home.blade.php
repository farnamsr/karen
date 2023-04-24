@extends('main')

@section("styles")
<link rel="stylesheet" href="{{asset("css/home.css")}}">
<link rel="stylesheet" href="{{asset("css/fonts.css")}}">
@endsection

@section("navbar")
<header>
@include("components.navbar")
</header>
@endsection

@section("content")
<section class="home" id="home">
    <div class="home-text">
        <h1><Span>تست متن</Span> ساختگی برای نمایش <br> در وبسایت <span>متن نمونه</span></h1>
        <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است</p>
        <a href="shop" class="btn">برو به فروشگاه</a>
    </div>
</section>

<section class="shop" id="shop">
    <div class="heading">
        <span>پر فروش ترین ها</span>
        <h2>همین الان سفارش بده !</h2>
    </div>
    <div class="shop-container">
        <div class="box">
            <div class="box-img">
                <img src="{{asset("img/p1.jpg")}}" alt="">
            </div>
            <div class="title-price">
                <h3>صندلی خاکستری</h3>
                <div class="stars">
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star-half"></i>
                </div>
            </div>
            <span class="price">2,500,000</span>
        </div>
        <div class="box">
            <div class="box-img">
                <img src="{{asset("img/p2.jpg")}}" alt="">
            </div>
            <div class="title-price">
                <h3>صندلی خاکستری</h3>
                <div class="stars">
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star-half"></i>
                </div>
            </div>
            <span class="price">2,500,000</span>
        </div>
        <div class="box">
            <div class="box-img">
                <img src="{{asset("img/p3.jpg")}}" alt="">
            </div>
            <div class="title-price">
                <h3>صندلی خاکستری</h3>
                <div class="stars">
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star-half"></i>
                </div>
            </div>
            <span class="price">2,500,000</span>
        </div>
        <div class="box">
            <div class="box-img">
                <img src="{{asset("img/p4.jpg")}}" alt="">
            </div>
            <div class="title-price">
                <h3>صندلی خاکستری</h3>
                <div class="stars">
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star-half"></i>
                </div>
            </div>
            <span class="price">2,500,000</span>
        </div>
        <div class="box">
            <div class="box-img">
                <img src="{{asset("img/p5.jpg")}}" alt="">
            </div>
            <div class="title-price">
                <h3>صندلی خاکستری</h3>
                <div class="stars">
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star-half"></i>
                </div>
            </div>
            <span class="price">2,500,000</span>
        </div>
        <div class="box">
            <div class="box-img">
                <img src="{{asset("img/p6.jpg")}}" alt="">
            </div>
            <div class="title-price">
                <h3>صندلی خاکستری</h3>
                <div class="stars">
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star-half"></i>
                </div>
            </div>
            <span class="price">2,500,000</span>
        </div>
    </div>
</section>

<section class="new" id="new">
    <div class="heading">
        <span>جدید ترین محصولات</span>
        <h2>همین الان سفارش بده !</h2>
    </div>
    <div class="new-container">
        <div class="box">
            <div class="box-img">
                <img src="{{asset("img/p3.jpg")}}" alt="">
            </div>
            <div class="title-price">
                <h3>صندلی خاکستری</h3>
                <div class="stars">
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star-half"></i>
                </div>
            </div>
            <span class="price">2,500,000</span>
        </div>
        <div class="box">
            <div class="box-img">
                <img src="{{asset("img/p3.jpg")}}" alt="">
            </div>
            <div class="title-price">
                <h3>صندلی خاکستری</h3>
                <div class="stars">
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star-half"></i>
                </div>
            </div>
            <span>2,500,000</span>
        </div>
        <div class="box">
            <div class="box-img">
                <img src="{{asset("img/p3.jpg")}}" alt="">
            </div>
            <div class="title-price">
                <h3>صندلی خاکستری</h3>
                <div class="stars">
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star"></i>
                    <i class="bx bxs-star-half"></i>
                </div>
            </div>
            <span class="price">2,500,000</span>
        </div>
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

<section class="newsletter" id="contact">
    <h2>ما را دنبال کنید!</h2>
    <div class="news-box">
        <input type="text" placeholder="آدرس ایمیل تان را وارد کنید...">
        <a href="#" class="btn">دنبال کردن</a>
    </div>
</section>

<section class="footer" id="footer">
    <div class="footer-box">
        <h2>متن <span>برند</span></h2>
        <p>متن نمونه جهت نمایش در بخش تبلیغات و تماس با مشتریان وبسایت</p>
        <div class="social">
            <a href="#">
                <li class="bx bxl-facebook"></li>
            </a>
            <a href="#">
                <li class="bx bxl-twitter"></li>
            </a>
            <a href="#">
                <li class="bx bxl-instagram"></li>
            </a>
        </div>
    </div>
    <div class="footer-box">
        <h3>خدمات</h3>
        <li><a href="#">خدمات</a></li>
        <li><a href="#">پشتیبانی</a></li>
        <li><a href="#">قیمت ها</a></li>
        <li><a href="#">پرسش های رایج</a></li>
    </div>
    <div class="footer-box">
        <h3>محصولات</h3>
        <li><a href="#">جلو مبل</a></li>
        <li><a href="#">میز</a></li>
        <li><a href="#">صندل</a></li>
        <li><a href="#">آینه</a></li>
    </div>
    <div class="footer-box contact-info">
        <h3>تماس با ما</h3>
        <span>آذربایجان شرقی، تبریز جاده مایان</span>
        <span>0413 569 84 57</span>
        <span>karenwoods@mail.com</span>
    </div>
</section>

<div class="copyright">
    <p>&#169 کلیه حقوق مادی و معنوی برای سایت کارن محفوظ میباشد</p>
</div>
@endsection

@section("scripts")
<script src="{{asset("js/navbar.js")}}"></script>
@endsection

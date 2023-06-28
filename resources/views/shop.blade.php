@extends('main')

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
<style>
    .shop-container, .new-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, auto));
        gap: 3rem;
        margin-top: 5rem;
    }
    #catListBtn {
        display: none;
        font-size: 20px;
        margin-top: 45px;
    }
    .mob-cat-selected{
        background: #00ff7736;
    }
    @media only screen and (max-width: 600px) {
        #catList{
            display: none;
        }
        #catListBtn {
            display:block;
        }
    }
</style>
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 h1" id="catListBtn">
                <i class='bx bx-filter'></i>
                <span style="cursor: pointer" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" >دسته بندی محصولات</span>
            </div>
            <div class="col-md-3" id="catList">
                <ul class="list-group" style="margin-right: -90px; width: 90%; margin-top:40px;">
                    <div class="h5 mb-3" style="font-size: 18px;">دسته بندی محصولات</div>
                    @foreach ($cats as $cat)
                     <li class="list-group-item" style="border: none; border-right: 1px solid rgb(235 235 235)">
                        <input class="form-check-input me-1 cat-check" type="checkbox" value="{{$cat->id}}" id="{{$cat->id}}">
                        <label class="form-check-label stretched-link" for="{{$cat->id}}">{{$cat->name}}</label>
                      </li>
                    @endforeach
                  </ul>
            </div>
            <div class="col-md-9 col-sm-12">
                <div class="shop-container">
                    @foreach ($products as $product)
                    <div class="box" id="{{$product->id}}" style="cursor: pointer" data-href="{{route('getProduct', $product->id)}}">
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
                                        {{$product->price}}
                                    </span>
                                    <br>
                                    <small style="color: gray; font-size: 12px;">تومان</small>
                                    <span style="">
                                        {{$product->disc}}
                                    </span>
                                @else
                                    <small style="color: gray; font-size: 12px;">تومان</small>
                                    {{$product->price}}
                                @endif
                        @endauth
                        @guest
                        {{$product->price}}
                        <small style="color: gray; font-size: 12px;">تومان</small>
                        @endguest
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-12 mx-auto mb-5 text-center" style="margin-top: 60px;">
                <span id="see-more" type="" class="text-primary"
                style="font-size: 16px; font-weight: bold; cursor: pointer;">+&nbsp;مشاهده موارد بیشتر
                </span>
            </div>
        </div>
    </div>
</section>


{{-- <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">Toggle bottom offcanvas</button> --}}

<div class="offcanvas offcanvas-bottom" style="height: 100%;" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
  <div class="offcanvas-header text-center">
    <h1 class="offcanvas-title mt-5" id="offcanvasBottomLabel">دسته بندی محصولات</h1>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body small">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul style="font-size: 15px;">
                    @foreach ($cats as $cat)
                    <li class="list-group-item mobile-cat-item" data-val="{{$cat->id}}" style="border: none;">
                       <label class="form-check-label stretched-link"
                        style="text-align: center; padding: 8px; width: 80%;"
                        >{{$cat->name}}</label>
                     </li>
                   @endforeach
                </ul>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection


@section("scripts")
<script src="{{asset("js/jquery.js")}}"></script>
<script>
    $(document).ready(function() {
        let currentPage = 1;
        let checkedCats = [];
        $(".cat-check").on("input", function() {
            checkedCats = [];
            currentPage = 1;
            $(".shop-container").empty();
            $(".cat-check").each(function() {
                if ($(this).is(":checked")) {
                    checkedCats.push($(this).val())
                }
            })
            getProducts(checkedCats, currentPage);
        })
        $("#see-more").on("click", function() {
            currentPage += 1;
            getProducts(checkedCats, currentPage);
        });
        $(document).on("click", ".box", function() {
            window.location.href = $(this).attr("data-href");
        });
        $(".mobile-cat-item").on("click", function() {
            $(this).toggleClass("mob-cat-selected");
            checkedCats = [];
            currentPage = 1;
            $(".shop-container").empty();
            $(".mob-cat-selected").each(function() {
                checkedCats.push($(this).attr("data-val"));
            });
            getProducts(checkedCats, currentPage);
        });
        function getProducts(checkedCats, currentPage) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{url()->current()}}" + "?page=" + currentPage,
                type:"GET",
                data:{ cats:checkedCats }
            }).done(function(resp) {
                if(resp["result"] == true) {
                    let auth = resp['auth'];
                    let userDisc = resp['userDisc'];
                    let cards = resp["products"]["data"];
                    $(cards).each(function() {
                        let card = productCard(this['id'], this['name'],
                            this['description'], this['price'],
                            this['img_path'], this['href'], auth,
                            userDisc, this['wholesaleـdiscount'], this['disc']);
                        $(".shop-container").append(card);
                    });
                }
            });
        }
        function productCard(id, name, desc, price, imageSrc, href, auth, userDisc, prodDisc, disc) {
            let card = `<div class="box" id="${id}" style="cursor: pointer" data-href="${href}">
            <div class="box-img">
            <img src="${imageSrc}" alt="">
            </div>
            <div class="title-price">
                <h3>${name}</h3>
            </div>
            <span class="price">`;
                if(auth == true && userDisc == 1 && prodDisc != null) {
                    card += `<small style="color: gray; font-size: 12px;">تومان</small>
                        <span style="text-decoration: line-through; color:rgb(241, 167, 148);">
                            ${price}
                        </span>
                        <br>
                        <small style="color: gray; font-size: 12px;">تومان</small>
                        <span style="">
                            ${disc}
                        </span>`;
                }
                else{
                    card += ` ${price}
                            <small style="color: gray; font-size: 12px;">تومان</small>`;
                }
            card += `</span></div>`;
            return card;
        }
    });
</script>
@endsection



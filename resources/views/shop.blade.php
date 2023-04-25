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
</style>
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 mt-5">
                <ul class="list-group" style="margin-right: -90px; width: 90%">
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
                        <span class="price">{{$product->price}}</span>
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
@endsection


@section("scripts")
<script src="{{asset("js/navbar.js")}}"></script>
<script src="{{asset("js/jquery.js")}}"></script>
<script>
    $(document).ready(function() {
        let currentPage = 1;
        let checkedCats = [];
        $(".cat-check").on("input", function() {
            checkedCats = [];
            currentPage = 1;
            $(".cat-check").each(function() {
                $(".shop-container").empty();
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
        function getProducts(checkedCats, currentPage) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{url()->current()}}" + "?page=" + currentPage,
                type:"GET",
                data:{ cats:checkedCats }
            }).done(function(resp) {
                if(resp["result"] == true) {
                    let cards = resp["products"]["data"];
                    $(cards).each(function() {
                        let card = productCard(this['id'], this['name'],
                            this['description'], this['price'], this['img_path']);
                        $(".shop-container").append(card);
                    });
                }
            });
        }
        function productCard(id, name, desc, price, imageSrc) {
            return `<div class="box" id="${id}" style="cursor: pointer">
            <div class="box-img">
            <img src="${imageSrc}" alt="">
            </div>
            <div class="title-price">
                <h3>${name}</h3>
            </div>
            <span class="price">${price}</span>
            </div>`;
        }
    });
</script>
@endsection



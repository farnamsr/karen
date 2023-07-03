@extends("main")

@section("styles")
<link rel="stylesheet" href="{{asset("css/bootstrap.css")}}">
<link rel="stylesheet" href="{{asset("css/fonts.css")}}">
<link rel="stylesheet" href="{{asset("css/dashboard.css")}}">
<link rel="stylesheet" href="{{asset("css/file-upload.css")}}">
<link rel="stylesheet" href="{{asset("css/image-preview.css")}}">
<style>

@media (min-width: 30em) {
    .filepond--item {
        width: calc(50% - 0.5em);
    }
}

@media (min-width: 50em) {
    .filepond--item {
        width: calc(33.33% - 0.5em);
    }
}
.filepond--root {
    max-height: 12em;
}

.img-rat {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

</style>
@endsection



@section("content")
  <div class="container-fluid">
    <div class="row">
      @include("components.dashboard-sidebar")
      @include("components.dashboard-nav")
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2 mt-4 ">مدیریت محصولات</h1>
{{--          <div class="btn-toolbar mb-2 mb-md-0">--}}
{{--            <button type="button" class="btn btn-primary"--}}
{{--             data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin-left: 10px;">--}}
{{--              ثبت محصول جدید--}}
{{--            </button>--}}
{{--            <button type="button" class="btn btn-warning" data-bs-toggle="modal"--}}
{{--             data-bs-target="#catModal" style="margin-left: 10px;">--}}
{{--                دسته بندی محصولات--}}
{{--              </button>--}}
{{--              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#colorModal">--}}
{{--                    رنگ ها--}}
{{--              </button>--}}
{{--          </div>--}}

            <div class="dropdown mt-5 mb-4">
                <button style="width: 300px;" class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    گزینه ها
                </button>
                <ul style="width: 300px;" class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li data-bs-toggle="modal" data-bs-target="#exampleModal"><a class="dropdown-item" href="#">ثبت محصول جدید</a></li>
                    <li data-bs-toggle="modal" data-bs-target="#catModal"><a class="dropdown-item" href="#">دسته بندی محصولات</a></li>
                    <li data-bs-toggle="modal" data-bs-target="#colorModal"><a class="dropdown-item" href="#">رنگ ها</a></li>
                </ul>
            </div>
        </div>
        <h4 class="mt-5 mb-4">آخرین محصولات ثبت شده</h4>
        <div class="row row-cols-1 row-cols-md-4 g-4" id="cards-col">
            @foreach ($products as $product)
            <div class="col">
                <div class="card h-100">
                  <img src="{{$product->img_path}}" class="card-img-top img-rat" alt="...">
                  <div class="card-body">
                    <h5 class="card-title">{{$product->name}}</h5>
                    <p class="card-text">{{$product->description}}</p>
                      <hr>
                    <span style="font-size: 17px; text-align: center" class="">{{$product->price}} <small>تومان</small></span>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
      </main>
        <span id="see-more" type="" class="text-center mx-auto mt-5 mb-5 text-primary"
            style="font-size: 16px; font-weight: bold; cursor: pointer;">+&nbsp;مشاهده موارد بیشتر
        </span>
    </div>
  </div>

  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">ثبت محصول جدید</h5>
          <button type="button" id="modal-close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="product-form">
                <div class="container">
                    <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label text-primary">عنوان محصول: </label>
                                    <input type="text" class="form-control" name="name" aria-describedby="">
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label text-primary">دسته بندی: </label>
                                    <select name="cat" id="cat" class="form-control">
                                        <option selected value="" disabled="disabled">انتخاب دسته بندی محصول</option>
                                        @foreach ($cats as $cat)
                                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="desc" class="form-label text-primary">توضیحات</label>
                                    <textarea  class="form-control" name="desc" rows="5"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label text-primary">قیمت محصول: </label>
                                    <input type="text" class="form-control text-center" name="price" aria-describedby="">
                                    </div>
                                <div class="form-check form-switch">
                                    <label class="form-check-label" for="wholesaleـdiscount">دارای تخفیف عمده فروشی</label>
                                    <input id="disc-check" class="form-check-input" type="checkbox" name="wholesaleـdiscount">
                                </div>
                                <div class="input-group mb-3 mt-2">
                                    <input value="" id="disc-inp" name="disc-percent" disabled type="number" max="100" min="0" class="form-control text-center" placeholder="درصد تخفیف" aria-label="" aria-describedby="">
                                  </div>
                            </div>
                            <div class="col-md-6">
                                <div class="h5 mb-3">آپلود تصاویر</div>
                                <input type="file"
                                id="filepond"
                                class="filepond"
                                name="filepond"
                                multiple
                                data-allow-reorder="true"
                                data-max-file-size="3MB"
                                data-max-files="3">
                            </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
          <button id="submit-product" type="button" class="btn btn-success">ثبت محصول</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="catModal" tabindex="-1" aria-labelledby="catModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">دسته بندی محصولات</h5>
          <button type="button" id="modal-close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="product-form">
                <div class="container">
                    <div class="row">
                            <div class="col-md-12 mt-4">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control"
                                        placeholder="دسته بندی جدید"
                                        id="cat-name">
                                    <button class="btn btn-primary" type="button" id="add-cat">ثبت</button>
                                  </div>
                            </div>
                            <div class="col-md-12">
                                <table class="table text-center">
                                    <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">نام دسته بندی</th>
                                        <th scope="col">حذف</th>
                                      </tr>
                                    </thead>
                                    <tbody id="cats-body">
                                        @for ($i = 0; $i < count($cats); $i++)
                                            <tr>
                                                <th class="cat-index" scope="row">{{$i + 1}}</th>
                                                <td>{{$cats[$i]["name"]}}</td>
                                                <td class="del-cat"><i id="{{$cats[$i]['id']}}" class='bx bx-trash text-danger del-cat'
                                                    style="cursor: pointer"></i></td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                  </table>
                            </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="colorModal" tabindex="-1" aria-labelledby="colorModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">رنگ ها</h5>
          <button type="button" id="modal-close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="product-form">
                <div class="container">
                    <div class="row">
                            <div class="col-md-12 mt-4">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control"
                                        placeholder="رنگ جدید"
                                        id="color-name">
                                    <button class="btn btn-primary" type="button" id="add-color">ثبت</button>
                                  </div>
                            </div>
                            <div class="col-md-12">
                                <table class="table text-center">
                                    <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">نام رنگ</th>
                                        <th scope="col">حذف</th>
                                      </tr>
                                    </thead>
                                    <tbody id="colors-body">
                                        @for ($i = 0; $i < count($colors); $i++)
                                            <tr>
                                                <th class="color-index" scope="row">{{$i + 1}}</th>
                                                <td>{{$colors[$i]["name"]}}</td>
                                                <td class=""><i id="{{$colors[$i]['id']}}" class='bx bx-trash text-danger del-color'
                                                    style="cursor: pointer"></i></td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                  </table>
                            </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section("scripts")
<script src="{{asset("js/jquery.js")}}"></script>
<script src="{{asset("js/file-upload.js")}}"></script>
<script src="{{asset("js/image-preview.js")}}"></script>
<script src="{{asset("js/sweet.js")}}"></script>

<script>
    $(document).ready(function() {
        let nextPage = 2;
        $("#file-btn").on("click", function() { $("#filepond").click() });
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
        );
        let inputElement = document.querySelector('input[type="file"]');
        let pond = FilePond.create(inputElement, {
            allowImageCrop:true
        });

        function productCard(id, name, desc, price, imageSrc) {
            return `<div class="col">
                <div class="card h-100">
                  <img src="${imageSrc}" class="card-img-top img-rat">
                  <div class="card-body">
                    <h5 class="card-title">${name}</h5>
                    <p class="card-text">${desc}</p>
                    <span class="text-left">${price}</span>
                  </div>
                </div>
              </div>`;
        }

        function reloadCats() {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:"{{route('cats')}}",
                type:"GET",
            }).done(function(resp) {
                let cats = resp["cats"];
                $("#cat").find("option").remove();
                $("#cat").append(`<option selected value="" disabled="disabled">انتخاب دسته بندی محصول</option>`);
                $(cats).each(function() {
                    $("#cat").append(`<option value="${this['id']}">${this['name']}</option>`);
                });
            })
        }
        function reloadProducts() {
            nextPage = 2;
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:"{{route('dashboard-products')}}",
                type:"GET",
            }).done(function(resp) {
                $("#cards-col").empty();
                let cards = resp["products"]['data'];
                    $(cards).each(function() {
                        let card = productCard(this['id'], this['name'],
                            this['description'], this['price'], this['img_path']);
                        $("#cards-col").append(card);
                    });
            })
        }

        $("#submit-product").on("click", function() {
            $(this).prop("disabled", true).text("در حال ذخیره...");
            let fd = new FormData($("#product-form")[0]);
            pondFiles = pond.getFiles();
            for (var i = 0; i < pondFiles.length; i++) {
                fd.append('file[]', pondFiles[i].file);
            }
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:"{{route('save-product')}}",
                type:"POST",
                processData: false,
                contentType: false,
                data:fd
            }).done(function(resp) {
                if(resp["error"] == "INVALID") {
                    $("#submit-product").prop("disabled", false).text("ثبت محصول");
                    Swal.fire({
                        title:"خطا در ثبت",
                        html:`<p>لطفا در وارد کردن ورودی ها دقت نمایید:</p>
                               <p>فرمت فایل ها باید کمتر از ۲۰۴۸ کیلو بایت باشد</p>
                               <p>فایل ها باید از نوع 'png', 'jpeg', 'jpg' باشند.</p>
                               <p>ورودی های دسته بندی محصولات، قیمت ، عنوان و توضیحات محصول حتما باید پر شوند.</p>`,
                        icon: 'error',
                        showConfirmButton: true,
                    })
                }
                if(resp["result"] == true) {
                    pond.removeFiles();
                    $("#submit-product").prop("disabled", false).text("ثبت محصول");
                    Swal.fire({
                        title:"ثبت موفق!",
                        html:"محصول جدید با موفقیت ثبت شد.",
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    reloadProducts();
                }
            });
        })

        $("#add-cat").on("click", function() {
            let name = $("#cat-name").val();
            let nextIndex = 1;
            if($("#cats-body").children().length > 0) {
                nextIndex = parseInt($($("#cats-body")
               .children().last()[0]).find(".cat-index")[0].innerHTML) + 1;
            }
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:"{{route('cat-create')}}",
                type:"POST",
                data:{name: name}
            }).done(function(resp) {
                let row = `<tr>
                           <th class="cat-index" scope="row">${nextIndex}</th>
                           <td>${name}</td>
                           <td class=""><i id="${resp['catId']}" class='bx bx-trash text-danger del-cat'
                            style="cursor: pointer"></i></td>
                            </tr>`;
                $("#cats-body").append(row);
                reloadCats();
            });
        });

        $(document).on("click", ".del-cat", function() {
            let row = $(this).parents()[1];
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:"{{route('cat-delete')}}",
                type:"POST",
                data:{catId: $(this).attr("id")}
            }).done(function(resp) {
                if(resp["result"] != false) {
                    $(row).remove();
                    reloadCats();
                }
                else{
                    Swal.fire({
                        title:"خطا در حذف",
                        html:"دسته بندی مورد نظر به دلیل داشتن زیر محصول قابل حذف نیست!",
                        icon: 'error',
                        showConfirmButton: true,
                    })
                }
            });
        });

        $("#see-more").on("click", function() {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{url()->current()}}" + "?page=" + nextPage,
                type:"GET"
            }).done(function(resp) {
                if(resp["result"] == true) {
                    nextPage += 1;
                    let cards = resp["products"]["data"];
                    $(cards).each(function() {
                        let card = productCard(this['id'], this['name'],
                            this['description'], this['price'], this['img_path']);
                        $("#cards-col").append(card);
                    });
                }
            });
        });

        $("#add-color").on("click", function() {
            let name = $("#color-name").val();
            let nextIndex = 1;
            if($("#colors-body").children().length > 0) {
                nextIndex = parseInt($($("#colors-body")
               .children().last()[0]).find(".color-index")[0].innerHTML) + 1;
            }
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:"{{route('color-create')}}",
                type:"POST",
                data:{name: name}
            }).done(function(resp) {
                let row = `<tr>
                           <th class="color-index" scope="row">${nextIndex}</th>
                           <td>${name}</td>
                           <td class=""><i id="${resp['colorId']}" class='bx bx-trash text-danger del-color'
                            style="cursor: pointer"></i></td>
                            </tr>`;
                $("#colors-body").append(row);
                reloadColors();
            });
        });
        $(document).on("click", ".del-color", function() {
            let id = $(this).attr("id");
            let row = $(this).parents()[1];
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:"{{route('color-delete')}}",
                type:"POST",
                data:{colorId: id}
            }).done(function(resp) {
                if(resp["result"] != false) {
                    $(row).remove();
                }
            });
        });
        $("#disc-check").on("change", function() {
            if(this.checked) {
                $("#disc-inp").prop("disabled", false);
            }
            else{
                $("#disc-inp").prop("disabled", true).val("");
            }
        });
    });

</script>
@include("dashboard.footer")

@endsection

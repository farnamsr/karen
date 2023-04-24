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
          <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" class="btn btn-primary"
             data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin-left: 10px;">
              ثبت محصول جدید
            </button>
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#catModal">
                دسته بندی محصولات
              </button>
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
                    <span class="text-left">{{$product->price}}</span>
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
                                    <input class="form-check-input" type="checkbox" name="wholesaleـdiscount">
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
                                                <td class="del-cat"><i id="{{$cats[$i]['id']}}" class='bx bx-trash text-danger'
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
                           <td class="del-cat"><i id="${resp['catId']}" class='bx bx-trash text-danger'
                            style="cursor: pointer"></i></td>
                            </tr>`;
                $("#cats-body").append(row);
            });
        });

        $(document).on("click", ".bx-trash", function() {
            let row = $(this).parents()[1];
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:"{{route('cat-delete')}}",
                type:"POST",
                data:{catId: $(this).attr("id")}
            }).done(function(resp) {
                $(row).remove();
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
    });

</script>

@endsection

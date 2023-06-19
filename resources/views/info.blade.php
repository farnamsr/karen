@extends("main")

@section("styles")
<link rel="stylesheet" href="{{asset("css/bootstrap.css")}}">
<link rel="stylesheet" href="{{asset("css/fonts.css")}}">

@endsection

@section("content")
<style>
    body{ background: rgb(221, 223, 230) }
</style>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12 mx-auto mt-5"
            style="background: white; padding-bottom: 100px;
             padding-left: 40px;padding-right: 40px;
             border-radius: 10px;">
                <div class="h3 text-center" style="margin-top: 100px;">تکمیل مشخصات کاربر</div>
                <div class="mb-3 mt-4">
                    <label class="mb-2" for="phone">شماره تلفن همراه:</label>
                    <input disabled type="text" class="form-control text-center p-2"
                     style="letter-spacing: 5px; font-weight: bold" id="phone" value="{{$phone}}">
                  </div>
                  <div class="mb-3 mt-3" style="" id="name-inp">
                    <label class="mb-2" for="name">نام:</label>
                    <input maxlength="6" type="text" class="form-control text-center p-2"
                     style="" id="name" placeholder="">
                     <small id="name-err" class="text-danger"></small>
                  </div>
                  <div class="mb-3 mt-3" style="" id="lastname-inp">
                    <label class="mb-2" for="lastname">نام خانوادگی:</label>
                    <input maxlength="32" type="text" class="form-control text-center p-2"
                     style="" id="lastname" placeholder="">
                     <small id="lastname-err" class="text-danger"></small>
                  </div>
                  <div class="mb-3 mt-3">
                    <label class="mb-2" for="lastname">آدرس: </label>
                    <textarea id="address" class="form-control" id="" cols="30" rows="4"></textarea>
                    <small id="address-err" class="text-danger"></small>
                  </div>
                  <div class="d-grid gap-2 mt-4">
                    <button id="submit" class="btn btn-primary" type="button">تکمیل ثبت نام</button>
                  </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section("scripts")
<script src="{{asset("js/jquery.js")}}"></script>
<script src="{{asset("js/sweet.js")}}"></script>
<script>
    $(document).ready(function() {
        $("#submit").on("click", function() {
            $("small").html("");
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:"{{route('compelete-info', $phone)}}",
                type:"POST",
                data:{
                    "name": $("#name").val(),
                    "lastname": $("#lastname").val(),
                    "phone":"{{$phone}}"
                }
            }).done(function(resp) {
                if(resp["result"] == true) {
                    Swal.fire({
                        title:"خوش آمدید",
                        html:"مشخصات شما با موفقیت ثبت شد!",
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    setTimeout(() => {
                        window.location.href = "{{route('panel')}}"
                    }, 2000);
                }
                if(resp['error'] == "INVALID") {

                }
            })
        });
    })
</script>
@endsection


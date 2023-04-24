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
            style="background: white; padding-bottom: 200px;
             padding-left: 40px;padding-right: 40px;
             border-radius: 10px;">
                <div class="h3 text-center" style="margin-top: 100px;">ورود به سیستم</div>
                <div class="mb-3 mt-4">
                    <label class="mb-2" for="phone">شماره تلفن همراه:</label>
                    <input type="text" class="form-control text-center p-2"
                     style="letter-spacing: 5px; font-weight: bold" id="phone" placeholder="">
                  </div>
                  <div class="mb-3 mt-4" style="display: none" id="code-inp">
                    <label class="mb-2" for="phone">کد تایید:</label>
                    <input maxlength="6" type="text" class="form-control text-center p-2"
                     style="letter-spacing: 8px; font-weight: bold" id="code" placeholder="">
                     <small id="code-err" class="text-danger"></small>
                  </div>
                  <div class="d-grid gap-2 mt-4">
                    <button id="submit" class="btn btn-primary" type="button">دریافت کد تایید</button>
                  </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section("scripts")
<script src="{{asset("js/jquery.js")}}"></script>
<script>
    $(document).ready(function() {
        $("#submit").on("click", function() {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:"{{route('attempt')}}",
                type:"POST",
                data:{"phone": $("#phone").val()}
            }).done(function(resp) {
                let result = resp["result"];
                let type = resp["type"];
                if(result && type == "code_request") {
                    $("#code-inp").slideDown("slow");
                }
            })
        });
        $("#code").on("input", function() {
            if($(this).val().length == 6) {
                $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:"{{route('verify_code')}}",
                type:"POST",
                data:{"phone": $("#phone").val(), "code": $("#code").val()}
                }).done(function(resp) {
                    if(resp["result"] == false) {
                        $("#code-err").text("کد وارد شده نا معتبر است!");
                    }
                    if(resp["redirect"]) {
                        window.location.href = resp["redirect"]
                    }
                })
            }
        });
    });
</script>
@endsection


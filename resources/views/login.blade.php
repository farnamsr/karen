@extends("main")

@section("styles")
<link rel="stylesheet" href="{{asset("css/home.css")}}">
<link rel="stylesheet" href="{{asset("css/bootstrap.css")}}">
<link rel="stylesheet" href="{{asset("css/fonts.css")}}">
@endsection
@section("navbar")
<header>
@include("components.navbar")
</header>
@endsection
@section("content")
<style>
    body{ background: rgb(221, 223, 230) }
    @media screen and (max-width: 768px) {
        .row{
            padding: 10px;
        }
    }
</style>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12 mx-auto"
            style="background: white; padding-bottom: 200px;
             padding-left: 40px;padding-right: 40px;
             border-radius: 10px; margin-top: 100px;" id="login-col">
                <div class="h3 text-center" style="margin-top: 100px;">ورود به سیستم</div>
                <div class="mb-3 mt-4">
                    <label class="mb-2" for="phone">شماره تلفن همراه:</label>
                    <input type="text" class="form-control text-center p-2"
                     style="letter-spacing: 5px; font-weight: bold" id="phone" placeholder="">
                  </div>
                  <div class="mb-3 mt-4" id="code-inp">
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
<script src="{{asset("js/sweet.js")}}"></script>
<script>
    $(document).ready(function() {
        mobileSize();
        let minutes;
        let serverTimestamp = "{{$timestamp}}";
        let clientTimestamp = Math.floor(Date.now() / 1000);
        let timeDiff = clientTimestamp - serverTimestamp;
        if(serverTimestamp > 0 && timeDiff < 120) {
            $("#submit").prop("disabled", true);
            countDown(120 - timeDiff);
        }
        $("#submit").on("click", function() {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:"{{route('attempt')}}",
                type:"POST",
                data:{"phone": $("#phone").val()}
            }).done(function(resp) {
                let result = resp["result"];
                let type = resp["type"];
                if(resp["error"] == "INVALID") {
                    Swal.fire({
                        title:"خطا",
                        html: "شماره وارد شده نا معتبر است!",
                        icon: 'error',
                        showConfirmButton: true
                    })
                }
                else if(resp["result"] == true) {
                    $("#submit").prop("disabled", true);
                    countDown(120);
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
        $(window).on("resize", function() {
            mobileSize();
        });

        function countDown(seconds) {
            let timerSecs, counterInterval;
            let timerString;
            counterInterval = setInterval(() => {
                minutes = Math.floor(seconds / 60);
                timerSecs = (seconds--) % 60;
                timerString = `${timerSecs.toString().padStart(2, '0')} : ${minutes.toString().padStart(2, '0')}`;
                $("#submit").html(timerString);
                if(seconds < 0) {
                    $("#submit").prop("disabled", false);
                    $("#submit").html("دریافت کد تایید");
                    clearInterval(counterInterval);
                }
            }, 1000);
        }
        function mobileSize() {
            if($(window).width() < 768) {
                $("#login-col").css("margin-top", "50px");
            }
            else{
                $("#login-col").css("margin-top", "100px");
            }
        }
    });
</script>
@endsection


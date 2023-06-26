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
        <div class="h4 mt-5 mb-4">فهرست کاربران</div>
        <div class="mb-5 mx-auto d-flex justify-around">
            <input type="search" class="form-control w-50" id="search-inp" placeholder="جستجوی کاربر">
        </div>
        <table class="table text-center">
            <thead style="background: #e7e5ff"><tr>
                <th scope="col">#</th>
                <th scope="col">نام مشتری</th>
                <th scope="col">نام خانوادگی</th>
                <th scope="col">شماره تماس</th>
                <th scope="col">آدرس</th>
                <th scope="col">دارای تخفیف عمده</th>
                <th scope="col">تاریخ ثبت نام</th>
                </tr>
            </thead>
            <tbody id='users-table' style=" font-size:18px;">
            </tbody>
        </table>
    </main>
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
        fetchUsers();
        function fetchUsers() {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:"{{route('fetch-users')}}",
                type:"GET",
                data:{
                    field:$("#search-field").val(),
                    search:$("#search-inp").val()
                }
            }).done(function(resp) {
                if(resp["result"] == true) {
                    let users = resp["users"];
                    let i = 0;
                    let row;
                    $(users).each(function() {
                        row += `<tr>`;
                        row += `<td>${++i}</td>`;
                        row += `<td>${this['name']}</td>`;
                        row += `<td>${this['lastname']}</td>`;
                        row += `<td style='letter-spacing:2px;'>${this['phone_number']}</td>`;
                        row += `<td>${this['address'][0]['address']}</td>`;
                        row += `<td><div class='form-check form-switch d-flex justify-content-center'>
                                    <input id='${this["id"]}' type='checkbox' class='form-check-input disc-check'`;
                        if(this['hasWholeDisc']) { row += ` checked` }
                        row += `/></div></td>`;
                        row += `<td>${this['created_at']}</td>`;
                        row += `</tr>`;
                    });
                    $("#users-table").append(row);
                }
            })
        }

        $(document).on("change", ".disc-check", function() {
            let id = $(this).attr("id");
            let status = this.checked; 
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:"{{route('update-disc')}}",
                type:"POST",
                data:{
                    userId: id,
                    discStatus:status
                }
            }).done(function() {

            });
        });
    });

</script>
@include("dashboard.footer")

@endsection

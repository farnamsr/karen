@extends("main")

@section("styles")
<link rel="stylesheet" href="{{asset("css/bootstrap.css")}}">
<link rel="stylesheet" href="{{asset("css/fonts.css")}}">
<link rel="stylesheet" href="{{asset("css/dashboard.css")}}">
@endsection



@section("content")
  <div class="container-fluid">
    <div class="row">
      @include("components.dashboard-sidebar")
      @include("components.dashboard-nav")
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2 mt-4">مدیریت سفارشات</h1>
        </div>
        <h4 class="mt-5">آخرین سفارشات ثبت شده</h4>
        <div class="table-responsive">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">عنوان</th>
                <th scope="col">عنوان</th>
                <th scope="col">عنوان</th>
                <th scope="col">عنوان</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1,001</td>
                <td>تست</td>
                <td>تست</td>
                <td>تست</td>
                <td>تست</td>
              </tr>
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>
@endsection

@section("scripts")

@endsection

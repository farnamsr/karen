@extends("main")

@section("styles")
<link rel="stylesheet" href="{{asset("css/home.css")}}">
<link rel="stylesheet" href="{{asset("css/fonts.css")}}">
<link rel="stylesheet" href="{{asset("css/bootstrap.css")}}">
<link rel="stylesheet" href="{{asset("css/datepicker.css")}}">
<style>
    .list-ic{
        margin-left: 5px;
        font-size: 25px;
        color: #007eff;
    }
</style>
@endsection

@section("navbar")
<header>
@include("components.navbar")
</header>
@endsection

@section("content")
<section>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-4 col-sm-12 mt-4">
                <div class="card w-100" style="width: 18rem; background: #f3f3f391">
                    <div class="card-body">
                      <h5 class="card-title">{{$user->name . " " . $user->lastname}}</h5>
                      <h6 class="card-subtitle mb-2 text-muted">{{$user->phone_number}}</h6>
                      <div class="wallet-info" style="display: flex; justify-content: space-between">
                        <small class="card-text">اعتبار کیف پول</small>
                        <small>1200 تومان</small>
                      </div>
                    </div>
                  </div>
                    <button class="btn btn-outline-danger w-100 mt-4" type="button">ثبت سفارش اختصاصی</button>
                    <div class="debt-cont mt-3">
                        <div>مجموع بدهی:</div>
                        <div class="text-center text-secondary" style="font-size: 30px; letter-spacing: 2px" id="totalDebt"></div>
                    </div>
                    <div class="line">
                        <hr class="mt-2">
                    </div>
                      <div class="info-text mt-3 text-center">
                        <i class='bx bx-info-circle text-primary'></i>
                        <small class="text-secondary">مشتری گرامی جهت تکمیل سفارشات ثبت شده حد اقل یک سوم از هزینه بصورت نقد و
                          ما بقی حد اکثر در قالب سه فقره چک دریافت میشود</small>
                      </div>
                    <hr class="mt-2">

                    {{-- <button class="btn btn-primary  w-100 mt-2" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">پرداخت و تکمیل سفارشات</button> --}}

                    {{-- <div class="btn-group w-100 mt-4" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-outline-primary" style="margin-left: 10px">ثبت سفارش اختصاصی</button>
                        <button type="button" class="btn btn-outline-success">پرداخت و تایید سفارشات</button>
                      </div> --}}
                    <ul class="list-group mt-4">
                        <li style="cursor: pointer;" class="list-group-item d-flex  align-items-center">
                            <i class='bx bx-cart list-ic'></i>
                          سفارشات
                        </li>
                        <li style="cursor: pointer;" class="list-group-item d-flex align-items-center">
                            <i class='bx bx-user list-ic' ></i>
                          اطلاعات حساب کاربری
                        </li>
                        <li style="cursor: pointer;" class="list-group-item d-flex align-items-center">
                            <i class='bx bx-directions list-ic' ></i>
                          آدرس ها
                        </li>
                        <li id="logout" style="cursor: pointer;" class="list-group-item d-flex align-items-center">
                            <i class='bx bx-exit list-ic' ></i>
                          خروج از سیستم
                        </li>
                      </ul>
            </div>
            <div class="col-md-8 col-sm-12 mt-4">
                <div class="card">
                    <div class="card-body">
                      <h5 class="card-title text-secondary">سفارش های من</h5>
                      <div class="orders-status" style="display: flex; justify-content: space-around">
                        <div class="icon-cont text-center">
                            <i class='bx bx-cloud text-primary' style="font-size: 50px"></i>
                            <p class="text-center">12 &nbsp; جاری</p>
                        </div>
                        <div class="icon-cont text-center">
                            <i class='bx bxs-check-circle text-success' style="font-size: 50px"></i>
                            <p class="text-center">1 &nbsp; تحویل شده</p>
                        </div>
                        <div class="icon-cont text-center">
                            <i class='bx bx-arrow-back text-warning' style="font-size: 50px"></i>
                            <p class="text-center">3 &nbsp; مرجوعی</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <ul class="nav nav-tabs mt-5" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">تکمیل نشده</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">جاری</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">تحویل شده</button>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">

                    </div>
                  </div>
                  {{-- <div class="list-group mt-5">
                    <a href="#" class="list-group-item list-group-item-action" aria-current="true">
                      <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">List group item heading</h5>
                        <small>3 days ago</small>
                      </div>
                      <p class="mb-1">Some placeholder content in a paragraph.</p>
                      <small>And some small print.</small>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                      <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">List group item heading</h5>
                        <small class="text-muted">3 days ago</small>
                      </div>
                      <p class="mb-1">Some placeholder content in a paragraph.</p>
                      <small class="text-muted">And some muted small print.</small>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                      <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">List group item heading</h5>
                        <small class="text-muted">3 days ago</small>
                      </div>
                      <p class="mb-1">Some placeholder content in a paragraph.</p>
                      <small class="text-muted">And some muted small print.</small>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                          <h5 class="mb-1">List group item heading</h5>
                          <small class="text-muted">3 days ago</small>
                        </div>
                        <p class="mb-1">Some placeholder content in a paragraph.</p>
                        <small class="text-muted">And some muted small print.</small>
                      </a>
                  </div> --}}
            </div>
        </div>
    </div>
</section>
{{-- Modal --}}
<div class="modal fade" id="pay-modal" tabindex="-1" aria-labelledby="pay-modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="pay-modal">پرداخت نقدی</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="h4 text-center text-secondary">صورت حساب سفارشات</div>
                        <table class="table text-center mt-4">
                            <thead>
                              <tr>
                                <th scope="col">مجموع قیمت سفارشات</th>
                                <th scope="col">بدهی</th>
                                <th id="minToPayTh" scope="col">حد اقل پرداخت نقدی</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td class="sumToPay" style="font-size: 20px; letter-spacing: 2px;"></td>
                                <td class="debt text-danger" style="font-size: 20px; letter-spacing: 2px;"></td>
                                <td class="minToPay" id="minToPayTd" style="font-size: 20px; letter-spacing: 2px;"></td>
                              </tr>
                            </tbody>
                          </table>
                          <div class="mb-3 text-center">
                            <span class="">مقدار پرداخت نقدی:</span>
                            <input type="text" class="form-control mt-2 text-center" id="pay-amount"
                            placeholder="" value=""
                             style="letter-spacing: 3px; font-size: 20px;">
                          </div>
                          <div class="d-grid gap-2 col-6 mx-auto  w-100">
                            <button id="pay" class="btn btn-success" type="button">پرداخت از طریق درگاه آنلاین</button>
                          </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

<button id="check-modal-btn" style="display: none" data-bs-toggle="modal" data-bs-target="#check-modal"></button>
  <div class="modal fade" id="check-modal" tabindex="-1" aria-labelledby="check-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="pay-modal">تسویه بدهی</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="h4 text-center text-secondary">صورت حساب سفارشات</div>
                        <table class="table text-center mt-4">
                            <thead>
                              <tr>
                                <th scope="col">مجموع قیمت سفارشات</th>
                                <th scope="col">بدهی</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td id="check-sum-pay" class="sumToPay" style="font-size: 20px; letter-spacing: 3px; font-weight: bold"></td>
                                <td id="check-debt"  class="text-danger debt" style="font-size: 20px; letter-spacing: 3px; font-weight: bold"></td>
                              </tr>
                            </tbody>
                          </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-4">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                              <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">ثبت چک جدید</button>
                              <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">پرداخت نقدی</button>
                            </div>
                          </nav>
                          <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="h5 text-center mt-3">ثبت چک جدید</div>
                                <div class="row mt-4 check-row">
                                    <div class="col">
                                        <input type="text" class="form-control text-center tracking-code" placeholder="شماره صیادی" aria-label="">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control text-center check-amount" placeholder="مبلغ" aria-label="">
                                    </div>
                                    <div class="col">
                                        <input style="text-align: center" type="text" class="form-control due-date" id="dp1" placeholder="انتخاب تاریخ">
                                    </div>
                                    <div class="col">
                                        <button class="btn btn-outline-primary w-100 submit-check" type="button">ثبت</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12" id="checks-table">

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="row">
                                    <div class="col-8 mx-auto mb-5 mt-5 input-group w-75">
                                            <input type="text" class="form-control  text-center" id="cash-pay-amount"
                                            placeholder="مبلغ پرداختی را وارد کنید..." value=""
                                             style="font-size: 20px;">
                                            <button id="pay-pending" class="btn btn-success" type="button">پرداخت از طریق درگاه آنلاین</button>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="h4 text-center mb-4 text-secondary">
                                            پرداخت های انجام شده
                                        </div>
                                        <table class="table text-center table-bordered">
                                            <thead style="background: #e8effa">
                                                <td>#</td>
                                                <td>مبلغ</td>
                                                <td>تاریخ پرداخت</td>
                                            </thead>
                                            <tbody id="cash-payments-table"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

<button id="dtl-modal-btn" style="display: none;" data-bs-toggle="modal" data-bs-target="#dtl-modal"></button>
  <!-- Modal -->
  <div class="modal fade" id="dtl-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="dtl-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="dtl-modal-title"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="dtl-modal-body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section("scripts")
<script src="{{asset("js/navbar.js")}}"></script>
<script src="{{asset("js/jquery.js")}}"></script>
<script src="{{asset("js/datepicker.js")}}"></script>
<script src="{{asset("js/sweet.js")}}"></script>
<script type="text/javascript">
    $(function() {
        $("#dp1, #dp2, #dp3").persianDatepicker({
            cellWidth: 25,
            cellHeight: 20,
            fontSize: 15,
        });
    });
</script>
<script>
    $(document).ready(function() {
        let debt;
        let watingOrderId;
        let checkOrderId;
        getDebt();
        getWatings();
        getPendings();
        getFinalizeds();
        $("#debt").html(debt);
        function getDebt() {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('debt-details')}}",
                type:"GET",
                async:false
            }).done(function(resp) {
                let details = resp['debt_details'];
                if(resp["result"] == true) {
                    $("#totalDebt").html(details['totalDebt']);
                    $(".sumToPay").html(details['sumToPay']);
                    $(".minToPay").html(details['minCashPayment']);
                    $(".debt").html(details['debt']);
                    $("#checkMax").html(details["maxCheckPayment"]);
                    if(details["isMinCashPayed"] == false) {
                        $("#pay-amount").val(details["minCashPayment"]);
                        $("#minToPayTh, #minToPayTd").show();
                    }
                    else{
                        $("#minToPayTh, #minToPayTd").hide();
                    }
                    console.log(resp);
                }
            });
        }
        function getWatings() {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('waitings')}}",
                type:"GET"
            }).done(function(resp) {
                if(resp["orderId"] != false) {
                    watingOrderId = resp["orderId"]
                    let table = `<div class="d-flex justify-content-between">
                                 <div class="h5 mt-4">شماره فاکتور: &nbsp;&nbsp;<span class="text-danger">${resp["invoiceNumber"]}</span></div>
                                 <div class="mt-5"><button class="btn btn-primary btn-sm" id="pay-btn" type="button" data-bs-toggle="modal" data-bs-target="#pay-modal">تسویه نقدی سفارش</button></div>
                                </div>
                                <table class="table table-striped table-hover mt-4 text-center">
                            <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">نام محصول</th>
                                  <th scope="col">تعداد</th>
                                  <th scope="col">قیمت واحد (تومان)</th>
                                  <th scope="col">قابل پرداخت</th>
                                </tr>
                              </thead>
                              <tbody>`;
                    $(resp['records']).each(function() {
                        let row = `<tr>`;
                            row += `<td>${this['id']}</td>`;
                            row += `<td>${this['product']['name']}</td>`;
                            row += `<td>${this['count']}</td>`;
                            row += `<td>${this['unit_price']}</td>`;
                            row += `<td>${this['payable']}</td>`;
                            row += `</tr>`;
                        table += row;
                    })
                    table += `</tbody></table>`;
                    $("#home").html(table);
                }
                else{
                    $("#home").html(`<div class="mt-5 text-center text-secondary h5">سفارشی یافت نشد</div>`);
                }
            });
        }
        function getPendings() {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('not-delivered-pendings')}}",
                type:"GET"
            }).done(function(resp) {
                if(resp["result"] == true) {
                    let table = `<table class="table table-striped table-hover mt-4 text-center">
                            <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">شماره فاکتور</th>
                                  <th scope="col">قابل پرداخت</th>
                                  <th scope="col">بدهی</th>
                                  <th scope="col">جزئیات</th>
                                  <th scope="col">تسویه بدهی</th>
                                  <th scope="col">تاریخ تحویل</th>
                                </tr>
                              </thead>
                              <tbody>`;
                    $(resp['records']).each(function() {
                        let row = `<tr>`;
                            row += `<td>${this['id']}</td>`;
                            row += `<td>${this['invoice_number']}</td>`;
                            row += `<td>${this['payable']}</td>`;
                            row += `<td>${this['debt']}</td>`;
                            row += `<td id='${this['id']}' style='cursor:pointer;' class='text-primary dtl-btn'>مشاهده</td>`;
                            row += `<td data-id='${this['id']}' style='cursor:pointer;' class='text-primary add-checks'>پرداخت</td>`;
                            let deliveryTime = `نا مشخص`;
                            if(this["delivery_time"] != null) { deliveryTime = this['delivery_time'] }
                            row += `<td class='text-secondary'>${deliveryTime}</td>`;
                            row += `</tr>`;
                        table += row + `</tr>`;
                    })
                    table += `</tbody></table>`;
                    $("#profile").html(table);
                    if(resp["records"].length < 1) {
                        $("#profile").html(`<div class="mt-5 text-center text-secondary h5">سفارشی یافت نشد</div>`);
                    }
                }
            });
        }
        function getFinalizeds() {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('finalizeds')}}",
                type:"GET"
            }).done(function(resp) {
                if(resp["result"] == true) {
                    let table = `<table class="table table-striped table-hover mt-4 text-center">
                            <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">شماره فاکتور</th>
                                  <th scope="col">دریافت فاکتور</th>
                                </tr>
                              </thead>
                              <tbody>`;
                    let i = 0;
                    $(resp['records']).each(function() {
                        let route = "{{route('invoice')}}" + "?order=" + this['id'];
                        let row = `<tr>`;
                            row += `<td>${++i}</td>`;
                            row += `<td>${this['invoice_number']}</td>`;
                            row += `<td id='${this['id']}' style='cursor:pointer;' class='text-primary imvoice-btn'>
                                    <a href='${route}'>دریافت</a>
                                </td>`;
                            row += `</tr>`;
                        table += row + `</tr>`;
                    })
                    table += `</tbody></table>`;
                    $("#contact").html(table);
                    if(resp["records"].length < 1) {
                        $("#contact").html(`<div class="mt-5 text-center text-secondary h5">سفارشی یافت نشد</div>`);
                    }
                }
            });
        }
        function separateString(str) {
            let inp = str;
            let len = inp.length;
            let separated = "";
            let counter = 1;
            for(let i = len - 1; i >= 0; --i) {
                separated = inp[i] + separated;
                if(counter % 3 == 0 && counter < len){
                    separated = "," + separated;
                }
                ++counter;
            }
            return separated;
        }
        function orderDebt(orderId) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('order-debt')}}",
                type:"GET",
                data:{order_id: orderId}
            }).done(function(resp) {
                if(resp['result'] == true) {
                    $("#check-sum-pay").html(resp['payable']);
                    $("#check-debt").html(resp['debt']);
                }
            })
        }
        function getChecks(orderId) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('has-wating')}}",
                type:"GET",
                data:{order_id: orderId}
            }).done(function(resp) {
                if(resp["result"] == true ) {
                    let len = resp["checks"].length;
                    let checks = resp["checks"];
                    if(len > 0) {
                        let table = `<table class="table table-striped table-hover mt-4 text-center">
                            <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">شماره صیادی</th>
                                  <th scope="col">مبلغ</th>
                                  <th scope="col">تاریخ سر رسید</th>
                                </tr>
                              </thead>
                              <tbody>`;
                        for(let i = 0; i < len; ++i) {
                            table += `<tr>`;
                            table += `<td>${i + 1}</td>`;
                            table += `<td>${checks[i]['tracking_code']}</td>`;
                            table += `<td>${checks[i]['amount']}</td>`;
                            table += `<td>${checks[i]['due_date']}</td>`;
                            table += `</tr>`;
                        }
                        table += `</tbody></table>`;
                        $("#checks-table").html(table);
                    }
                    else{
                        $("#checks-table").html("");
                    }
                }
            });
        }
        function getTotalDebt() {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('total-debt')}}",
                type:"GET"
            }).done(function(resp) {
                if(resp['result'] == true) {
                    $("#totalDebt").html(resp['debt']);
                }
            })
        }
        function payCash(amount, orderId) {
          let resp = false;
          $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('pay')}}",
                type:"POST",
                async:false,
                data: {
                    amount: amount.replace(/,/g, ""),
                    type: 1, // cash payment type
                    payment_status: 1,
                    order_id: orderId
                }
            }).done(function(response) {
                if(response['error'] == 'MIN_CASH') {
                    Swal.fire({
                        title:"خطا در پرداخت",
                        html:"مبلغ وارد شده کمتر از حداقل مقدار پرداختی است!",
                        icon: 'error',
                        showConfirmButton: true,
                    })
                    return;
                }
               if(response['error'] == 'OVER_DEBT') {
                    Swal.fire({
                        title:"خطا در پرداخت",
                        html:"مبلغ وارد شده بیشتر از مقدار بدهی است!",
                        icon: 'error',
                        showConfirmButton: true,
                    })
                    return;
                }
                if(response['error'] == 'INVALID') {
                    Swal.fire({
                        title:"خطا در پرداخت",
                        html:"مقادیر وارد شده نا معتبر است",
                        icon: 'error',
                        showConfirmButton: true,
                    })
                    return;
                }

                if(response["result"] == true) {
                    resp = response;
                }
            });
            return resp;
        }
        function getCashPayments(orderId) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('order-cash-payments-list')}}",
                type:"GET",
                async:false,
                data: {
                    order_id: orderId
                }
            }).done(function(response) {
              $("#cash-payments-table").empty();
              if(response["result"] == true) {
                let i = 1;
                $(response["payments"]).each(function() {
                    let row = `<tr>`;
                        row += `<td>${i}</td>`;
                        row += `<td>${this['amount']}</td>`;
                        row += `<td>${this['created_at']}</td>`;
                        row += `</tr>`;
                        i += 1;
                    $("#cash-payments-table").append(row);
                })
              }
            });
        }
        function errorMsg(msg) {
            Swal.fire({
                title:"خطا در ثبت",
                html: msg,
                icon: 'error',
                showConfirmButton: true,
            })
        }

        $("#pay").on("click", function() {
          let resp = payCash($("#pay-amount").val(), watingOrderId);
          if(resp['error'] == 'OVER_DEBT') {
            console.log('overrr');
          }
          if(resp["result"] == true) {
              getDebt();
              getPendings();
              if (resp["minPayed"] == true) {
                  $("#home").empty();
                  $("#home").html(`<div class="mt-5 text-center text-secondary h5">سفارشی یافت نشد</div>`);
              }
          }
        });

        $("#pay-amount, .check-amount, #cash-pay-amount").on("input", function(e) {
            let separated = separateString($(this).val().replace(/,/g, ""));
            $(this).val(separated);
        });

        $(document).on("click","#pay-btn", function() {
            getDebt();
        })

        $(document).on("click", ".submit-check", function() {
            let row = $(this).parents()[1];
            let trackingCode = $(row).find(".tracking-code").val();
            let amount = $(row).find(".check-amount").val();
            let dueDate = $(row).find(".due-date").val();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('add-check')}}",
                type:"POST",
                data:{
                    order_id:checkOrderId,
                    tracking_code:trackingCode,
                    amount:amount.replace(/,/g, ""),
                    duedate:dueDate,
                    payment_type:2
                }
            }).done(function(resp) {
                if (resp['error'] == 'OVER_TIME') {
                    errorMsg("بازه تاریخی مجاز برای ثبت چک از تاریخ امروز تا ۳ ماه آینده میباشد!");
                    return false;
                }
                if (resp['error'] == 'INVALID') {
                    errorMsg("مقادیر وارد شده نا معتبر است.");
                    return false;
                }
                if(resp['error'] == 'OVER_DEBT') {
                    Swal.fire({
                        title:"خطا در پرداخت",
                        html:"مبلغ وارد شده بیشتر از مقدار بدهی است!",
                        icon: 'error',
                        showConfirmButton: true,
                    })
                    return;
                }
                if(resp["result"] == true) {
                    $(".check-row").find("input").val("");
                    getChecks(checkOrderId);
                    orderDebt(checkOrderId);
                    getTotalDebt();
                    Swal.fire(
                        'ثبت موفق !',
                        `چک با شماره صیادی ${trackingCode} با موفقیت ثبت شد.`,
                        'success'
                    )
                }
            });
        });

        $(document).on("click", ".dtl-btn", function() {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('orderDetails')}}",
                type:"GET",
                data:{order_id: $(this).attr("id")}
            }).done(function(resp) {
                if(resp["result"] == true) {
                    let table = `<table class="table table-striped table-hover mt-4 text-center">
                            <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">نام محصول</th>
                                  <th scope="col">تعداد</th>
                                  <th scope="col">قیمت واحد (تومان)</th>
                                  <th scope="col">قابل پرداخت</th>
                                </tr>
                              </thead>
                              <tbody>`;
                    $(resp["records"]).each(function() {
                        let row = `<tr>`;
                            row += `<td>${this['id']}</td>`;
                            row += `<td>${this['product']['name']}</td>`;
                            row += `<td>${this['count']}</td>`;
                            row += `<td>${this['unit_price']}</td>`;
                            row += `<td>${this['payable']}</td>`;
                            table += row;
                    });
                    $("#dtl-modal-title").html(`جزئیات سفارش &nbsp; <span class='text-danger'>${resp['invoice_number']}<span>`)
                    $("#dtl-modal-body").html(table);
                }
            });
            $("#dtl-modal-btn").click();
        })

        $(document).on("click", ".add-checks", function() {
            checkOrderId = $(this).attr("data-id");
            orderDebt(checkOrderId);
            getChecks(checkOrderId);
            getCashPayments(checkOrderId);
            $("#check-modal-btn").click();
        })
        $(document).on("click", "#pay-pending", function() {
          let amount = $("#cash-pay-amount").val();
          resp = payCash(amount, checkOrderId);
        });
        $("#logout").on("click", function() {
          $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('logout')}}",
                type:"POST",
            }).done(function(resp) {
              if (resp['result'] == true) {
                window.location.href = resp['redirect'];
              }
            })
        })
    });
</script>
@endsection

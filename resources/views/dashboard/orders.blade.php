@extends("main")

@section("styles")
<link rel="stylesheet" href="{{asset("css/bootstrap.css")}}">
<link rel="stylesheet" href="{{asset("css/fonts.css")}}">
<link rel="stylesheet" href="{{asset("css/dashboard.css")}}">
<link rel="stylesheet" href="{{asset("css/datepicker.css")}}">
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
            <div class="h4 mt-5 mb-4">فهرست سفارشات</div>
{{--            <div class="mb-5 mx-auto d-flex justify-around">--}}
                <div class="row">
                    <div class="col-md-6 col-sm-12 mb-4">
                        <input type="search" class="form-control" id="order-search" placeholder="جستجوی سفارشات">
                    </div>
                    <div class="col-md-6 col-sm-12 mb-4">
                        <select class="form-select" id="order-status">
                            <option selected value="2">سفارشات جاری</option>
                            <option value="3">سفارشات تحویل شده</option>
                        </select>
                    </div>
                </div>
{{--            </div>--}}
            <table class="table text-center">
                <thead style="background: #e7e5ff"><tr>
                    <th scope="col">#</th>
                    <th scope="col">نام مشتری</th>
                    <th scope="col">شماره فاکتور</th>
                    <th scope="col">پرداخت ها</th>
                    <th scope="col">جزئیات سفارش</th>
                    <th scope="col">فاکتور</th>
                    </tr>
                </thead>
                <tbody id='orders-table' style=" font-size:18px;">
                </tbody>
            </table>

            {{-- Payments Modal --}}
            <button id="payments-modal-btn" type="button" style="display: none" data-bs-toggle="modal" data-bs-target="#paymentsModal">
            </button>
            <div class="modal fade" id="paymentsModal" tabindex="-1" aria-labelledby="paymentsModal" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="paymentsModal">پرداخت های مشتری</h5>
                      <button id="" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="payments-modal-body">
                        <div class="h5 text-center mt-3 mb-4" id="order-debt-title"></div>
                        <table class="table text-center">
                            <thead style="background: #e7e5ff"><tr>
                                <th scope="col">قابل پرداخت</th>
                                <th scope="col">پرداخت شده</th>
                                <th scope="col">بدهی</th>
                                </tr>
                            </thead>
                            <tbody id='orders-table' style=" font-size:18px;">
                                <tr id="payments-row">
                                    <td class="text-secondary" id="order-payable"></td>
                                    <td class="text-success" id="order-payed"></td>
                                    <td class="text-danger" id="order-debt"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="h5 text-center mt-4 mb-4">فهرست پرداخت ها</div>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="headingOne">
                                <button  class="cash-details-btn accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                  پرداخت های نقدی
                                </button>
                              </h2>
                              <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div id="" class="accordion-body">
                                    <table class="table text-center table-bordered">
                                        <thead style="background: #ebebeb"><tr>
                                            <th scope="col">#</th>
                                            <th scope="col">مبلغ</th>
                                            <th scope="col">تاریخ پرداخت</th>
                                            </tr>
                                        </thead>
                                        <tbody id='cash-payments-table' style=" font-size:18px;">
                                        </tbody>
                                    </table>
                                </div>
                              </div>
                            </div>
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed check-details-btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                  چک های ثبت شده
                                </button>
                              </h2>
                              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <table class="table text-center">
                                        <thead style="background: #e7e5ff"><tr>
                                            <th scope="col">#</th>
                                            <th scope="col">مبلغ</th>
                                            <th scope="col">شماره صیادی چک</th>
                                            <th scope="col">تاریخ ثبت</th>
                                            <th scope="col">تاریخ سر رسید</th>
                                            </tr>
                                        </thead>
                                        <tbody id='check-payments-table' style=" font-size:18px;">
                                        </tbody>
                                    </table>
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                    </div>
                  </div>
                </div>
              </div>

              {{-- Order Details Modal --}}

              <button id="details-modal-btn" type="button" style="display: none" data-bs-toggle="modal" data-bs-target="#detailsModal">
              </button>

              <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModal" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="detailsModal">جزئیات سفارش</h5>
                      <button id="close-dtl-modal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="h5 text-center mt-4 mb-4">سفارش <span class="text-danger" id="order-dtl-title"></span></div>
                      <table class="table borderless text-center">
                        <thead style="background: #e7e5ff"><tr>
                            <th scope="col">#</th>
                            <th scope="col">نام کالا</th>
                            <th scope="col">تعداد</th>
                            <th scope="col">رنگ</th>
                            </tr>
                        </thead>
                        <tbody id='details-table' style=" font-size:18px;">
                            <tr id="details-row">
                                <td class="text-secondary" id="product-name"></td>
                                <td class="text-success" id="product-count"></td>
                                <td class="text-secondary" id="product-color"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 mt-3 mb-3">
                            <label class="mb-2" for="">تاریخ تحویل سفارش :</label>
                            <input type="text"  class="order-deltime form-control text-center">
                        </div>
                        <div class="col-md-6 col-sm-12 mt-3 mb-3">
                            <label class="mb-2" for="">وضعیت سفارش :</label>
                            <select id="order-del-time" class="form-control order-status">
                                <option disabled value="1">انتخاب وضعیت</option>
                                <option value="2">در حال ساخت</option>
                                <option value="3">تحویل شده</option>
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                      <button id="save-dtl-changes" type="button" class="btn btn-primary">ذخیره تغییرات</button>
                    </div>
                  </div>
                </div>
              </div>
        </main>
    </div>
  </div>
@endsection

@section("scripts")
<script src="{{asset("js/jquery.js")}}"></script>
<script src="{{asset("js/sweet.js")}}"></script>
<script src="{{asset("js/datepicker.js")}}"></script>

<script>
    $(document).ready(function() {
        let pendingOrders = 2;
        let currentDelInput;
        let orderId;
        ordersList(pendingOrders);
        function toFa(str) {
            let fa = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
            let en = ["0","1","2","3","4","5","6","7","8","9"];
            for(let i=0; i<str.length; ++i) {
                if(en.includes(str[i])) {
                    str = str.replace(str[i], fa[str[i]]);
                }
            }
            return str;
        }
        function ordersList(orderStatus) {
            $("#orders-table").empty();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('orders-list')}}",
                type:"GET",
                data:{status:orderStatus}
            }).done(function(resp) {
                let i = 1;
                if (resp['result'] == true) {
                    $(resp['orders']).each(function() {
                        let row = `<tr id='${this['invoice_number']}'>`;
                            row += `<td>${i}</td>`;
                            row += `<td>${this['user']['name']} ${this['user']['lastname']}</td>`;
                            row += `<td>${this['invoice_number']}</td>`;
                            row += `<td data-id='${this['id']}' style='cursor:pointer;' class='order-payments text-warning'><i class='bx bxs-dollar-circle'></i></td>`;
                            row += `<td data-id='${this['id']}' style='cursor:pointer;' class='text-primary order-details'><i class='bx bx-cart'></i></td>`;
                            row += `<td data-invoice="${this['invoice']}" style='cursor:pointer;' class='text-secondary invoice-td'><i class='bx bx-notepad'></i></td>`;
                            row += `</tr>`;
                        $("#orders-table").append(row);
                        ++i;
                    });
                }
            });
        }
        function orderDebtDetails(orderId) {
            let details;
            let currentOrderId;
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('order-debt')}}",
                type:"GET",
                async:false,
                data:{order_id:orderId}
            }).done(function(resp) {
                details = resp;
            });
            return details;
        }
        function getCashPayments(orderId) {
            $("#cash-payments-table").empty();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('order-cash-payments')}}",
                type:"GET",
                data:{order_id:orderId}
            }).done(function(resp) {
                if (resp['result'] == true) {
                    $(resp['payments']).each(function() {
                        let i = 1;
                        let row = `<tr>`;
                            row += `<td>${i}</td>`;
                            row += `<td>${this['amount']}</td>`;
                            row += `<td>${this['created_at']}</td>`;
                            row += `</tr>`;
                            ++i;
                            $("#cash-payments-table").append(row);
                    });
                    let sum = `<tr style="background:#f2ffee;"><td colspan="1">مجموع</td><td colspan="2">${resp['sum']}</td></tr>`;
                    $("#cash-payments-table").append(sum);
                }
            });
        }
        function getChecks(orderId) {
            $("#check-payments-table").empty();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('order-checks')}}",
                type:"GET",
                data:{order_id:orderId}
            }).done(function(resp) {
                if (resp['result'] == true) {
                    $(resp['checks']).each(function() {
                        let i = 1;
                        let row = `<tr>`;
                            row += `<td>${i}</td>`;
                            row += `<td>${this['amount']}</td>`;
                            row += `<td>${this['tracking_code']}</td>`;
                            row += `<td>${this['created_at']}</td>`;
                            row += `<td>${this['due_date']}</td>`;
                            row += `</tr>`;
                            ++i;
                            $("#check-payments-table").append(row);
                    });
                    let sum = `<tr style="background:#f2ffee;"><td colspan="2">مجموع</td><td colspan="3">${resp['sum']}</td></tr>`;
                    $("#check-payments-table").append(sum);
                }
            });
        }
        function orderProducts(orderId) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('order-products')}}",
                type:"GET",
                data:{order_id:orderId}
            }).done(function(resp) {
                if(resp["result"] == true) {
                    $(function() {
                    $(".order-deltime").persianDatepicker({
                            cellWidth: 25,
                            cellHeight: 20,
                            fontSize: 15,
                        });
                    });
                    $("#details-table").empty();
                    let i = 1;
                    $(resp['products']).each(function() {
                        let row = `<tr id="${this['id']}">`;
                        row += `<td>${i}</td>`;
                        row += `<td>${this['product']['name']}</td>`;
                        row += `<td>${this['color']['name']}</td>`;
                        row += `<td>${this['count']}</td>`;
                        ++i;
                        $("#details-table").append(row);
                    });
                    $(".order-status").val(resp["status"]);
                    if(resp["deltime"] != null) {
                        $(".order-deltime").val(resp["deltime"]);
                    }
                }
            });
        }
        // Events
        $(document).on("click", ".order-payments", function() {
            currentOrderId = $(this).attr("data-id");
            getCashPayments(currentOrderId);
            getChecks(currentOrderId);
            let details = orderDebtDetails(currentOrderId);
            let invoiceNumber = $($(this).parents()[0]).attr("id");
            $("#order-debt-title").html(`وضعیت بدهی سفارش <span class="text-danger">${invoiceNumber}</span>`);
            $("#order-payable").html(details['payable']);
            $("#order-payed").html(details['payed']);
            $("#order-debt").html(details['debt']);
            $("#payments-modal-btn").click();
        });

        $(document).on("click", ".order-details", function() {
            let invoiceNumber = $($(this).parents()[0]).attr("id");
            orderId = $(this).attr("data-id");
            orderProducts(orderId);
            $("#order-dtl-title").html(invoiceNumber);
            $("#details-modal-btn").click();
        })

        $(document).on("click", "#save-dtl-changes", function() {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('update-details')}}",
                type:"POST",
                data:{
                    order_id:orderId,
                    del_time: $(".order-deltime").val(),
                    status: $(".order-status").val()
                }
            }).done(function(resp) {
                if(resp["result"] == true) {
                    $("#close-dtl-modal").click();
                    ordersList($("#order-status").val());
                    setTimeout(() => {
                        Swal.fire(
                            'ثبت موفق !',
                            `تغییرات با موفقیا اعمال شد`,
                            'success'
                        )
                    }, 500);
                }
            });
        });

        $(document).on("click", ".order-deltime, .cell",function() {
            if(this.tagName == 'DIV') {
                let fa = toFa($(this).attr("data-jdate"));
                currentDelInput.val(fa);
            }
            else { currentDelInput = $(this) }
        });

        $("#order-status").on("change", function() {
            ordersList($(this).val());
        });

        $(document).on("click", ".invoice-td", function() {
            window.location.href = $(this).attr("data-invoice");
        });
    });
</script>
@include("dashboard.footer")
<script type="text/javascript">

</script>

@endsection

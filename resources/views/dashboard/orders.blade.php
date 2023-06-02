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
            <div class="h4 mt-5 mb-4">فهرست سفارشات</div>
            <div class="mb-5 mx-auto d-flex justify-around">
                <input type="search" class="form-control" id="order-search" placeholder="جستجوی سفارشات">
                <select class="form-select">
                    <option selected>وضعیت سفارش</option>
                    <option value="1">جاری</option>
                    <option value="2">تحویل کامل</option>
                  </select>
            </div>
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
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                    <table class="table text-center">
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
        let pendingOrders = 2;
        ordersList(pendingOrders);
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
                            row += `<td style='cursor:pointer;' class='text-primary'><i class='bx bx-cart'></i></td>`;
                            row += `<td style='cursor:pointer;' class='text-secondary'><i class='bx bx-notepad'></i></td>`;
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
                    })
                }
            });
        }
        // Events
        $(document).on("click", ".order-payments", function() {
            currentOrderId = $(this).attr("data-id");
            getCashPayments(currentOrderId);
            let details = orderDebtDetails(currentOrderId);
            let invoiceNumber = $($(this).parents()[0]).attr("id");
            $("#order-debt-title").html(`وضعیت بدهی سفارش <span class="text-danger">${invoiceNumber}</span>`);
            $("#order-payable").html(details['payable']);
            $("#order-payed").html(details['payed']);
            $("#order-debt").html(details['debt']);
            $("#payments-modal-btn").click();
        });
    });
</script>

@endsection

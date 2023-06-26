@extends("main")


@section("styles")
<link rel="stylesheet" href="{{asset("css/bootstrap.css")}}">
<link rel="stylesheet" href="{{asset("css/fonts.css")}}">
<style>
    #phone-logo-cont {
        text-align: center;
    }

    .phone-span {
        display: inline-block;
        vertical-align: middle;
    }

    .outer-line {
        width: 40%;
        border-bottom: 1px solid rgb(156, 156, 156);
    }
  </style>
@endsection


@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-8 mt-5">
                <div class="h5 mb-3">اطلاعات مشتری</div>
                <div class="info-cont" style="padding-left: 30px;
                    padding-right: 30px;
                    padding-bottom: 15px;
                    border: 1px dotted black;
                    border-radius: 25px">
                    <div class="user-info d-flex justify-content-between mt-4">
                        <div class="name">آقای/خانم <span>{{$order->user->name . " " . $order->user->lastname}}</span></div>
                        <div class="phone">شماره تماس: <span>{{$order->user->phone_number}}</span></div>
                    </div>
                    <div class="address mt-2">
                        {{-- {{$address}} --}}
                    </div>
                </div>
                <table class="table mt-3 table-striped text-center">
                    <thead style="background: #4c4c4c;
                                    color: white;">
                        <tr>
                            <th>ردیف</th>
                            <th>شرح کالا یا خدمات</th>
                            <th>نوع رنگ</th>
                            <th>تعداد</th>
                            <th>قیمت واحد</th>
                            <th>جمع کل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 0; $totalPayable = 0; $priceSum = 0; @endphp
                        @foreach ($order->details as $detail)
                        <tr>
                            <td>{{++$i}}</td>
                            <td>{{$detail->product->name}}</td>
                            <td>{{$detail->color->name}}</td>
                            <td>{{fa_number($detail->count)}}</td>
                            <td>{{fa_number(number_format($detail->unit_price))}}</td>
                            <td>{{fa_number(number_format($detail->payable))}}</td>
                            @php
                                $totalPayable += $detail->payable;
                                $priceSum += $detail->count * $detail->unit_price;
                            @endphp
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="desc">
                    کلیه اجناس مندرج در فاکتور صحیح و سالم و با شمارش دقیق به خریدار تحویل داده شد و تمام اقلام این فاکتور تا تسویه کامل نزد مشتری امانت میباشد.
                </div>
                <div class="signs d-flex justify-content-between mt-4">
                    <div class="customer-sign">امضاء خریدار</div>
                    <div class="seller-sign">امضاء فروشنده</div>
                    <div class="price-info d-flex flex-column">
                        <div class="disc">
                            <span style="font-weight: bold">تخفیف:&nbsp; </span>
                            <span id="disc">{{fa_number(number_format($priceSum - $totalPayable))}}</span>
                        </div>
                        <div class="total">
                            <span style="font-weight: bold">مبلغ کل:&nbsp; </span>
                            <span id="total">{{fa_number(number_format($totalPayable))}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="margin-top: 100px;">
                <div class="invoice-info d-flex justify-content-around">
                    <div class="date">تاریخ:&nbsp; <span class="text-danger">{{$order->delivery_time}}</span></div>
                    <div class="invoiceno">شماره فاکتور: <span class="text-danger">{{$order->invoice_number}}</span></div>
                </div>
                <div class="img-cont d-flex justify-content-center">
                    <img src="{{asset('img/logo.png')}}" alt="">
                </div>
                <div style="margin-top: -40px;" class="h5 text-center">K & K</div>
                <p style="font-weight: bold;" class="text-secondary text-center">Karen & Kia Wood Works</p>
                <hr>
                <p class="text-center text-secondary">تولید و رنگ کاری محصولات تخصصی و سفارشی چوب</p>

                <div id="phone-logo-cont">
                    <span class="outer-line phone-span"></span>
                    <span class="bx bx-mobile-alt phone-span" aria-hidden="true"></span>
                    <span class="outer-line phone-span"></span>
                </div>

                <div class="contact-info mt-2">
                    <div class="text-center" style="text-align: left">Zehtab Moghaddam: &nbsp;0902 574 7413</div>
                    <div class="text-center" style="text-align: left">Hashemi: &nbsp;0935 451 5418</div>
                </div>

                <div id="phone-logo-cont">
                    <span class="outer-line phone-span"></span>
                    <span class="bx bxs-map phone-span" aria-hidden="true"></span>
                    <span class="outer-line phone-span"></span>
                </div>

                <div class="co-address text-center text-secondary" style="font-size: 14px;">
                    جاده مایان / بعد از شهرک مبل و خودرو / جاده اصلی<br> الوار سفلی / جنب املاک سارای
                </div>
            </div>
        </div>
    </div>
@endsection

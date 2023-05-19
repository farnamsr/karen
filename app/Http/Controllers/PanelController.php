<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Morilog\Jalali\Jalalian;

class PanelController extends Controller
{
    public function panel()
    {
        $records = [];
        $payedAmount = 0;
        $sum = 0;
        $watingOrder = User::watingOrder(auth()->id());
        if($watingOrder) {
            $details = $watingOrder->details();
            $records = $details->orderBy("created_at")->paginate(5);
            $sum = $details->sum("payable");
            $payments = $watingOrder->payments;
            if($payments) {
                $payedAmount = $payments->sum("amount");
            }
        }
        return view("panel", [
            "user" => auth()->user(),
            "sum" => $sum,
            "notPayedOrders" => $records,
            "payedAmount" => $payedAmount
        ]);
    }

    public function payment(Request $request)
    {
        $payment = Payment::pay(
            $request->amount, $request->type,
            $request->status, $request->order_id
        );
        if($payment) {
            return response()->json(["result" => true]);
        }
    }

    public static function debt(Request $request)
    {
        $order = auth()->user()->orders()
        ->where("status", Order::STATUS_WAITING_USER)
        ->first();

        $debt = 0;

        if($order) {
            $payable = $order->details()->sum("payable");
            $payed = Payment::where("order_id", $order->id)->sum("amount");
            $debt = $payable - $payed;
        }

        return response()->json([
            "result" => true,
            "debt" => fa_number(number_format($debt))
        ]);
    }

}

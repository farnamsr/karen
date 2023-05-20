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
        $watingOrder = User::watingOrder(auth()->id());
        if($watingOrder) {
            $details = $watingOrder->details();
            $records = $details->orderBy("created_at")->paginate(5);
        }
        return view("panel", [
            "user" => auth()->user(),
            "notPayedOrders" => $records,
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

    public static function debtDetails(Request $request)
    {
        $debtDetails = User::debtDetails(auth()->id());
        return response()->json([
            "result" => true,
            "debt_details" => $debtDetails
        ]);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\CheckDetail;
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
        $request['amount'] = en_number($request['amount']);
        $payment = Payment::pay(
            $request->amount, $request->type,
            $request->payment_status, $request->order_id
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

    public function addCheck(Request $request)
    {
        DB::beginTransaction();
        $request["amount"] = str_replace(",", "", $request["amount"]);
        $explodedDate = explode("/", $request["duedate"]);
        $request["duedate"] = strtotime((new Jalalian($explodedDate[0], $explodedDate[1], $explodedDate[2]))
            ->toCarbon()->toDateTimeString());
        $request["payment_status"] = Payment::STATUS_PAYED;
        $request["type"] = Payment::TYPE_CHECK;
        try{
            $this->payment($request);
            $check = CheckDetail::create([
                "order_id" => $request["order_id"],
                "amount" => $request["amount"],
                "due_date" => $request["duedate"],
                "tracking_code" => $request["tracking_code"]
            ]);
            DB::commit();
            return response()->json(["result" => true]);
        }
        catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function hasWatingOrder(Request $request)
    {
        $hasWatingOrder = false;
        $order = User::watingOrder(auth()->id());
        $checks = [];
        if($order) {
            $hasWatingOrder = true;
            $checks = $order->checks()->orderBy("created_at")->get();
        }
        return response()->json([
            "result" => true,
            "hasWating" => $hasWatingOrder,
            "checks" => $checks
        ]);
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
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
        return view("panel", [
            "user" => auth()->user(),
        ]);
    }

    public function payment(Request $request)
    {
        $minPayed = false;
        $watingOrder = User::watingOrder(auth()->id());
        $payment = Payment::pay(
            $request->amount, $request->type,
            $request->payment_status, $request->order_id
        );
        if($payment) {
            if ($watingOrder) {
                $sumToPay = User::watingSumToPay($watingOrder);
                $minToPay = User::minCashPayment($sumToPay);
                $payed = $watingOrder->payments()
                ->where("type", Payment::TYPE_CASH)
                ->sum("amount");
                if ($payed >= $minToPay) {
                    $watingOrder->status = Order::STATUS_MIN_PAIED;
                    $watingOrder->save();
                    $minPayed = true;
                }
            }
            return response()->json([
                "result" => true,
                "minPayed" => $minPayed
            ]);
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
            $hasWatingOrder = $order->id;
            $checks = $order->checks()->orderBy("created_at")->get();
        }
        return response()->json([
            "result" => true,
            "hasWating" => $hasWatingOrder,
            "checks" => $checks
        ]);
    }

    private function faFormat($records)
    {
        foreach ($records as $record) {
            $record["unit_price"] = fa_number(number_format($record["unit_price"]));
            $record["payable"] = fa_number(number_format($record["payable"]));
            $record["count"] = fa_number(number_format($record["count"]));
        }
        return $records;
    }
    public function waitings(Request $request)
    {
        $records = [];
        $orderId = false;
        $invoiceNumber = false;
        $watingOrder = User::watingOrder(auth()->id());
        if($watingOrder) {
            $orderId = $watingOrder->id;
            $invoiceNumber = fa_number($watingOrder->invoice_number);
            $details = $watingOrder->details()->with("product");
            $records = $this->faFormat($details->orderBy("created_at")->get());
        }
        return response()->json([
            "result" => true,
            "records" => $records,
            "orderId" => $orderId,
            "invoiceNumber" => $invoiceNumber
        ]);
    }
    public function pendings(Request $request)
    {
        $records = User::notDeliveredPendings(auth()->id());
        foreach($records as $record) {
            $payable = 0; $payed = 0;
            foreach($record['details'] as $dtl) {
                $payable += $dtl["payable"];
            }
            foreach($record['payments'] as $payment) {
                $payed += $payment["amount"];
            }
            $record["payable"] = fa_number(number_format($payable));
            $record["debt"] = fa_number(number_format($payable - $payed));
            $record["invoice_number"] = fa_number($record['invoice_number']);
        }
        return response()->json([
            "result" => true,
            "records" => $records
        ]);
    }
    public function orderDetails(Request $request)
    {
        $order = Order::where("id", $request->order_id)->first();
        $details = $order->details()->with("product")->get();
        foreach($details as $detail) {
            $detail["unit_price"] = fa_number(number_format($detail["unit_price"]));
            $detail["payable"] = fa_number(number_format($detail["payable"]));
            $detail["count"] = fa_number($detail["count"]);
        }
        return response()->json([
            "result" => true,
            "records" => $details,
            "invoice_number" => fa_number($order->invoice_number)
        ]);
    }
}

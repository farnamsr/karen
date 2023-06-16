<?php

namespace App\Http\Middleware;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use \Morilog\Jalali\Jalalian;


class DebtAmount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request["amount"] = en_number(
            str_replace(",", "", $request["amount"])
        );
        $validator = Validator::make($request->all(), [
            "amount" => "required|regex:/^[1-9][0-9]*$/",
            "tracking_code" => "required_if:type,2|regex:/^[1-9][0-9]*$/",
            "duedate" => "required_if:type,2"
        ]);

        if($validator->fails()) {
            return response()->json([
                "result" => false,
                "error" => "INVALID",
                "messages" => $validator->messages()
            ]);
        }

        if($request["type"] == Payment::TYPE_CASH) {
            $order = Order::where("id", $request->order_id)->first();
            if(! $order->payments()->where("type", Payment::TYPE_CASH)->exists()) {
                $sumToPay = User::watingSumToPay($order);
                $minCashPayment = User::minCashPayment($sumToPay);
                if($request->amount < $minCashPayment) {
                    return response()->json([
                        "result" => false,
                        "error" => "MIN_CASH"
                    ]);
                }
            }
        }

        if($request["duedate"]) {
            $explodedDate = explode("/", $request["duedate"]);
            $request["duedate"] = strtotime((new Jalalian($explodedDate[0], $explodedDate[1], $explodedDate[2]))
                ->toCarbon()->toDateTimeString());

            $isToday = (new Jalalian($explodedDate[0], $explodedDate[1], $explodedDate[2]))->isToday();

            if(
                $request["duedate"] > (time() + (3600 * 24 * 90)) ||
                ($isToday != true && $request["duedate"] < time())
                )
                {
                    return response()->json([
                        "result" => false,
                        "error" => "OVER_TIME",
                    ]);
                }
        }

        $amount = $request->amount;
        $debt = User::orderDebt($request->order_id)['debt'];

        if($amount > $debt) {
            return response()->json([
                "result" => false,
                "error" => "OVER_DEBT"
            ]);
        }
        return $next($request);
    }
}



<?php

namespace App\Http\Middleware;

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



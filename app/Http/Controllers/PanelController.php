<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PanelController extends Controller
{
    public function panel()
    {
        $notPayedOrders = auth()->user()->orders()
            ->where("status", Order::STATUS_WAITING_USER)
            ->first()
            ->details()
            ->orderBy("created_at")
            ->paginate(5);
        return view("panel", [
            "user" => auth()->user(),
            "notPayedOrders" => $notPayedOrders
        ]);
    }
}

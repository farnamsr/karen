<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PanelController extends Controller
{
    public function panel()
    {
        $ordersStatus =  DB::table('orders')
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();
        // dd($ordersStatus);
        return view("panel", ["user" => auth()->user()]);
    }
}

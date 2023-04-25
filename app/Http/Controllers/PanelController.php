<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PanelController extends Controller
{
    public function panel()
    {
        return view("panel", [
            "user" => auth()->user(),
        ]);
    }
}

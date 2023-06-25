<?php

namespace App\Http\Controllers;
use App\Models\Color;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class ShopController extends Controller
{
    public function shop(Request $request)
    {
        $cats = Category::all();
        $requestedCats = isset($request['cats']) ? $request['cats'] : [];
        $products = Product::products($requestedCats);
        if($request->ajax()) {
            return response()->json([
                "result" => true,
                "products" => $products
            ]);
        }
        return view("shop", compact("cats", "products"));
    }
    public function product($pid)
    {
        $product = Product::where("id", $pid)->with("images")->first();
        $colors = Color::all();
        return view("product", compact('product', 'colors'));
    }
    public function order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "count" => "required|regex:/^[1-9]\d*$/",
        ]);

        if($validator->fails()) {
            return response()->json([
                "result" => false,
                "error" => "INVALID",
            ]);
        }


        DB::beginTransaction();
        try {
            $order = null;
            $waitingOrder = Order::where("user_id", auth()->user()->id)
                ->where("status", Order::STATUS_WAITING_USER)->first();
            $price = Product::where("id", $request->pid)->first()->price;
            if($waitingOrder) {$order = $waitingOrder; }
            else{
                $order = Order::create([
                    "user_id" => auth()->user()->id,
                    "status" => Order::STATUS_WAITING_USER
                ]);
                $order->invoice_number = Jalalian::now()->format("Ymd") . $order->id;
                $order->save();
            }
            $details = OrderDetail::create([
                "order_id" => $order->id,
                "product_id" => $request->pid,
                "count" => $request->count,
                "unit_price" => $price,
                "payable" => $price * $request->count,
                "color_id" => $request->color
            ]);
            DB::commit();
            return response()->json(["result" => true]);
        }
        catch (\Throwable $th) {
            DB::rollback();
            dd($th);
        }
    }
}

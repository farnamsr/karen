<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Image;
use App\Models\Order;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use \Morilog\Jalali\Jalalian;


class DashboardController extends Controller
{
    public function dashboardProducts(Request $request)
    {
        $products = Product::products();
        if($request->ajax()) {
            return response()->json([
                "result" => true,
                "products" => $products
            ]);
        }
        else{
            $cats = $this->cats($request, false);
            return view("dashboard.products", compact("cats", "products"));
        }
    }
    public function product(Request $request)
    {
        $product = Product::create([
            "name" => $request->name,
            "description" => $request->desc,
            "wholesaleـdiscount" => isset($request["wholesaleـdiscount"]) ?
                Product::WHOLE_SALE_DISC : null,
            "price" => $request->price, //todo prepairing price
            "category_id" => $request->cat
        ]);

        if ($request->hasFile('file')) {
            foreach ($request['file'] as $file) {
                $time = time();
                $img = Image::create([
                    "product_id" => $product->id,
                    "ext" => $file->extension(),
                    "created_at" => $time
                ]);
                $fileName = $product->id . "_" . $img->id . "_" . $time . "." . $file->extension();
                Storage::disk('local')->putFileAs("public/products", $file, $fileName);
             }
        }
        return response()->json(["result" => true]);
    }

    public function category(Request $request)
    {
        $cat = Category::create(["name" => $request->name]);
        return response()->json([
            "result" => true,
            "catId" => $cat->id
        ]);
    }
    public function deleteCat(Request $request)
    {
        $response = [];
        $cat = Category::where("id", $request->catId)->first();
        if($cat->products()->count() > 0) {
            $response["result"] = false;
        }
        else{
            $cat->delete();
            $response["result"] = true;
        }
        return response()->json($response);
    }
    public function cats(Request $request, $ajax = true)
    {
        $cats = Category::all();
        if($ajax) {
            return response()->json([
                "result" => true,
                "cats" => $cats
            ]);
        }
        return $cats;
    }

    // Orders

    public function dashboardOrders()
    {
        return view("dashboard.orders");
    }

    public function ordersList(Request $request)
    {
        $orders = Order::where("status", $request->status)
            ->with(['user'])->get();
        return response()->json([
            "result" => true,
            "orders" => $orders
        ]);
    }
    public function orderCashPayments(Request $request)
    {
        $payments = User::orderCashPayments($request->order_id);
        $formattedPayments = [];
        $sum = 0;
        for ($i=0; $i < count($payments); $i++) {
            $formattedPayments[$i]["id"] = $payments[$i]["id"];
            $formattedPayments[$i]["amount"] = fa_number(number_format($payments[$i]["amount"]));
            $formattedPayments[$i]["created_at"] =
                fa_number(Jalalian::forge($payments[$i]["created_at"])->format('%Y/%m/%d'));
            $sum += $payments[$i]["amount"];
        }
        return response()->json([
            "result" => true,
            "payments" => $formattedPayments,
            "sum" => fa_number(number_format($sum))
        ]);
    }

    public function orderChecks(Request $request)
    {
        $sum = 0;
        $checks = Order::where("id", $request->order_id)
        ->first()
        ->checks;
        foreach($checks as $check) {
            $sum += str_replace(",", "", en_number($check["amount"]));
        }
        return response()->json([
            "result" => true,
            "checks" => $checks,
            "sum" => fa_number(number_format($sum))
        ]);
    }

    public function orderProducts(Request $request)
    {
        $products = Order::where("id", $request->order_id)
            ->first()->details()->with("product")->get();
        foreach ($products as $product) {
            $product['count'] = fa_number($product['count']);
            if ($product["delivery_time"]) {
                $product["delivery_time"] =
                    fa_number(Jalalian::forge($product["delivery_time"])->format('%Y/%m/%d'));
            }
        }
        return response()->json([
            "result" => true,
            "products" => $products
        ]);
    }

    public function updateDetails(Request $request)
    {
        $timestamp = null;
        $detailId = $request["details"][0][0];
        DB::beginTransaction();
        try{
            foreach($request['details'] as $detail) {
                if($detail[2]) {
                    $explodedDate = explode("/", en_number($detail[2]));
                    $timestamp = strtotime((new Jalalian($explodedDate[0], $explodedDate[1], $explodedDate[2]))
                    ->toCarbon()->toDateTimeString());
                }
                else { $timestamp = null; }

                $res = OrderDetail::where("id", $detail[0])->update([
                    "status" => $detail[1],
                    "delivery_time" => $timestamp
                ]);
            }
            $this->isAllDelivered($detailId);
            DB::commit();
            return response()->json(["result" => true]);
        }
        catch(Exception $e){
            Log::error($e->getMessage());
        }
    }

    public function isAllDelivered($detailId)
    {
        $order = OrderDetail::where("id", $detailId)
        ->first()->order()->first();
        $statusList = $order->details()->pluck("status")->toArray();
        if (! in_array(OrderDetail::STATUS_PENDING, $statusList)) {
            $order->status = Order::STATUS_FINALIZED;
            $order->save();
        }
    }

}

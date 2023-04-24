<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

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
        return view("product", compact('product'));
    }
}

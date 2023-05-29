<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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


}

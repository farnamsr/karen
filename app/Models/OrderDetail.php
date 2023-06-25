<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderDetail extends Model
{
    use HasFactory;

    const STATUS_PENDING = 1;
    const STATUS_FINALIZED = 2;
    public function getDateFormat(){
        return 'U';
    }

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];

    protected $fillable = [
        'color', "order_id", "count",
        'payable', "product_id", "unit_price",
        "status", "delivery_time","color_id"
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public static function mostSelled()
    {
        $res = DB::table("order_details")
            ->select("product_id", DB::raw("SUM(count) as total"))
            ->groupBy("product_id")
            ->orderByDesc("total")
            ->limit(3)
            ->pluck("product_id");
        $products = Product::whereIn("id",$res)->get();
        foreach($products as $product) {
            $image = $product->images()->first();
            $imageSrc = asset("storage/products/{$image->product_id}_{$image->id}_{$image->created_at}.{$image->ext}");
            $product["img_path"] = $imageSrc;
        }
        return $products;
    }

    public static function newest()
    {
        $products = Product::orderByDesc("id")->limit(3)->get();
        foreach($products as $product) {
            $image = $product->images()->first();
            $imageSrc = asset("storage/products/{$image->product_id}_{$image->id}_{$image->created_at}.{$image->ext}");
            $product["img_path"] = $imageSrc;
        }
        return $products;
    }
}

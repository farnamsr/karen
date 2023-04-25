<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    const WHOLE_SALE_DISC = 1;

    protected $fillable = [
        'name',
        'description',
        'phone_number',
        'wholesaleـdiscount',
        'price',
        "category_id"
    ];

    public function getDateFormat(){
        return 'U';
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public static function products($cats = [])
    {
        $cats = count($cats) > 0 ? $cats : Category::all()->pluck("id");
        $products = Product::whereIn("category_id", $cats)->simplePaginate(3);
        foreach($products as $product) {
            $image = $product->images()->first();
            $imageSrc = asset("storage/products/{$image->product_id}_{$image->id}_{$image->created_at}.{$image->ext}");
            $product["img_path"] = $imageSrc;
        }
        return $products;
    }
}

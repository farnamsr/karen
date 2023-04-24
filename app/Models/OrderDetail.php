<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    public function getDateFormat(){
        return 'U';
    }

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];

    protected $fillable = [
        'color', "order_id", "count",
        'payable', "product_id", "unit_price"
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

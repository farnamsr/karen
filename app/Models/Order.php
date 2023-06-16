<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Morilog\Jalali\Jalalian;


class Order extends Model
{
    use HasFactory;
    const STATUS_WAITING_USER = 1;
    const STATUS_MIN_PAIED = 2;
    const STATUS_DELIVERED = 3;

    public function getDateFormat(){
        return 'U';
    }

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];

    protected $fillable = [
        'user_id',
        'status',
        'invoice_number'
    ];


    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function checks()
    {
        return $this->hasMany(CheckDetail::class);
    }

    public static function invoice($orderId)
    {
        $order = Order::where("id", $orderId)
            ->where("status", self::STATUS_DELIVERED)
            ->with(["details.product", "user"])->first();
        $order->delivery_time = fa_number(Jalalian::forge($order["delivery_time"])->format('%Y/%m/%d'));
        return $order;
    }
}

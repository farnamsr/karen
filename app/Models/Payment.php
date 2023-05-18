<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    const STATUS_PAYED = 1;
    const STATUS_PENDING = 2;
    const TYPE_CASH = 1;
    const TYPE_CHECK = 2;

    public function getDateFormat(){
        return 'U';
    }

    protected $fillable = [
        'order_id',
        'amount',
        'type',
        'status'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public static function pay($amount, $type, $status, $orderId)
    {
        $payment = self::create([
            'order_id' => $orderId,
            'amount' => $amount,
            'type' => $type,
            'status' => $status
        ]);
        return $payment;
    }
}

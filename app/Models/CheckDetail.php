<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use \Morilog\Jalali\Jalalian;


class CheckDetail extends Model
{
    use HasFactory;

    protected $table = 'check_details';


    protected $fillable = [
        'order_id', "due_date",
        'status', "created_at",
        "amount", "updated_at", "tracking_code"
    ];

    const CHECK_STATUS_PENDING = 0;
    const CHECK_STATUS_PAYED = 1;
    const CHECK_STATUS_REJECTED = 2;

    public function getDateFormat(){
        return 'U';
    }

    protected function dueDate(): Attribute
    {
        return Attribute::make(
            get: function(string $value) {
                return fa_number(Jalalian::forge($value)->format('%Y/%m/%d'));
            },
        );
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: function(string $value) {
                return fa_number(Jalalian::forge($value)->format('%Y/%m/%d'));
            },
        );
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: function(string $value) {
                return fa_number(number_format($value));
            },
        );
    }

    protected function trackingCode(): Attribute
    {
        return Attribute::make(
            get: function(string $value) {
                return fa_number(number_format($value));
            },
        );
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

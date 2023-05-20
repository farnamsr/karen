<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

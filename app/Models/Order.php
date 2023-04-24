<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    const STATUS_WAITING_USER = 1;
    const STATUS_WAITING_ADMIN = 2;
    const STATUS_ACCEPTED = 3;
    const STATUS_REJECTED = 4;

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
    ];


    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}

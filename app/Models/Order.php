<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    const STATUS_WAITING_USER = 1;
    const STATUS_MIN_PAIED = 2;

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
}

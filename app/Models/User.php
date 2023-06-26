<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use \Morilog\Jalali\Jalalian;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const WHOLE_DISC_TRUE = 1;
    const WHOLE_DISC_FALSE = 0;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'phone_number',
        'hasWholeDisc'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getDateFormat(){
        return 'U';
    }

    public function address()
    {
        return $this->hasMany(Address::class);
    }
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function checks()
    {
        return $this->hasMany(CheckDetail::class);
    }
    public static function watingOrder($userId)
    {
        return Order::where("user_id", $userId)
            ->where("status", Order::STATUS_WAITING_USER)
            ->first();
    }
    public static function pendingOrders($userId)
    {
        return Order::where("user_id", $userId)
            ->where("status", Order::STATUS_MIN_PAIED)
            ->with(["details.color", "payments"])
            ->get();
    }

    public static function finalizedOrders($userId)
    {
        return Order::where("user_id", $userId)
            ->where("status", Order::STATUS_DELIVERED)
            ->with(["details", "payments"])
            ->get();
    }
    // delivered pendings: the orders with some delivered products and som pending products
    // public static function deliveredPendings($userId)
    // {
    //     $pendings = self::pendingOrders($userId);
    //     return $pendings->with(["details" => function($query) {
    //         $query->where("status", OrderDetail::STATUS_DELIVERED);
    //     }])->get();
    // }
    // public static function notDeliveredPendings($userId)
    // {
    //     $payable = 0;
    //     $pendings = self::pendingOrders($userId);
    //     return $pendings->with(["payments","details" => function($query) {
    //         $query->where("status", OrderDetail::STATUS_PENDING);
    //     }])->get();
    // }
    public static function watingSumToPay($watingOrder)
    {
        return $watingOrder->details()->sum("payable");
    }
    public static function minCashPayment($watingSumToPay)
    {
        return round(($watingSumToPay / 3), -3);
    }
    public static function debtDetails($userId)
    {
        $sumToPay = 0;
        $minCashPayment = 0;
        $payedAmount = 0;
        $debt = 0;
        $isMinCashPayed = false;
        $user = User::where("id", $userId)->first();
        $watingOrder = User::watingOrder($userId);

        $totalPayable = self::totalPayable($user);
        $totalPayed = self::totalPayed($user);

        if($watingOrder) {
            $sumToPay = self::watingSumToPay($watingOrder);
            $minCashPayment = self::minCashPayment($sumToPay);
            $payments = $watingOrder->payments;
            if($payments) {
                $payedAmount = $payments->sum("amount");
                if($payedAmount >= $minCashPayment) { $isMinCashPayed = true; }
            }
            $debt = $sumToPay - $payedAmount;
        }
        $details = [
            "sumToPay" => fa_number(number_format($sumToPay)),
             "minCashPayment" => fa_number(number_format($minCashPayment)),
             "debt" => fa_number(number_format($debt)),
             "isMinCashPayed" => $isMinCashPayed,
             "totalDebt" => fa_number(number_format($totalPayable - $totalPayed))
        ];
        return $details;
    }

    public static function orderDebt($orderId)
    {
        $order = Order::where("id", $orderId)->first();
        $payable = $order->details()->sum("payable");
        $payed = $order->payments()->sum("amount");
        $debt = $payable - $payed;
        return [
            "debt" => $debt,
            "payable" => $payable,
            "payed" => $payed
        ];
    }

    public static function totalPayable($user)
    {
        return $user->orders()->with("details")->get()->flatMap(function($order) {
                return $order->details;
            })->sum("payable");
    }

    public static function totalPayed($user)
    {
        return $user->orders()->with("payments")->get()
            ->flatMap(function($order) {
                return $order->payments;
            })->sum("amount");
    }

    public static function totalDebt($user)
    {
        return self::totalPayable($user) - self::totalPayed($user);
    }

    public static function orderCashPayments($orderId)
    {
        $records = Order::where("id", $orderId)
            ->first()
            ->payments()
            ->where("type", Payment::TYPE_CASH)
            ->get();
        return $records;
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: function(string $value) {
                return fa_number(Jalalian::forge($value)->format('%Y/%m/%d'));
            },
        );
    }
}

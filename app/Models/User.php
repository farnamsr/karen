<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'phone_number',
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
            ->where("status", Order::STATUS_MIN_PAIED);
    }
    public static function deliveredPendings($userId)
    {
        $pendings = self::pendingOrders($userId);
        return $pendings->whereHas("details", function($query) {
            $query->whereNotNull("delivery_time");
        })->get();
    }
    public static function notDeliveredPendings($userId)
    {
        $pendings = self::pendingOrders($userId);
        return $pendings->whereHas("details", function($query) {
            $query->whereNull("delivery_time");
        })->get();
    }
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

        $totalPayable = $user
            ->orders()->with("details")->get()
            ->flatMap(function($order) {
                return $order->details;
            })->sum("payable");
        $totalPayed = $user->orders()->with("payments")->get()
            ->flatMap(function($order) {
                return $order->payments;
            })->sum("amount");

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

}

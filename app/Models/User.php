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
    public static function debtDetails($userId)
    {
        $sumToPay = 0;
        $minCashPayment = 0;
        $payedAmount = 0;
        $debt = 0;
        $maxCheckPayment = 0;
        $isMinCashPayed = false;
        $watingOrder = User::watingOrder($userId);
        if($watingOrder) {
            $sumToPay = $watingOrder->details()->sum("payable");
            $minCashPayment = round(($sumToPay / 3), -3);
            $maxCheckPayment = $sumToPay - $minCashPayment;
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
             "maxCheckPayment" => fa_number(number_format($maxCheckPayment)),
             "debt" => fa_number(number_format($debt)),
             "isMinCashPayed" => $isMinCashPayed
        ];
        return $details;
    }
}

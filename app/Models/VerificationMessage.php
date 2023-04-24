<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'phone_number', "code", "type"
    ];
    const STATUS_UNUSED = 0;
    const STATUS_VERIFIED = 1;
    const TYPE_REG = 1;
    const TYPE_LOGIN = 2;

    public function getDateFormat(){
        return 'U';
    }
}

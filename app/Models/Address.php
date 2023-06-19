<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    const ADDRESS_ACTIVE = 1;
    const ADDRESS_INACTIVE = 0;
    protected $fillable = ["address", "selected", "user_id"];
    public function getDateFormat(){
        return 'U';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    public function getDateFormat(){
        return 'U';
    }

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];

    protected $fillable = ["product_id", "created_at", "ext"];

}

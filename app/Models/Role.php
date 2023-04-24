<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Role extends Model
{
    use HasFactory;

    const ROLE_ADMIN = 1;

    public function getDateFormat(){
        return 'U';
    }
    protected $fillable = [
        'name'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }


    public static function hasRole($user, $role)
    {
        return $user->roles()->get()->contains($role);
    }
    protected function assignRoleToUser($roleId, $userId)
    {

    }
}

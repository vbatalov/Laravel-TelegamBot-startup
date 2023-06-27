<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    /** Check User exist in DB */
    public function isExists($cid): bool
    {
        if (User::where("cid", $cid)->exists()) {
            return true;
        }
        return false;
    }


    /** Save User to DB */
    public function store($cid): bool
    {
        $user = new User();
        $user->cid = $cid;
        return $user->save();
    }
}

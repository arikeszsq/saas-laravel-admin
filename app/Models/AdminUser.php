<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminUser extends Model
{

    protected $table = 'admin_users';


    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->format('Y-m-d');
    }
}

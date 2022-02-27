<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserExcel extends Model
{

    protected $table = 'jf_user_excel';

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function author()
    {
        return $this->belongsTo(AdminUser::class, 'user_id');
    }
}

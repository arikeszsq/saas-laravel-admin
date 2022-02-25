<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{

    protected $table = 'jf_user';

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function area()
    {
        $this->hasMany(Area::class, 'id', 'id');
    }

    public function setIdCardPicAttribute($pictures)
    {
        if (is_array($pictures)) {
            $this->attributes['id_card_pic'] = json_encode($pictures);
        }
    }

    public function getIdCardPicAttribute($pictures)
    {
        return json_decode($pictures, true);
    }

    public function setCertPicAttribute($pictures)
    {
        if (is_array($pictures)) {
            $this->attributes['cert_pic'] = json_encode($pictures);
        }
    }

    public function getCertPicAttribute($pictures)
    {
        return json_decode($pictures, true);
    }

    public static function addLinkUrl()
    {
        $user = User::query()->orderBy('id', 'desc')
            ->limit(1)
            ->first();
        User::query()->where('id', $user->id)
            ->update(['link_url' => env('APP_URL') . 'id=' . $user->id]);
    }
}

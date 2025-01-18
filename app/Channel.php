<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = [
        'user_id',
        'channel_id',
        'name',
        'admin_full_name',
        'mobile_number',
        'email',
        'address',
        'city',
        'pin_code',
        'joining_date',
        'status'
    ];


    protected $appends = ['status_text'];

    public function getstatusTextAttribute()
    {
        return $this->status == 1 ? 'Active' : 'In Active';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

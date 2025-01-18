<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeadMaker extends Model
{
    protected $fillable = [
        'channel_id',
        'user_id',
        'lead_maker_id',
        'lead_generation_link',
        'name',
        'mobile_number',
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

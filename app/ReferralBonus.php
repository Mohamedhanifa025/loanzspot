<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferralBonus extends Model
{
    protected $table = 'referral_bonuses';

    protected $fillable = [
        'loan_id',
        'referrer_id',
        'level',
        'bonus_amount'
    ];

    public function loan()
    {
        return $this->belongsTo(ApplyLoan::class, 'loan_id', 'id');
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id', 'id');
    }
}

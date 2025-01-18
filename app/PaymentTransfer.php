<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentTransfer extends Model
{
    protected $fillable = [
        'lead_maker_id',
        'amount'
    ];

    public function leadMaker()
    {
        return $this->belongsTo(LeadMaker::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationItem extends Model
{
    use HasFactory;

    protected $fillable = ['id_profile', 'id_donation_proposal', 'name', 'quantity'];

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'id_profile');
    }

    public function donationProposal()
    {
        return $this->belongsTo(DonationProposal::class, 'id_donation_proposal');
    }

    public function shipment()
    {
        return $this->hasOne(Shipment::class, 'id_donation_item');
    }  
    
}

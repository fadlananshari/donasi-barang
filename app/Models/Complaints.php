<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaints extends Model
{
    use HasFactory;

    protected $fillable = ['id_donation_proposal', 'id_profile', 'reason', 'image', 'description'];

    public function profile() {
        return $this->belongsTo(Profile::class, 'id_profile');
    }
    
    public function proposal() {
        return $this->belongsTo(DonationProposal::class, 'id_donation_proposal');
    }
    
}

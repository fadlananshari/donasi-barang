<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalItem extends Model
{
    use HasFactory;

    protected $fillable = ['id_donation_proposal', 'name', 'quantity', 'detail'];

    public function proposal()
    {
        return $this->belongsTo(DonationProposal::class, 'id_donation_proposal');
    }
}

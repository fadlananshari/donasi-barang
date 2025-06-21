<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationProposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_profile',
        'id_donation_type',
        'title',
        'image_campaign',
        'image_letter',
        'letter_number',
        'story',
        'detail',
        'quantity',
        'address',
        'status',
    ];

    // Relasi ke user (Profile)
    public function user()
    {
        return $this->belongsTo(Profile::class, 'id_profile');
    }

    // Relasi ke jenis barang (ItemType)
    public function donationType()
    {
        return $this->belongsTo(DonationType::class, 'id_donation_type');
    }

    // Relasi ke daftar barang yang diajukan
    public function proposalItems()
    {
        return $this->hasMany(ProposalItem::class, 'id_donation_proposal');
    }
}

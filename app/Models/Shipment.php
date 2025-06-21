<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = ['id_donation_item', 'id_delivery_service', 'tracking_number'];

    public function donationItem()
    {
        return $this->belongsTo(DonationItem::class, 'id_donation_item');
    }

    public function deliveryService()
    {
        return $this->belongsTo(DeliveryService::class, 'id_delivery_service');
    }

}

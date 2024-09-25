<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name',
        'mobile_no',
        'address_type_id',
        'city',
        'higest_billing',
        'total',
    ];

    public function addressType()
    {
        return $this->belongsTo(AddressType::class);
    }

    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }
}

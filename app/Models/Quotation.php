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
        'panel_brand_id',
        'quality_preference_id',
    ];

    public function addressType()
    {
        return $this->belongsTo(AddressType::class);
    }
    public function pabelBrand()
    {
        return $this->belongsTo(PanelBrand::class,'panel_brand_id');
    }
    public function qualityPreference()
    {
        return $this->belongsTo(QualityPreference::class,'quality_preference_id');
    }

    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }
}

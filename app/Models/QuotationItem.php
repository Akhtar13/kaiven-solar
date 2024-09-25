<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'panel_brand_id',
        'quality_preference_id',
        'price_per_unit',
        'total_price',
        'quantity',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function panelBrand()
    {
        return $this->belongsTo(PanelBrand::class);
    }

    public function qualityPreference()
    {
        return $this->belongsTo(QualityPreference::class);
    }
}

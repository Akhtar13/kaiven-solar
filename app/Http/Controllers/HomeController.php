<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AddressType;
use App\Models\PanelBrand;
use App\Models\QualityPreference;
use Illuminate\Http\Request;


class HomeController extends Controller
{

    public function genrateQuotation()
    {
        $addressType = AddressType::whereNull('deleted_at')->get();
        $panelBrands = PanelBrand::whereNull('deleted_at')->get();
        $qualityPreferences = QualityPreference::whereNull('deleted_at')->get();
        return view('genrate-quotation', [
            'addressType' => $addressType,
            'panelBrands' => $panelBrands,
            'qualityPreferences' => $qualityPreferences
        ]);
    }
}

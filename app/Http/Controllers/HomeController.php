<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AddressType;
use App\Helpers\Helper;
use App\Models\Kwt;
use App\Models\PanelBrand;
use App\Models\QualityPreference;
use App\Models\Quotation;
use App\Models\QuotationItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mpdf\Mpdf;

class HomeController extends Controller
{

    public function genrateQuotation()
    {
        $addressType = AddressType::whereNull('deleted_at')->get();
        $panelBrands = PanelBrand::whereNull('deleted_at')->get();
        $qualityPreferences = QualityPreference::whereNull('deleted_at')->get();
        $kwts = Kwt::get();
        return view('genrate-quotation', [
            'addressType' => $addressType,
            'panelBrands' => $panelBrands,
            'kwts' => $kwts,
            'qualityPreferences' => $qualityPreferences
        ]);
    }

    public function storeQuotation(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'mobile_no' => 'required|digits:10',
            'city' => 'required',
            'otp' => 'required',
            'address_type' => 'required',
            'billing_year' => 'required',
            'panel_brand_id' => 'required',
            'quality_preference_id' =>'required',
            'expected_amount' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        if(!Session::get('otp')){
            return response()->json(['message' => 'Please Verify Mobile NO'], 422);
        }
        if((int)Session::get('otp') !== (int)$request->otp){
            return response()->json(['message' => 'Invalid OTP'], 422);
        }

        $quotation = Quotation::create([
            'user_name' => $request->input('name'),
            'mobile_no' => $request->input('mobile_no'),
            'address_type_id' => $request->input('address_type'),
            'quality_preference_id' => $request->input('quality_preference_id'),
            'panel_brand_id' => $request->input('panel_brand_id'),
            'city' => $request->input('city'),
            'higest_billing' => $request->input('billing_year'),
            'total' => $request->input('expected_amount'),
        ]);
        Session::put('qoutation_id', $quotation->id);

        return response()->json(['message' => 'Quotation successfully created'], 200);
    }

    public function generateQuotationPDF()
    {
        $quotation = Quotation::with('items.panelBrand', 'items.qualityPreference')->findOrFail(Session::get('qoutation_id'));

        $html = view('invoice',['quotation'=>$quotation])->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $fileName = 'quotation_invoice_' . $quotation->id . '.pdf';
        return $mpdf->Output($fileName, 'I');
    }
    
    public function sendOtp(Request $request) :JsonResponse {
        $otp = Helper::sendSMS($request->mobile_no);
        Session::put('otp',$otp);
        return response()->json(['message','OTP SEND SUCCESSFULLY']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AddressType;
use App\Helpers\Helper;
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
        return view('genrate-quotation', [
            'addressType' => $addressType,
            'panelBrands' => $panelBrands,
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
            'panel_brands' => 'required|array|min:1',
            'panel_brands.*' => 'integer|distinct',
            'quality_preference' => [
                'required',
                'array',
                function($attribute, $value, $fail) use ($request) {
                    if (count($value) !== count($request->panel_brands ?? [])) {
                        $fail('The quality preferences must match the number of panel brands selected.');
                    }
                }
            ],
            'quality_preference.*' => 'integer',
            'quantity' => [
                'required',
                'array',
                function($attribute, $value, $fail) use ($request) {
                    if (count($value) !== count($request->panel_brands ?? [])) {
                        $fail('The quantity values must match the number of panel brands selected.');
                    }
                }
            ],
            'quantity.*' => 'integer|min:1',
        ];

        $messages = [
            'quality_preference.size' => 'The quality preferences must match the number of panel brands selected.',
            'quantity.size' => 'The quantity values must match the number of panel brands selected.',
            'otp.requried' => 'Please Verify Mobile NO',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

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
            'city' => $request->input('city'),
            'higest_billing' => $request->input('billing_year'),
            'total' => 0,
        ]);
        $totalQuotationPrice = 0;

        foreach ($request->panel_brands as $index => $panelBrandId) {
            $panelBrand = PanelBrand::find($panelBrandId);
            $quantity = $request->quantity[$index];
            $qualityPreferenceId = $request->quality_preference[$panelBrandId];
            $unitPrice = $panelBrand->price;

            $totalPrice = $unitPrice * $quantity;
            $totalQuotationPrice += $totalPrice;
            QuotationItem::create([
                'quotation_id' => $quotation->id,
                'panel_brand_id' => $panelBrandId,
                'quality_preference_id' => $qualityPreferenceId,
                'price_per_unit' => $unitPrice,
                'total_price' => $totalPrice,
                'quantity' => $quantity,
            ]);
        }
        $quotation->update(['total' => $totalQuotationPrice]);
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

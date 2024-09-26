<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AdminDataTableBadgeHelper;
use App\Helpers\AdminDataTableButtonHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\JsonResponse;
use App\Models\Quotation;
use Mpdf\Mpdf;

class QuotationController extends Controller
{
    public function index()
    {
        return view('admin.quotation.index');
    }
    
    public function customer()
    {
        return view('admin.quotation.customer');
    }

    public function getDatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Quotation::with('addressType');
            return DataTables::of($data)
                ->addColumn('address_type_name', function ($row) {
                    return $row->addressType->name;
                })
                ->addColumn('action', function ($row) {
                    $array = [
                        'id' => $row->id,
                    ];
                    return AdminDataTableButtonHelper::detailButton($array).AdminDataTableButtonHelper::pdfButtton($array);
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function show($id)
    {
        $data = Quotation::find($id);
        $view = view('admin.quotation.show', ['quotation' => $data])->render();
        return response()->json(['model_title' => 'Quotation Details', 'data' => $view]);
    }

    public function downloadPdf($id)
    {
        $quotation = Quotation::with('items.panelBrand', 'items.qualityPreference')->findOrFail($id);

        $html = view('invoice',['quotation'=>$quotation])->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $fileName = 'quotation_invoice_' . $quotation->id . '.pdf';
        return $mpdf->Output($fileName, 'I');
    }
}

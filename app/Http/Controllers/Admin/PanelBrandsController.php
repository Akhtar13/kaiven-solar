<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\AdminDataTableButtonHelper;
use App\Http\Requests\Admin\PanelBrandsRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\PanelBrand;
use Illuminate\Support\Carbon;

class PanelBrandsController extends Controller
{
    public function index()
    {
        return view('admin.panel-brands.index');
    }

    public function getDatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = PanelBrand::select('panel_brands.id', 'panel_brands.name', 'panel_brands.desctiption', 'panel_brands.price')

                ->where('panel_brands.deleted_at', null);
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $array = [
                        'id' => $row->id,
                        'actions' => [
                            'edit' => route('admin.panel-brands.edit', [$row->id]),
                            'delete' => '',
                        ]
                    ];
                    return AdminDataTableButtonHelper::actionButtonDropdown2($array);
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('admin.panel-brands.create', []);
    }

    public function store(PanelBrandsRequest $request): JsonResponse
    {
        $details = $request->only(['name', 'desctiption', 'price']);
        if ((int)$request['edit_value'] === 0) {
            $model = new PanelBrand();
            foreach ($details as $key => $value) {
                $model->$key = $value;
            }
            $model->save();

            return response()->json([
                'success' => true,
                'message' => trans('messages.panel_brands_added_successfully')
            ]);
        }
        $model = PanelBrand::find($request['edit_value']);
        foreach ($details as $key => $value) {
            $model->$key = $value;
        }
        $model->save();

        return response()->json([
            'success' => true,
            'message' => trans('messages.panel_brands_updated_successfully')
        ]);
    }

    public function edit($id)
    {
        $model = PanelBrand::findOrFail($id);

        return view('admin.panel-brands.edit', [
            'panel_brands' => $model,

        ]);
    }

    public function destroy($id): JsonResponse
    {
        PanelBrand::where('id', $id)->update(['deleted_at' => Carbon::now()]);
        return response()->json(['message' => trans('messages.panel_brands_deleted_successfully')]);
    }
}

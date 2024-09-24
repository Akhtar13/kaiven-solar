<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\AdminDataTableButtonHelper;
use App\Http\Requests\Admin\QualityPreferencesRequest;
use App\Models\PanelBrand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\QualityPreference;
use Illuminate\Support\Carbon;

class QualityPreferencesController extends Controller
{
    public function index()
    {
        return view('admin.quality-preferences.index');
    }

    public function getDatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = QualityPreference::select('quality_preferences.id', 'panel_brands.name as panel_brand_id_name', 'quality_preferences.name', 'quality_preferences.description')
                ->leftJoin('panel_brands', 'quality_preferences.panel_brand_id', '=', 'panel_brands.id')
                ->where('quality_preferences.deleted_at', null);
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $array = [
                        'id' => $row->id,
                        'actions' => [
                            'edit' => route('admin.quality-preferences.edit', [$row->id]),
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
        $panel_brandss = PanelBrand::where('deleted_at', null)->get();
        return view('admin.quality-preferences.create', ['panel_brandss' => $panel_brandss]);
    }

    public function store(QualityPreferencesRequest $request): JsonResponse
    {
        $details = $request->only(['panel_brand_id', 'name', 'description']);
        if ((int)$request['edit_value'] === 0) {
            $model = new QualityPreference();
            foreach ($details as $key => $value) {
                $model->$key = $value;
            }
            $model->save();

            return response()->json([
                'success' => true,
                'message' => trans('messages.quality_preferences_added_successfully')
            ]);
        }
        $model = QualityPreference::find($request['edit_value']);
        foreach ($details as $key => $value) {
            $model->$key = $value;
        }
        $model->save();

        return response()->json([
            'success' => true,
            'message' => trans('messages.quality_preferences_updated_successfully')
        ]);
    }

    public function edit($id)
    {
        $model = QualityPreference::findOrFail($id);
        $panel_brandss = PanelBrand::where('deleted_at', null)->get();

        return view('admin.quality-preferences.edit', [
            'quality_preferences' => $model,
            'panel_brandss' => $panel_brandss
        ]);
    }

    public function destroy($id): JsonResponse
    {
        QualityPreference::where('id', $id)->update(['deleted_at' => Carbon::now()]);
        return response()->json(['message' => trans('messages.quality_preferences_deleted_successfully')]);
    }
}

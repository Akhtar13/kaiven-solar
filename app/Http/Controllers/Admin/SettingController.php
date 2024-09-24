<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AdminDataTableBadgeHelper;
use App\Helpers\AdminDataTableButtonHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingStoreRequest;
use App\Models\Event;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends Controller
{
    public  function index()
    {
        return view('admin.setting.index');
    }
    public  function create()
    {
        return view('admin.setting.create');
    }
    public function getDatatable(Request $request)
    {
        if ($request->ajax()) {
            $meta = Setting::all();

            return Datatables::of($meta)
                ->addColumn('action', function ($meta) {
                    $array = [
                        'id' => $meta->id,
                        'actions' => [
                            'edit' => route('admin.setting.edit', [$meta->id]),
//                            'delete' => '',
                        ],
                    ];

                    return AdminDataTableButtonHelper::actionButtonDropdown2($array);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

    }
    public function store(SettingStoreRequest $request): JsonResponse
    {

        if ((int) $request['edit_value'] === 0) {
            $meta = new Setting();
            $meta->meta_key = $request['meta_key'];
            $meta->meta_value = $request['meta_value'];
            $meta->save();

            return response()->json(['message' => trans('messages.setting_added_successfully')]);
        }

        $meta = Setting::find($request['edit_value']);
        $meta->meta_key = $request['meta_key'];
        $meta->meta_value = $request['meta_value'];
        $meta->save();

        return response()->json(['message' => trans('messages.setting_updated_successfully')]);
    }

    public function edit($id)
    {
        $meta = Setting::where('id', $id)->first();
        return view('admin.setting.edit', [
            'meta' => $meta,
        ]);
    }
}

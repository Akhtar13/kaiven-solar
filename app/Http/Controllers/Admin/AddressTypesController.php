<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\AdminDataTableButtonHelper;
use App\Http\Requests\Admin\AddressTypesRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\AddressType;
use Illuminate\Support\Carbon;

class AddressTypesController extends Controller
{
    public function index()
    {
        return view('admin.address-types.index');
    }

    public function getDatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = AddressType::select('address_types.id', 'address_types.name', 'address_types.description')

                ->where('address_types.deleted_at', null);
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $array = [
                        'id' => $row->id,
                        'actions' => [
                            'edit' => route('admin.address-types.edit', [$row->id]),
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


        return view('admin.address-types.create', []);
    }

    public function store(AddressTypesRequest $request): JsonResponse
    {
        $details = $request->only(['name', 'description']);
        if ((int)$request['edit_value'] === 0) {
            $model = new AddressType();
            foreach ($details as $key => $value) {
                $model->$key = $value;
            }
            $model->save();

            return response()->json([
                'success' => true,
                'message' => trans('messages.address_types_added_successfully')
            ]);
        }
        $model = AddressType::find($request['edit_value']);
        foreach ($details as $key => $value) {
            $model->$key = $value;
        }
        $model->save();

        return response()->json([
            'success' => true,
            'message' => trans('messages.address_types_updated_successfully')
        ]);
    }

    public function edit($id)
    {
        $model = AddressType::findOrFail($id);


        return view('admin.address-types.edit', [
            'address_types' => $model,

        ]);
    }

    public function destroy($id): JsonResponse
    {
        AddressType::where('id', $id)->update(['deleted_at' => Carbon::now()]);
        return response()->json(['message' => trans('messages.address_types_deleted_successfully')]);
    }
}

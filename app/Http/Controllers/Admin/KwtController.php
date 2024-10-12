<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\AdminDataTableButtonHelper;
use App\Http\Requests\Admin\KwtRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Kwt;
use Illuminate\Support\Carbon;

class KwtController extends Controller
{
    public function index()
    {
        return view('admin.kwt.index');
    }

    public function getDatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Kwt::select('kwt.id', 'kwt.from_kwt', 'kwt.to_kwt', 'kwt.description');
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $array = [
                        'id' => $row->id,
                        'actions' => [
                            'edit' => route('admin.kwt.edit', [$row->id]),
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
        return view('admin.kwt.create', []);
    }

    public function store(KwtRequest $request): JsonResponse
    {
        $details = $request->only(['from_kwt', 'to_kwt', 'description','suggestion_one','suggestion_two']);
        
        if ((int)$request['edit_value'] === 0) {
            $model = new Kwt();
            foreach ($details as $key => $value) {
                $model->$key = $value;
            }
            $model->save();

            return response()->json([
                'success' => true,
                'message' => trans('messages.kwt_added_successfully')
            ]);
        }
        $model = Kwt::find($request['edit_value']);
        foreach ($details as $key => $value) {
            $model->$key = $value;
        }
        $model->save();

        return response()->json([
            'success' => true,
            'message' => trans('messages.kwt_updated_successfully')
        ]);
    }

    public function edit($id)
    {
        $model = Kwt::findOrFail($id);
        return view('admin.kwt.edit', [
            'kwt' => $model,

        ]);
    }

    public function destroy($id): JsonResponse
    {
        Kwt::where('id', $id)->delete();
        return response()->json(['message' => trans('messages.kwt_deleted_successfully')]);
    }
}

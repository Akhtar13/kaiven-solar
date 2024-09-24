<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\AdminDataTableButtonHelper;
use App\Http\Requests\Admin\ProductsRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Product;
use Illuminate\Support\Carbon;

class ProductsController extends Controller
{
    public function index()
    {
        return view('admin.products.index');
    }

    public function getDatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::select('products.id', 'products.product_name', 'products.qty', 'products.price', 'products.gst', 'products.remark')->where('products.deleted_at', null);
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $array = [
                        'id' => $row->id,
                        'actions' => [
                            'edit' => route('admin.products.edit', [$row->id]),
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
        return view('admin.products.create', []);
    }

    public function store(ProductsRequest $request): JsonResponse
    {
        $details = $request->only(['product_name', 'qty', 'price', 'gst', 'remark']);
        if ((int)$request['edit_value'] === 0) {
            $model = new Product();
            foreach ($details as $key => $value) {
                $model->$key = $value;
            }
            $model->save();

            return response()->json([
                'success' => true,
                'message' => trans('messages.products_added_successfully')
            ]);
        }
        $model = Product::find($request['edit_value']);
        foreach ($details as $key => $value) {
            $model->$key = $value;
        }
        $model->save();

        return response()->json([
            'success' => true,
            'message' => trans('messages.products_updated_successfully')
        ]);
    }

    public function edit($id)
    {
        $model = Product::findOrFail($id);

        return view('admin.products.edit', [
            'products' => $model,

        ]);
    }

    public function destroy($id): JsonResponse
    {
        Product::where('id', $id)->update(['deleted_at' => Carbon::now()]);
        return response()->json(['message' => trans('messages.products_deleted_successfully')]);
    }
}

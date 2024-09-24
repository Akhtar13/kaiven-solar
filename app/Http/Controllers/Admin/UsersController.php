<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Helpers\AdminDataTableButtonHelper;
    use App\Http\Requests\Admin\UsersRequest;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Yajra\DataTables\Facades\DataTables;
    use App\Models\Users;
    use Illuminate\Support\Carbon;

    class UsersController extends Controller
    {
        public function index()
        {
            return view('admin.users.index');
        }

        public function getDatatable(Request $request)
        {
            if ($request->ajax()) {
                $data = Users::select('users.id', 'users.name', 'users.email', 'users.email_verified_at', 'users.password', 'users.user_type', 'users.status', 'users.remember_token')
                    
                    ->where('users.deleted_at', null);
                return DataTables::of($data)
                    ->addColumn('action', function ($row) {
                        $array = [
                            'id' => $row->id,
                            'actions' => [
                                'edit' => route('admin.users.edit', [$row->id]),
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
            
            $status_options = ['active', 'inActive'];

            return view('admin.users.create', ['status_options' => $status_options]);
        }

        public function store(UsersRequest $request): JsonResponse
        {
            $details = $request->only(['name', 'email', 'email_verified_at', 'password', 'user_type', 'status', 'remember_token']);
            if ((int)$request['edit_value'] === 0) {
                $model = new Users();
                foreach ($details as $key => $value) {
                    $model->$key = $value;
                }
                $model->save();

                return response()->json([
                    'success' => true, 'message' => trans('messages.users_added_successfully')
                ]);
            }
            $model = Users::find($request['edit_value']);
            foreach ($details as $key => $value) {
                $model->$key = $value;
            }
            $model->save();

            return response()->json([
                'success' => true, 'message' => trans('messages.users_updated_successfully')
            ]);
        }

        public function edit($id)
        {
            $model = Users::findOrFail($id);
            
            $status_options = ['active', 'inActive'];

            return view('admin.users.edit', [
                'users' => $model,
                'status_options' => $status_options
            ]);
        }

        public function destroy($id): JsonResponse
        {
            Users::where('id', $id)->update(['deleted_at' => Carbon::now()]);
            return response()->json(['message' => trans('messages.users_deleted_successfully')]);
        }}
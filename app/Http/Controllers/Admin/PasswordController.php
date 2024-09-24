<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangePasswordStoreRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function index()
    {
        return view('admin.auth.change-password');
    }

    public function updatePassword(ChangePasswordStoreRequest $request): JsonResponse
    {
        $id = Auth::guard('admin')->user()->id;
        $user = User::find($id);
        $current_password = $request->current_password;
        $new_password = $request->new_password;

        if (! Hash::check($current_password, $user->password)) {
            return response()->json(['message' => trans('messages.old_password_is_not_valid')], 422);
        }

        User::where('id', $id)->update([
            'password' => bcrypt($new_password),
        ]);

        return response()->json(['message' => trans('messages.password_updated_successfully')]);
    }
}

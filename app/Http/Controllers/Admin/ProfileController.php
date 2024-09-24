<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangeProfileRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;


class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.index');
    }

    public function updateProfile(ChangeProfileRequest $request): JsonResponse
    {
        $id = $request->input('edit_value');
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response()->json([
            'message' => trans('messages.profile_updated_successfully')
        ]);
    }
}

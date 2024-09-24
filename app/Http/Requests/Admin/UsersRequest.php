<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array (
  'name' => 'required',
  'email' => 'required',
  'password' => 'required',
  'user_type' => 'required',
  'status' => 'required',
);
    }
}
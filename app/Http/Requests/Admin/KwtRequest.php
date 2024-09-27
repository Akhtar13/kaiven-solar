<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class KwtRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array (
  'from_kwt' => 'required',
  'to_kwt' => 'required',
  'description' => 'required',
);
    }
}
<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class QualityPreferencesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array (
  'panel_brand_id' => 'required',
  'name' => 'required',
);
    }
}
<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array(
            'product_name' => 'required',
            'qty' => 'required',
            'price' => 'required',
        );
    }
}

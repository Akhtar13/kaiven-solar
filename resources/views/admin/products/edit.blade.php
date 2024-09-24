@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ trans('messages.products') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ trans('messages.products_edit') }}</h5>
                </div>

                <div class="card-body">
                    <form method="POST" data-parsley-validate="" id="addEditForm" role="form">
                        @csrf
                        <input type="hidden" id="edit_value" value="{{ $products->id }}" name="edit_value">

                        <div class="row">

                            <div class="col-lg-12 mb-3">
                                <label for="product_name"
                                    class="form-label required">{{ trans('messages.product_name') }}<span
                                        class="text-danger">*</span> </label>
                                <input type="text" class="form-control" id="product_name" name="product_name"
                                    value="{{ $products->product_name }}"
                                    placeholder="{{ trans('messages.product_name') }}"autofocus>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label for="qty" class="form-label required">{{ trans('messages.qty') }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="qty" name="qty"
                                    value="{{ $products->qty }}" placeholder="{{ trans('messages.qty') }}"autofocus>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label for="price" class="form-label required">{{ trans('messages.price') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control float" id="price" name="price"
                                    value="{{ $products->price }}" placeholder="{{ trans('messages.price') }}"autofocus>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label for="gst" class="form-label">{{ trans('messages.gst') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="gst" name="gst"
                                    value="{{ $products->gst }}" placeholder="{{ trans('messages.gst') }}"autofocus>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label for="remark" class="form-label">{{ trans('messages.remark') }}</label>
                                <textarea type="text" class="form-control" id="remark" name="remark"
                                    placeholder="{{ trans('messages.remark') }}">{{ $products->remark }}</textarea>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-success btn-sm">{{ trans('messages.save') }}</button>
                                <a href="{{ route('admin.products.index') }}"
                                    class="btn btn-danger btn-sm">{{ trans('messages.cancel') }}</a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('custom-script')
    <script>
        let form_url = '/products';
        let redirect_url = '/products';
    </script>
    <script src="{{ asset('assets/custom-js/custom/form.js') }}?v={{ time() }}"></script>
@endsection

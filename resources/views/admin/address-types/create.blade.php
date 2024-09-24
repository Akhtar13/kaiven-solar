@extends('admin.layouts.master')
    @section('title','Dashboard')
    @section('content')
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{trans('messages.address_types')}}</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{trans('messages.address_types_add')}}</h5>
                    </div>

                    <div class="card-body">
                        <form method="POST" data-parsley-validate="" id="addEditForm" role="form">
                            @csrf
                            <input type="hidden" id="edit_value" value="0" name="edit_value">

                            <div class="row">
                                
                                <div class="col-lg-12 mb-3">
                                    <label for="name" class="form-label required">{{trans('messages.name')}}</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="{{trans('messages.name')}}" autofocus>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <label for="description" class="form-label">{{trans('messages.description')}}</label>
                                    <textarea class="form-control" id="description" name="description" rows="4"
                                              placeholder="{{trans('messages.description')}}"></textarea>
                                </div>


                                <div class="text-end">
                                    <button type="submit" class="btn btn-success btn-sm">{{trans('messages.save')}}</button>
                                    <a href="{{ route('admin.address-types.index') }}"
                                    class="btn btn-danger btn-sm">{{trans('messages.cancel')}}</a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @endsection
    @section('custom-script')
        <script>
            let form_url = '/address-types';
            let redirect_url = '/address-types';
        </script>
        <script src="{{ asset('assets/custom-js/custom/form.js') }}?v={{time()}}"></script>
        <script>
        </script>
    @endsection
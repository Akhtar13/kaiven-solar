@extends('admin.layouts.master')
@section('title','Dashboard')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{trans('messages.settings')}}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{trans('messages.edit_setting')}}</h5>
                </div>

                <div class="card-body">
                    <form method="POST" data-parsley-validate="" id="addEditForm" role="form">
                        @csrf
                        <input type="hidden" id="edit_value" value="{{$meta->id}}" name="edit_value">

                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="meta_key" class="form-label">{{trans('messages.meta_key')}}</label>
                                <span class="text-danger">*</span>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="meta_key" name="meta_key"
                                       value="{{$meta->meta_key}}"
                                       placeholder="{{trans('messages.meta_key')}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="meta_value" class="form-label">{{trans('messages.meta_value')}}</label>
                                <span class="text-danger">*</span>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="meta_value" name="meta_value"
                                       value="{{$meta->meta_value}}"
                                       placeholder="{{trans('messages.meta_value')}}">
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success btn-sm">{{trans('messages.save')}}</button>
                            <a href="{{ route('admin.setting.index') }}" class="btn btn-danger btn-sm">{{trans('messages.cancel')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('custom-script')
    <script>
        let form_url = '/setting'
        let redirect_url = '/setting'
    </script>
    <script src="{{ asset('assets/custom-js/custom/form.js') }}"></script>
@endsection

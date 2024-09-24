@extends('admin.layouts.master')
@section('title','Setting')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{trans('messages.change_password')}}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title mb-0">{{trans('messages.change_password')}}</div>
                </div>
                <div class="card-body">
                    <form method="POST" data-parsley-validate="" id="addEditForm" role="form">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="current_password" class="form-label">{{trans('messages.current_password')}}
                                    <span
                                            class="text-danger">*</span></label>
                            </div>
                            <div class="col-lg-9">
                                <input type="password" class="form-control "
                                       name="current_password" id="current_password"
                                       placeholder="Current Password"
                                       required/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="new_password" class="form-label">{{trans('messages.new_password')}}<span
                                            class="text-danger">*</span></label>
                            </div>
                            <div class="col-lg-9">
                                <input type="password" class="form-control "
                                       name="new_password" id="new_password"
                                       placeholder="New Password"
                                       required/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="confirm_password" class="form-label">{{trans('messages.confirm_password')}}
                                    <span
                                            class="text-danger">*</span></label>
                            </div>
                            <div class="col-lg-9">
                                <input type="password" class="form-control "
                                       name="confirm_password" id="confirm_password"
                                       placeholder="Confirm Password"
                                       required/>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success btn-sm">{{trans('messages.save')}}</button>
                            <a href="{{ route('admin.dashboard') }}"
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
        var form_url = '/update-password'
        var redirect_url = '/change-password'
    </script>
    <script src="{{ asset('assets/custom-js/custom/form.js') }}"></script>
@endsection

@extends('admin.layouts.master')
@section('title','Profile')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{trans('messages.profile')}}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{trans('messages.update_profile')}}</h5>
                </div>
                <div class="card-body">
                    <form method="POST" data-parsley-validate="" id="addEditForm" role="form"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="edit_value" value="{{ Auth::guard('admin')->user()->id }}"
                               name="edit_value">
                        <input type="hidden" id="form-method" value="add">

                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="name" class="form-label">{{trans('messages.name')}}<span
                                            class="text-danger">*</span></label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control"
                                       name="name" id="name" value="{{ Auth::guard('admin')->user()->name }}"
                                       placeholder="Name" required/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="email" class="form-label">{{trans('messages.email')}}<span
                                            class="text-danger">*</span></label>
                            </div>
                            <div class="col-lg-9">
                                <input type="email" class="form-control bg-light"
                                       name="email" readonly id="email"
                                       value="{{ Auth::guard('admin')->user()->email }}"
                                       placeholder="Email" required  />
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success btn-sm">{{trans('messages.save')}}</button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-danger btn-sm">{{trans('messages.cancel')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom-script')
    <script>
        var form_url = '/updateProfile'
        var redirect_url = '/my-profile'
    </script>
    <script src="{{ asset('assets/custom-js/custom/form.js') }}"></script>
@endsection

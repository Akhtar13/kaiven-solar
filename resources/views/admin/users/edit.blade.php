@extends('admin.layouts.master')
    @section('title','Dashboard')
    @section('content')
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{trans('messages.users')}}</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{trans('messages.users_edit')}}</h5>
                    </div>

                    <div class="card-body">
                        <form method="POST" data-parsley-validate="" id="addEditForm" role="form">
                            @csrf
                            <input type="hidden" id="edit_value" value="{{ $users->id }}" name="edit_value">

                            <div class="row">
                                
                                <div class="col-lg-12 mb-3">
                                    <label for="name" class="form-label required">{{trans('messages.name')}}</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $users->name }}"
                                        placeholder="{{trans('messages.name')}}"autofocus>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <label for="email" class="form-label required">{{trans('messages.email')}}</label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        value="{{ $users->email }}"
                                        placeholder="{{trans('messages.email')}}"autofocus>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <label for="email_verified_at" class="form-label">{{trans('messages.email_verified_at')}}</label>
                                    <input type="text" class="form-control" id="email_verified_at" name="email_verified_at"
                                        value="{{ $users->email_verified_at }}"
                                        placeholder="{{trans('messages.email_verified_at')}}"autofocus>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <label for="password" class="form-label required">{{trans('messages.password')}}</label>
                                    <input type="text" class="form-control" id="password" name="password"
                                        value="{{ $users->password }}"
                                        placeholder="{{trans('messages.password')}}"autofocus>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <label for="user_type" class="form-label required">{{trans('messages.user_type')}}</label>
                                    <input type="text" class="form-control" id="user_type" name="user_type"
                                        value="{{ $users->user_type }}"
                                        placeholder="{{trans('messages.user_type')}}"autofocus>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <label for="status" class="form-label required">{{trans('messages.status')}}</label>
                                    <select class="form-select " data-choices name="status" id="status">
                                        <option value="">{{ trans('messages.select') }}</option>
                                        @foreach($status_options as $option)
                                            <option value="{{ $option }}" {{ $users->status == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <label for="remember_token" class="form-label">{{trans('messages.remember_token')}}</label>
                                    <input type="text" class="form-control" id="remember_token" name="remember_token"
                                        value="{{ $users->remember_token }}"
                                        placeholder="{{trans('messages.remember_token')}}"autofocus>
                                </div>


                                <div class="text-end">
                                    <button type="submit" class="btn btn-success btn-sm">{{trans('messages.save')}}</button>
                                    <a href="{{ route('admin.users.index') }}"
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
            let form_url = '/users';
            let redirect_url = '/users';
        </script>
        <script src="{{ asset('assets/custom-js/custom/form.js') }}?v={{time()}}"></script>
    @endsection
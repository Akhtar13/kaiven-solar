@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ trans('messages.kwt') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ trans('messages.kwt_edit') }}</h5>
                </div>

                <div class="card-body">
                    <form method="POST" data-parsley-validate="" id="addEditForm" role="form">
                        @csrf
                        <input type="hidden" id="edit_value" value="{{ $kwt->id }}" name="edit_value">

                        <div class="row">

                            <div class="col-lg-12 mb-3">
                                <label for="from_kwt" class="form-label required">{{ trans('messages.from_kwt') }}</label>
                                <input type="text" class="form-control" id="from_kwt" name="from_kwt"
                                    value="{{ $kwt->from_kwt }}" placeholder="{{ trans('messages.from_kwt') }}"autofocus>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label for="to_kwt" class="form-label required">{{ trans('messages.to_kwt') }}</label>
                                <input type="text" class="form-control" id="to_kwt" name="to_kwt"
                                    value="{{ $kwt->to_kwt }}" placeholder="{{ trans('messages.to_kwt') }}"autofocus>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label for="description"
                                    class="form-label required">{{ trans('messages.description') }}</label>
                                <textarea class="form-control" id="description" name="description" rows="4"
                                    placeholder="{{ trans('messages.description') }}">{{ $kwt->description }}</textarea>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label for="suggestion_one"
                                    class="form-label  required">{{ trans('messages.suggestion_one') }}</label>
                                <input type="text" class="form-control float " id="suggestion_one" name="suggestion_one"
                                    value="{{ $kwt->suggestion_one }}"
                                    placeholder="{{ trans('messages.suggestion_one') }}" autofocus>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label for="suggestion_two"
                                    class="form-label  required">{{ trans('messages.suggestion_two') }}</label>
                                <input type="text" class="form-control float " id="suggestion_two" name="suggestion_two"
                                    value="{{ $kwt->suggestion_two }}"
                                    placeholder="{{ trans('messages.suggestion_two') }}" autofocus>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-success btn-sm">{{ trans('messages.save') }}</button>
                                <a href="{{ route('admin.kwt.index') }}"
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
        let form_url = '/kwt';
        let redirect_url = '/kwt';
    </script>
    <script src="{{ asset('assets/custom-js/custom/form.js') }}?v={{ time() }}"></script>
@endsection

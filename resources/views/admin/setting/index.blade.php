@extends('admin.layouts.master')
@section('title','Dashboard')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{trans('messages.settings')}}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h5 class="card-title mb-0 flex-grow-1">{{trans('messages.setting_list')}}</h5>
                    <div class="flex-shrink-0">
                        <div class="form-check form-switch form-switch-right form-switch-md">
                            <a href="{{ route('admin.setting.create') }}"
                               class="btn btn-primary btn-sm">{{trans('messages.add_new')}}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered dt-responsive nowrap table-striped align-middle"
                           id="basic-1" style="width:100%">
                        <thead>
                        <tr>
                            <th>{{trans('messages.id')}}</th>
                            <th>{{trans('messages.meta_key')}}</th>
                            <th>{{trans('messages.meta_value')}}</th>
                            <th>{{trans('messages.action')}}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('custom-script')
    <script>
        let datatable_url = '/get-setting'
        let redirect_url = '/setting'
        let form_url = '/setting'
        const sweetalert_delete_title = '{{trans('messages.setting_delete_title')}}'
        const sweetalert_delete_text = '{{trans('messages.delete_text')}}'

        $.extend(true, $.fn.dataTable.defaults, {
            columns: [
                {data: 'id', name: 'id'},
                {data: 'meta_key', name: 'meta_key'},
                {data: 'meta_value', name: 'meta_value'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            order: [0, 'desc']
        })
    </script>
    <script src="{{ asset('assets/custom-js/custom/datatable.js') }}?v={{time()}}"></script>
@endsection

@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ trans('messages.qoutations') }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h5 class="card-title mb-0 flex-grow-1">{{ trans('messages.qoutationss_list') }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered dt-responsive nowrap table-striped align-middle" id="basic-1"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>{{ trans('messages.id') }}</th>
                                <th>{{ trans('messages.user_name') }}</th>
                                <th>{{ trans('messages.mobile_no') }}</th>
                                <th>{{ trans('messages.address_type') }}</th>
                                <th>{{ trans('messages.city') }}</th>
                                <th>{{ trans('messages.higest_billing') }}</th>
                                <th>{{ trans('messages.total') }}</th>
                                <th>{{ trans('messages.action') }}</th>
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
        let datatable_url = '/get-quotation'
        let form_url = '/quotation'
        let modal_url = '/quotation'
        let exportUrlInvoice = '/quotation-invoice'
        const sweetalert_delete_title = '{{ trans('messages.quotations_delete_title') }}'
        const sweetalert_delete_text = '{{ trans('messages.quotations_delete_text') }}'

        $.extend(true, $.fn.dataTable.defaults, {
            columns: [
                {data: 'id',name: 'quotations.id'},
                {data: 'user_name',name: 'quotations.user_name'},
                {data: 'mobile_no',name: 'quotations.mobile_no'},
                {data: 'address_type_name',name: 'addressType.name'},
                {data: 'city',name: 'qoutations.city'},
                {data: 'higest_billing',name: 'qoutations.higest_billing'},
                {data: 'total',name: 'qoutations.total'},
                {data: 'action',name: 'action',orderable: false,searchable: false},
            ],
            order: [0, 'desc']
        })
    </script>
    <script src="{{ asset('assets/custom-js/custom/datatable.js') }}?v={{ time() }}"></script>
@endsection

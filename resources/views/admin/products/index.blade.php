@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ trans('messages.productss') }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h5 class="card-title mb-0 flex-grow-1">{{ trans('messages.products_list') }}</h5>
                    <div class="flex-shrink-0">
                        <div class="form-check form-switch form-switch-right form-switch-md">
                            <a href="{{ route('admin.products.create') }}"
                                class="btn btn-primary btn-sm">{{ trans('messages.add_new') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered dt-responsive nowrap table-striped align-middle" id="basic-1"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>{{ trans('messages.id') }}</th>
                                <th>{{ trans('messages.product_name') }}</th>
                                <th>{{ trans('messages.qty') }}</th>
                                <th>{{ trans('messages.price') }}</th>
                                <th>{{ trans('messages.gst') }}</th>
                                <th>{{ trans('messages.remark') }}</th>
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
        let datatable_url = '/get-products'
        let redirect_url = '/products'
        let form_url = '/products'
        const sweetalert_delete_title = '{{ trans('messages.products_delete_title') }}'
        const sweetalert_delete_text = '{{ trans('messages.products_delete_text') }}'

        $.extend(true, $.fn.dataTable.defaults, {
            columns: [{
                    data: 'id',
                    name: 'products.id'
                },
                {
                    data: 'product_name',
                    name: 'products.product_name'
                },
                {
                    data: 'qty',
                    name: 'products.qty'
                },
                {
                    data: 'price',
                    name: 'products.price'
                },
                {
                    data: 'gst',
                    name: 'products.gst'
                },
                {
                    data: 'remark',
                    name: 'products.remark'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            order: [0, 'desc']
        })
    </script>
    <script src="{{ asset('assets/custom-js/custom/datatable.js') }}?v={{ time() }}"></script>
@endsection

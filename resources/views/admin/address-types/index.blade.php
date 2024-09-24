@extends('admin.layouts.master')
    @section('title','Dashboard')
    @section('content')
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{trans('messages.address_typess')}}</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h5 class="card-title mb-0 flex-grow-1">{{trans('messages.address_types_list')}}</h5>
                        <div class="flex-shrink-0">
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <a href="{{ route('admin.address-types.create') }}"
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
                                <th>{{trans('messages.name')}}</th>
<th>{{trans('messages.description')}}</th>

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
            let datatable_url = '/get-address-types'
            let redirect_url = '/address-types'
            let form_url = '/address-types'
            const sweetalert_delete_title = '{{trans('messages.address_types_delete_title')}}'
            const sweetalert_delete_text = '{{trans('messages.address_types_delete_text')}}'

            $.extend(true, $.fn.dataTable.defaults, {
                columns: [
                    {data: 'id', name: 'address_types.id'},
                    {data: 'name', name: 'address_types.name'},
{data: 'description', name: 'address_types.description'},

                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                order: [0, 'desc']
            })
        </script>
        <script src="{{ asset('assets/custom-js/custom/datatable.js') }}?v={{time()}}"></script>
    @endsection
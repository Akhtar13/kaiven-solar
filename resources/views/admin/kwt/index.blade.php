@extends('admin.layouts.master')
    @section('title','Dashboard')
    @section('content')
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{trans('messages.kwts')}}</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h5 class="card-title mb-0 flex-grow-1">{{trans('messages.kwt_list')}}</h5>
                        <div class="flex-shrink-0">
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <a href="{{ route('admin.kwt.create') }}"
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
                                <th>{{trans('messages.from_kwt')}}</th>
<th>{{trans('messages.to_kwt')}}</th>
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
            let datatable_url = '/get-kwt'
            let redirect_url = '/kwt'
            let form_url = '/kwt'
            const sweetalert_delete_title = '{{trans('messages.kwt_delete_title')}}'
            const sweetalert_delete_text = '{{trans('messages.kwt_delete_text')}}'

            $.extend(true, $.fn.dataTable.defaults, {
                columns: [
                    {data: 'id', name: 'kwt.id'},
                    {data: 'from_kwt', name: 'kwt.from_kwt'},
{data: 'to_kwt', name: 'kwt.to_kwt'},
{data: 'description', name: 'kwt.description'},

                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                order: [0, 'desc']
            })
        </script>
        <script src="{{ asset('assets/custom-js/custom/datatable.js') }}?v={{time()}}"></script>
    @endsection
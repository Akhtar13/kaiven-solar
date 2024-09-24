@extends('admin.layouts.master')
    @section('title','Dashboard')
    @section('content')
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{trans('messages.userss')}}</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h5 class="card-title mb-0 flex-grow-1">{{trans('messages.users_list')}}</h5>
                        <div class="flex-shrink-0">
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <a href="{{ route('admin.users.create') }}"
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
<th>{{trans('messages.email')}}</th>
<th>{{trans('messages.email_verified_at')}}</th>
<th>{{trans('messages.password')}}</th>
<th>{{trans('messages.user_type')}}</th>
<th>{{trans('messages.status')}}</th>
<th>{{trans('messages.remember_token')}}</th>

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
            let datatable_url = '/get-users'
            let redirect_url = '/users'
            let form_url = '/users'
            const sweetalert_delete_title = '{{trans('messages.users_delete_title')}}'
            const sweetalert_delete_text = '{{trans('messages.users_delete_text')}}'

            $.extend(true, $.fn.dataTable.defaults, {
                columns: [
                    {data: 'id', name: 'users.id'},
                    {data: 'name', name: 'users.name'},
{data: 'email', name: 'users.email'},
{data: 'email_verified_at', name: 'users.email_verified_at'},
{data: 'password', name: 'users.password'},
{data: 'user_type', name: 'users.user_type'},
{data: 'status', name: 'users.status'},
{data: 'remember_token', name: 'users.remember_token'},

                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                order: [0, 'desc']
            })
        </script>
        <script src="{{ asset('assets/custom-js/custom/datatable.js') }}?v={{time()}}"></script>
    @endsection
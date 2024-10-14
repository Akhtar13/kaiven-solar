<table class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
    <thead>
        <tr>
            <th colspan="2" class="text-center">Quotation Detail</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>{{ trans('messages.user_name') }}</th>
            <td>{{ $quotation->user_name }}</td>
        </tr>
        <tr>
            <th>{{ trans('messages.mobile_no') }}</th>
            <td>{{ $quotation->mobile_no }}</td>
        </tr>
        <tr>
            <th>{{ trans('messages.address_type') }}</th>
            <td>{{ $quotation->addressType->name }}</td>
        </tr>
        <tr>
            <th>{{ trans('messages.city') }}</th>
            <td>{{ $quotation->city }}</td>
        </tr>
        <tr>
            <th>{{ trans('messages.higest_billing') }}</th>
            <td>{{ $quotation->higest_billing }}</td>
        </tr>
        <tr>
            <th>Panel Brand</th>
            <td>{{ $quotation->pabelBrand->name }}</td>
        </tr>
        <tr>
            <th>Quality Preference</th>
            <td>{{ $quotation->qualityPreference->name }}</td>
        </tr>
        <tr>
            <th>Expected Amount</th>
            <td>{{ $quotation->total }}</td>
        </tr>
    </tbody>
</table>

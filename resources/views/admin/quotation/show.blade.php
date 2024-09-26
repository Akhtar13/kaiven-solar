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
    </tbody>
</table>

<table class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
    <thead>
        <tr>
            <th colspan="5" class="text-center">Quotation Items</th>
        </tr>
        <tr>
            <th>{{ trans('messages.panel_brand') }}</th>
            <th>{{ trans('messages.quality_preference') }}</th>
            <th>{{ trans('messages.price_per_unit') }}</th>
            <th>{{ trans('messages.quantity') }}</th>
            <th>{{ trans('messages.price') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($quotation->items as $item)
        <tr>
            <td>{{ $item->panelBrand->name }}</td>
            <td>{{ $item->qualityPreference->name }}</td>
            <td>{{ $item->price_per_unit }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->total_price }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="4" class="text-end">{{ trans('messages.total') }}</td>
            <td>{{ $quotation->total }}</td>
        </tr>
    </tbody>
</table>

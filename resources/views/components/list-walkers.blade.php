<table class="table table-items">
    <thead>
    <tr>
        <th scope="col" class="border-0 pl-0">{{__('invoices::messages.last_name')}}</th>
        <th scope="col" class="text-center border-0">{{__('invoices::messages.tshirt_size.label')}}</th>
        <th scope="col" class="text-right border-0">{{__('invoices::messages.invoice.price')}}</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="pl-0">
            {{ $walker->name() }}
        </td>
        <td class="text-center">
            {{ $walker->tshirt_size->value }}
        </td>
        <td class="text-right">
            {{ $walker->amountInWords() }}
        </td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    {{-- Summary --}}
    <tr>
        <td></td>
        <td class="text-right pl-0">{{ __('invoices::messages.invoice.payment.total.label') }}</td>
        <td class="text-right pr-0 total-amount">
            {{ $amount }}
        </td>
    </tr>
    </tbody>
</table>

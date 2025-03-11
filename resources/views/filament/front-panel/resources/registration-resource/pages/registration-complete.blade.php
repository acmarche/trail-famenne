<x-filament-panels::page>

    <div class="flex flex-col md:flex-row gap-2 w-full items-center justify-items-center">
        <img src="{{asset('images/manwithbeer.png')}}"
             width="250" alt="scan"/>
        <div class="flex-1 flex-col gap-3">
            <x-alert type="success">
                {{__('invoices::messages.invoice.payment.finish.congratulate')}}
            </x-alert>
            @if($record->isPaid())
                <x-alert type="success">
                    {{__('invoices::messages.email.invoice.paid.body')}}
                </x-alert>
            @else
                <x-alert type="danger">
                    {{__('invoices::messages.form.registration.notification.finish.body')}}
                </x-alert>
            @endif
        </div>
    </div>

    <h3 class="text-2xl font-semibold walker-secondary my-2">
        {{__('invoices::messages.walkers.list')}}
    </h3>

    <x-list-walkers :walkers="$record->walkers" :amount="$record->totalAmountInWords()"/>

    @if(!$record->isPaid())
        <h3 class="text-2xl font-semibold walker-secondary my-2">
            {{__('invoices::messages.invoice.payment.title')}}
        </h3>

        <x-payment-information :amount="$record->totalAmountInWords()" :communication="$record->communication()"/>

        @include('invoices::pdf.qrcode')
    @endif
</x-filament-panels::page>

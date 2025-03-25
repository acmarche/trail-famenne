<x-mail::message>

    @if(isset($logo))
        <img src="{{$message->embed($logo)}}" alt="logo" height="100" style="float: left;">
    @else
        <p>Image not found.</p>
    @endif

    # {{ config('app.name') }}

    ## Thanks for your paid {{$walker->first_name}} {{$walker->last_name}} :joy:

    <x-mail::panel style="margin-top: 20px;margin-bottom: 20px;">
        <p style="color: #26e854;font-weight: bold;">
            ## {{__('invoices::messages.email.invoice.paid.body')}} :-)
        </p>
    </x-mail::panel>

    ## {{__('invoices::messages.walkers')}}

    <x-mail::table>
        | ##{{__('invoices::messages.last_name')}} | ## {{__('invoices::messages.tshirt_size')}} |
        ## {{__('invoices::messages.invoice.price')}} |
        | -------- | -------- | -------|
        | {{$walker->name()}} | {{$walker->tshirt_size}} | {{$walker->amountInWords()}} |
    </x-mail::table>
    ---

    <x-mail::button :url="$url" color="success">
        {{$textbtn}}
    </x-mail::button>

    [Site web des Marcheurs de la Famenne](https://marcheursdelafamenne.marche.be/)

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>

<x-mail::message>

@if(isset($logo))
<img src="{{$message->embed($logo)}}" alt="logo" height="100" style="float: left;">
@else
<p>Image not found.</p>
@endif

# {{ config('app.name') }}

## Welcome {{$walker->first_name}} {{$walker->last_name}} :joy:

<x-mail::panel style="margin-top: 20px;margin-bottom: 20px;">
<p style="color: #9f1239;font-weight: bold;">
## {{__('invoices::messages.form.registration.notification.finish.body')}}
</p>
</x-mail::panel>

## {{__('invoices::messages.walkers')}}

<x-mail::table>
| ##{{__('invoices::messages.last_name')}}  | ## {{__('invoices::messages.tshirt_size.label')}}  | ## {{__('invoices::messages.invoice.price')}}  |
| -------- | -------- | -------|
| {{$walker->name()}} | {{$walker->tshirt_size}} | {{$walker->amountInWords()}} |
</x-mail::table>
---

## {{__('invoices::messages.invoice.payment.title')}}

<x-payment-information :amount="$walker->amountInWords()" :communication="$walker->communication()" :markdown="true"/>

@if(isset($qrCode))
<img src="{{$message->embed($qrCode)}}" alt="qrcode" height="150">
@else
<p>Image not found.</p>
@endif

<x-mail::button :url="$url" color="success">
    {{$textbtn}}
</x-mail::button>

[Site web des Marcheurs de la Famenne](https://marcheursdelafamenne.marche.be/)

<x-mail::subcopy>
    Ma subcopy
</x-mail::subcopy>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

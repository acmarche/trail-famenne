<x-filament-panels::page>
    <div class="mx-5 bg-white shadow-lg rounded-lg p-4">
        <div class="flex flex-row items-center justify-center">
            <img src="{{asset('images/logoMarcheur.jpg')}}" alt="logo marcheur" class="w-56 ml-8">
            <h1 class="text-3xl font-bold walker-primary text-center">
                {{__('invoices::messages.page.rgpd.title')}}
            </h1>
        </div>

        <p>
            <a href="https://www.marche.be/administration/rgpd/">Vous pouvez consulter nos mentions légales et RGPD</a>
        </p>

    </div>
</x-filament-panels::page>

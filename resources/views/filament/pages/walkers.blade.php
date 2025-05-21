<x-filament-panels::page>
    <div class="mx-5 bg-white shadow-lg rounded-lg p-4">
        <div class="flex flex-col md:flex-row items-center justify-center">
            <img src="{{asset('images/logoMarcheur.jpg')}}" alt="logo marcheur" class="w-56 ml-8">
            <h1 class="text-3xl font-bold walker-primary text-center">
                {{$count}} {{__('invoices::messages.page.walkers.title')}}
            </h1>
        </div>

        {{ $this->table }}
    </div>
</x-filament-panels::page>

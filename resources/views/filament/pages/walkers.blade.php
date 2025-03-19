<x-filament-panels::page>
    <div class="mx-5 bg-white shadow-lg rounded-lg p-4">
        <div class="flex flex-row items-center justify-center">

            <h1 class="text-3xl font-bold walker-primary text-center">{{__('invoices::messages.page.walkers.title')}}</h1>
        </div>


        {{$this->table}}
    </div>
</x-filament-panels::page>

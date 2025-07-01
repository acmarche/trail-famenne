<x-filament-panels::page>
    <div class="mx-5 bg-white shadow-lg rounded-lg p-4">
        <x-filament::section class="my-2">
            <div class="flex flex-row items-center justify-center">
                <h1 class="text-3xl font-bold text-pink-500 text-center">Contacter les marcheurs</h1>
            </div>

            <x-filament::section.heading class="my-2">
                <p>Utilisez le formulaire pour envoyer un message aux marcheurs</p>
            </x-filament::section.heading>

            <x-filament::section.description>

            </x-filament::section.description>
        </x-filament::section>

        {{ $this->form }}

    </div>
</x-filament-panels::page>

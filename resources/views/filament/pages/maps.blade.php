<x-filament-panels::page>
    <div class="mx-5 bg-white shadow-lg rounded-lg p-4 min-h-screen">
        <div class="flex flex-row items-center justify-center mb-4">
            <h1 class="text-3xl font-bold walker-primary text-center">
                {{__('invoices::messages.page.maps.title')}}
            </h1>
        </div>

        <x-alert type="success">
            <p>Cliquez sur l'icône à gauche de "Parcours Marche Famenne-Ardenne" pour choisir votre parcours</p>
        </x-alert>

        <div class="google-maps mt-5">

            <iframe
                src="https://www.google.com/maps/d/embed?key=AIzaSyBM-Q3Oy5AIkWMJQ57_KW2bow7esooJUTg&mid=1my4UVisjYQvotTYwzGW5ShtxZiiIWg0&ehbc=2E312F&noprof=1"
                width="100%"
                loading="lazy"
                allowfullscreen
                height="680" border="0"
                style="border:0"></iframe>

        </div>
    </div>
</x-filament-panels::page>

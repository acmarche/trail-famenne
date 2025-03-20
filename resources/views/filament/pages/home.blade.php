<x-filament-panels::page>
    <section class="px-2 lg:px-12 flex mx-auto flex-col gap-3 items-start justify-items-center w-full lg:w-auto">

        <h2 class="flex flex-col md:flex-row items-center justify-items-center text-2xl lg:text-5xl font-semibold text-pink-500 mx-auto">
            <span>Marche Famenne - </span><span> Ardenne - 100Km</span>
        </h2>

        @include('filament.pages.parts._banner_images')

        <div class="px-4 lg:px-12 flex mx-auto flex-col space-y-6 items-start justify-items-center">
            <a href="{{route('information',['locale'=>'fr'])}}" class="flex flex-row items-center gap-4 underline">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 40" width="60" height="40">
                    <rect width="20" height="40" fill="blue"/>
                    <rect x="20" width="20" height="40" fill="white"/>
                    <rect x="40" width="20" height="40" fill="red"/>
                </svg>
                Bienvenue au 100 km Famenne Ardenne
            </a>

            <a href="{{route('information',['locale'=>'nl'])}}" class="flex flex-row items-center gap-4 underline">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 40" width="60" height="40">
                    <rect width="60" height="40" fill="red"/>
                    <rect y="13.33" width="60" height="13.33" fill="white"/>
                    <rect y="26.66" width="60" height="13.33" fill="blue"/>
                </svg>
                Welkom bij de 100 km Famenne Ardenne
            </a>

            <a href="{{route('information',['locale'=>'en'])}}" class="flex flex-row items-center gap-4 underline">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 40" width="60" height="40">
                    <rect width="60" height="40" fill="white"/>
                    <rect x="25" width="10" height="40" fill="red"/>
                    <rect y="15" width="60" height="10" fill="red"/>
                </svg>
                Welcome to the 100 km Famenne Ardenne
            </a>

            <a href="{{route('information',['locale'=>'de'])}}" class="flex flex-row items-center gap-4 underline">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 40" width="60" height="40">
                    <rect width="60" height="13.33" fill="black"/>
                    <rect y="13.33" width="60" height="13.33" fill="red"/>
                    <rect y="26.66" width="60" height="13.33" fill="gold"/>
                </svg>
                Willkommen bei den 100 km Famenne Ardenne
            </a>

        </div>
    </section>
</x-filament-panels::page>

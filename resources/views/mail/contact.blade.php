<x-mail::message>

    @if(isset($logo))
        <img src="{{$message->embed($logo)}}" alt="logo" height="100" style="float: left;">
    @else
        <p>Image not found.</p>
    @endif

    {{$content}}

    <x-mail::button :url="$url" color="success">
        Website
    </x-mail::button>

    [Site web des Marcheurs de la Famenne](https://marcheursdelafamenne.marche.be/)

</x-mail::message>

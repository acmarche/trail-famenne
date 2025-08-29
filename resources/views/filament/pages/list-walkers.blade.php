<div class="container mx-auto m-6">
    <h1 class="text-3xl font-bold mb-6">Liste des marcheurs</h1>

    <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-full table-auto">
            <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase leading-normal">
                <th class="py-3 px-6 text-left">Nom</th>
                <th class="py-3 px-6 text-left">Prénom</th>
                <th class="py-3 px-6 text-center">Numéro de T-shirt</th>
                <th class="py-3 px-6 text-left">Ville</th>
            </tr>
            </thead>
            <tbody class="text-gray-600 text-lg font-light">
            @foreach($this->walkers as $walker)
                <tr class="border-b border-gray-400 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap uppercase">{{ $walker->last_name }}</td>
                    <td class="py-3 px-6 text-left">{{ $walker->first_name }}</td>
                    <td class="py-3 px-6 text-center">{{ $walker->tshirt_number }}</td>
                    <td class="py-3 px-6 text-left">{{ $walker->city }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

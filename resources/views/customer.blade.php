<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Nos clients") }}
        </h2>
    </x-slot>

    @if(true)
        <div class="py-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="mb-3  text-xl"><b>{{ __("Les clients enregistrés") }}</b></h3>

                        <div>
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $customer = \App\Models\Customer::all(); @endphp
                                @for($i = 0; $i < count($customer); $i++)
                                    <tr>
                                        <th scope="row">{{$customer[$i]->id}}</th>
                                        <td>{{$customer[$i]->name}}</td>
                                        <td>{{$customer[$i]->phoneNumber}}</td>
                                        <td>{{$customer[$i]->email}}</td>
                                        <td>{{\App\Models\Location::findOrFail($customer[$i]->locationId)->town}}</td>
                                        <td>{{"Aucune"}}</td>
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</x-app-layout>

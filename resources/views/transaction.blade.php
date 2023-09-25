<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Gestion du commerce") }}
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl"><b>{{ __("") }}</b></h3>
                </div>
            </div>
        </div>
    </div>

    @if(true)
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="mb-3  text-xl"><b>{{ __("Les produits enregistrés") }}</b></h3>

                        <div>
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Produit</th>
                                    <th scope="col">Client</th>
                                    <th scope="col">Quantités</th>
                                    <th scope="col">Prix</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $transactions = \App\Models\Transaction::all(); @endphp
                                @for($i = 0; $i < count($transactions); $i++)
                                    <tr>
                                        <th scope="row">{{$transactions[$i]->id}}</th>
                                        <td>{{\App\Models\Product::findOrFail($transactions[$i]->productId)->name}}</td>
                                        <td>{{\App\Models\Customer::findOrFail($transactions[$i]->customerId)->name}}</td>
                                        <td>{{$transactions[$i]->quantity}}</td>
                                        <td>{{$transactions[$i]->amount}}</td>
                                        <td>{{$transactions[$i]->purchaseDate}}</td>
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

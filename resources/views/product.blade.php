<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __("Tableau de gestion des produits") }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl"><b>{{ __("Les produits enregistrés") }}</b></h3>
                </div>
            </div>
        </div>
    </div>

    @if(true)
        <div class="py-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="mb-3  text-xl"><b>{{ __("Les produits enregistrés") }}</b></h3>

                        <div>
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Non du produit</th>
                                    <th scope="col">Prix d'achat</th>
                                    <th scope="col">Prix de vente</th>
                                    <th scope="col">Stock</th>
                                    <th scope="col">Seuil</th>
                                    <th scope="col">Ajouter par</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $products = \App\Models\Product::all(); @endphp
                                @for($i = 0; $i < count($products); $i++)
                                    <tr>
                                        <th scope="row">{{$products[$i]->id}}</th>
                                        <td>{{$products[$i]->name}}</td>
                                        <td>{{$products[$i]->purchasePrice}}</td>
                                        <td>{{$products[$i]->salePrice}}</td>
                                        <td>{{$products[$i]->stock}}</td>
                                        <td>{{$products[$i]->threshold}}</td>
                                        <td>{{\App\Models\User::findOrFail($products[$i]->employeeId)->name}}</td>
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

<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Tableau d'administration") }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in! ") }}
                </div>
            </div>
        </div>
    </div>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl"><b>{{ __("Les produits enregistrés") }}</b></h3>
                    <br>
                    <p>Le nombre des produits : -- </p>
                    <p>Les produits en rupture des stocks : -- </p>
                    <p>Les produits bientôt en rupture  : -- </p>
                    <div> </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl"><b>{{ __("Les clients enregistrés") }}</b></h3>
                    <br>
                    <p>Le client du mois : -- </p>
                    <p>Le nombre des clients : -- </p>
                    <p>Le nombre des clients mois ({{date('m/Y', time())}}) : -- </p>
                    <p>Le nombre des cartes fidélité : -- </p>
                    <p>Les produits bientôt en rupture  : -- </p>
                    <div> </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

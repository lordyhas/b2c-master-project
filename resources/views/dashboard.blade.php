<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Tableau d'administration") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>


    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="mb-3 text-xl"><b>{{ __("Les utilisateurs enregistrés") }}</b></h3>
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Reg. Number</th>
                            <th scope="col">Email</th>
                            <th scope="col">Contact</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $users = \App\Models\User::all(); @endphp
                        @for($i = 0; $i < count($users); $i++)
                            <tr>
                                <th scope="row">{{$i+1}}</th>
                                <td>{{$users[$i]->name}}</td>
                                <td>{{$users[$i]->reg_no}}</td>
                                <td>{{$users[$i]->email}}</td>
                                <td>{{$users[$i]->phone}}</td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



</x-app-layout>

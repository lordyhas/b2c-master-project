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

    @php
        function hidemail(string $email): string{
            $pattern = '/(?<=.).(?=.*@)/'; // L'expression régulière qui correspond aux caractères à remplacer
            $replacement = '*'; // Le caractère de remplacement
            // L'email protégé
            return preg_replace($pattern, $replacement, $email); // Affiche h*****@mail.com
        }
    @endphp


    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="mb-3 text-xl"><b>{{ __("Les utilisateurs enregistrés") }}</b></h3>
                    <table class="table mb-6">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Reg. Number</th>
                            <th scope="col">Email</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Actions</th>
                            @if(Auth::user()->access == 1)
                                <th scope="col">Authorisation</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @php $users = \App\Models\User::all(); @endphp
                        @for($i = 0; $i < count($users); $i++)
                            <tr>
                                <th scope="row">{{$i+1}}</th>
                                <td>{{$users[$i]->name}}</td>
                                <td>{{$users[$i]->reg_no}}</td>
                                <td>
                                    @if(Auth::user()->access != -1)
                                        {{$users[$i]->email}}

                                    @else
                                        {{hidemail($users[$i]->email)}}
                                    @endif
                                </td>
                                <td>
                                    @if(Auth::user()->access != -1)
                                        {{$users[$i]->phone}}
                                    @else
                                        {{"+243********".substr($users[$i]->phone,-1,1)}}
                                    @endif
                                </td>
                                <td>
                                    @if(Auth::user()->isSuperUser())
                                        <x-danger-button>
                                            {{ __('Bloquer') }}
                                        </x-danger-button>
                                    @else
                                        {{ __('Aucune') }}
                                    @endif

                                </td>
                                @if(Auth::user()->isSuperUser())
                                    @if(Auth::user()->id == $users[$i]->id)
                                        @if(Auth::user()->isAdmin())
                                            <td>{{__('Vous (Admin)')}}</td>
                                        @else
                                            <td>{{__('Vous')}}</td>
                                        @endif
                                    @else
                                        <td>
                                            <x-dropdown align="right">
                                                <x-slot name="trigger">
                                                    <button
                                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                        <div>{{"Accés niveau ".$users[$i]->access}}</div>

                                                        <div class="ml-1">
                                                            <svg class="fill-current h-4 w-4"
                                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                      clip-rule="evenodd"/>
                                                            </svg>
                                                        </div>
                                                    </button>
                                                </x-slot>

                                                <x-slot name="content">
                                                    <!-- x-dropdown-link :href="route('dashboard')">
                                                        { { __('Passer niveau 4') }}
                                                    </x-dropdown-link -->
                                                    <x-dropdown-link :href="route('dashboard')">
                                                        {{ __('Passer à 3') }}
                                                    </x-dropdown-link>
                                                    <x-dropdown-link :href="route('dashboard')">
                                                        {{ __('Passer à 2') }}
                                                    </x-dropdown-link>
                                                </x-slot>
                                            </x-dropdown>
                                        </td>
                                    @endif

                                @endif

                            </tr>
                        @endfor
                        </tbody>
                    </table>
                    <div class="m-5"></div>
                    <div class="p-3"></div>

                </div>
            </div>
        </div>
    </div>


</x-app-layout>

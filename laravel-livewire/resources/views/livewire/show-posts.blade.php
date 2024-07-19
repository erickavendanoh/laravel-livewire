<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <x-table>

            <div class="px-6 py-4 flex items-center">
                {{-- <input type="text" wire:model.live="search"> --}}
                <x-input type="text" class="flex-1 mr-4" placeholder="Escriba que quiere buscar" wire:model.live="search" />  <!--Componente de blade de los ya incluidos con Jetstream-->
            
                <livewire:create-post />
            </div>

            @if($posts->count()) {{--Se valida si existen "posts" por mostrar. Ósea que desde un inicio venga la variable con $posts con información, o que si se hayan encontrado coincidencias al momento de ir buscando--}}

            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th
                            class="w-24 cursor-pointer px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            wire:click="order('id')">
                            ID

                            {{-- Sort --}}
                            @if ($sort=='id')

                                @if ($direction == 'asc')
                                    <i class="fa fa-sort-alpha-asc float-right mt-1" aria-hidden="true"></i>
                                @else
                                    <i class="fa fa-sort-alpha-desc float-right mt-1" aria-hidden="true"></i>
                                @endif

                            @else
                                <i class="fa fa-sort float-right mt-1" aria-hidden="true"></i>
                            @endif
                        </th>
                        <th
                            class="cursor-pointer px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            wire:click="order('title')">
                            TITLE

                            {{-- Sort --}}
                            @if ($sort=='title')

                                @if ($direction == 'asc')
                                    <i class="fa fa-sort-alpha-asc float-right mt-1" aria-hidden="true"></i>
                                @else
                                    <i class="fa fa-sort-alpha-desc float-right mt-1" aria-hidden="true"></i>
                                @endif

                            @else
                                <i class="fa fa-sort float-right mt-1" aria-hidden="true"></i>
                            @endif

                        </th>
                        <th
                            class="cursor-pointer px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            wire:click="order('content')">
                            CONTENT

                            {{-- Sort --}}
                            @if ($sort=='content')

                                @if ($direction == 'asc')
                                    <i class="fa fa-sort-alpha-asc float-right mt-1" aria-hidden="true"></i>
                                @else
                                    <i class="fa fa-sort-alpha-desc float-right mt-1" aria-hidden="true"></i>
                                @endif

                            @else
                                <i class="fa fa-sort float-right mt-1" aria-hidden="true"></i>
                            @endif
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{$post->id}}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    {{$post->title}}
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    {{$post->content}}
                                </p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @else
                <div class="px-6 py-4">
                    No existe ningún registro coincidente
                </div>
            @endif

        </x-table>
    </div>
    
</div>
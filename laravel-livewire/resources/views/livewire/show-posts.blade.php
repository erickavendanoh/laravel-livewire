<div wire:init="loadPosts">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <x-table>

            <div class="px-6 py-4 flex items-center">
                <div class="flex items-center"> <!--Con clase "flex" se lográ que todos los elementos dentro de la etiqueta se vayan colocando a lo largo del eje X, ósea horizontalmente. Y con "items-center" se logra que se centren sobre el eje Y, ósea verticalmente-->
                    <span>Mostrar</span>

                    <select wire:model.live="cant" class="mx-2 form-control">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>

                    <span>entradas</span>
                </div>
                {{-- <input type="text" wire:model.live="search"> --}}
                <x-input type="text" class="flex-1 mx-4" placeholder="Escriba que quiere buscar" wire:model.live="search" />  <!--Componente de blade de los ya incluidos con Jetstream-->
            
                <livewire:create-post />
            </div>

            @if(count($posts)) {{--Se valida si existen "posts" por mostrar. Ósea que desde un inicio venga la variable con $posts con información, o que si se hayan encontrado coincidencias al momento de ir buscando--}}

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
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex">
                                {{-- <livewire:edit-post :$post :key="$post->id" /> --}}
                                <a class="btn btn-green" wire:click="edit({{$post}})">
                                    <i class="fa fa-pencil-square"></i>
                                </a>

                                <!--"ml-2" es para un margin left de 2px-->
                                <a class="btn btn-red ml-2" wire:click="$dispatch('deletePost', { post: {{ $post }} })"> <!--Se emite un evento llamdo "deletePost" a partir de cuando se desencadena el evento "click" ("wire:click"), y se manda el post en cuestión, este evento se escucha abajo en la parte correspondiente al stack "js" (lo contenido dentro de los push), y muestra la alerta, la cual cuando se confirme emite otro evento que vuelve a mandar la misma información del post a la función que se ejecuta cuando se escucha en ShowPosts.php y que hace lo correspondiente, en este caso eliminar el post -->
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($posts->hasPages())
                <div class="px-6 py-3">
                    {{$posts->links()}}
                </div>
            @endif

            @else
                <div class="px-6 py-4">
                    No existe ningún registro coincidente
                </div>
            @endif

        </x-table>


        <x-dialog-modal wire:model.live="open_edit">
            <x-slot name="title">
                Editar el post {{$title}} {{$id}}
            </x-slot>

            <x-slot name="content">

                <div wire:loading wire:target="image" class='mb-4'> 
                    <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
                        <p class="font-bold">Imagen cargando</p>
                        <p class="text-sm">Espere un momento hasta que la imagen se haya procesado</p>
                    </div>
                </div>

                <!--vista previa de imagen seleccionada-->
                @if ($image)
                    <img class="mb-4" src="{{$image->temporaryUrl()}}">
                @elseif($imagePost)
                    <img src="{{Storage::url($imagePost)}}" alt="" >
                @endif

                <div class="mb-4">
                    <x-label value="Título del post" />
                    <x-input wire:model.live="title" type="text" class="w-full" />
                </div>

                <div>
                    <x-label value="Contenido del post" />
                    <textarea wire:model.live="content" rows="6" class="form-control w-full"></textarea>
                </div>

                <div>
                    <input type="file" wire:model.live="image" />
                    <x-input-error for="image" />
                </div>

            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$set('open_edit', false)">
                    Cancelar
                </x-secondary-button>

                <!--Si bien se le coloco el wire:loading con " .attr="diabled" " para que se desactivara mientras se hace el proceso de actualización, ya no se le coloco el "wire:target" (como en create-post.blade.php) ya que al finalizar luego luego se cierra el modal y sale la alerta entonces ya no tiene mucho caso ponerle eso que lo que haría es volverlo a activar una vez finalizado el proceso-->
                <x-danger-button wire:click="update" wire:loading.attr="disabled" class="disabled:opacity-25">
                    Actualizar
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </div>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @script
            <script>
                $wire.on('deletePost', (post) => {
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                        // Esta parte corresponde a cuando confirman
                    }).then((result) => {
                        if (result.isConfirmed) {

                            //Se emite un evento llamado "delete", y en este caso como es hacia el mismo componente se emplea dispatchSelf
                            //se pasa como parámetro "post" el cuál ya tendrá el post en cuestión ya que se le mandó dentro de evento "deletePost" cuando se cliqueó en botón para eliminar un post
                            //luego ya dentro de ShowPosts se escucha ese evento, y se define el método que se ejecutará cuando eso pase y el cuál empleará el valor que se está pasando desde la emisión de este evento
                            $wire.dispatchSelf('delete', { post });

                            Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                            });
                        }
                    });
                });
            </script>
        @endscript

    @endpush
    
</div>
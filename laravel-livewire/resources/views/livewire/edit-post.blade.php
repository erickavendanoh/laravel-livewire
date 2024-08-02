<div>
    <a class="btn btn-green" wire:click="$set('open', true)">
        <i class="fa fa-pencil-square"></i>
    </a>

    <x-dialog-modal wire:model.live="open">
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
            @else
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
            <x-secondary-button wire:click="$set('open', false)">
                Cancelar
            </x-secondary-button>

            <!--Si bien se le coloco el wire:loading con " .attr="diabled" " para que se desactivara mientras e hace el proceso de actualización, ya no se le coloco el "wire:target" (como en create-post.blade.php) ya que al finalizar luego luego se cierra el modal y sale la alerta entonces ya no tiene mucho caso ponerle eso que lo que haría es volverlo a activar una vez finalizado el proceso-->
            <x-danger-button wire:click="save" wire:loading.attr="disabled" class="disabled:opacity-25">
                Actualizar
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>

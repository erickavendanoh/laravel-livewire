<div>
    <!--Componente de blade de los ya incluidos con Jetstream-->
    <x-danger-button wire:click="$set('open', true)"> <!--Lo de " $set('open', true) " corresponde a un método "mágico", los cuáles básicamente se usan para modificar una propiedad del componente de Livewire desde su front directamente, ósea algo que no es tan complejo y solo se refiere a un cambio de valor.-->
        Crear nuevo post
    </x-danger-button>

    <!--Componente de blade de los ya incluidos con Jetstream-->
    <x-dialog-modal wire:model.live="open">
    
        <x-slot name="title">
            Crear nuevo post
        </x-slot>

        <x-slot name="content">
            
            <div class="mb-4">
                <!--Componente de blade de los ya incluidos con Jetstream-->
                <x-label value="Título del post" />
                <!--Componente de blade de los ya incluidos con Jetstream-->
                <x-input type="text" class="w-full" wire:model.live="title"/> <!--Con " wire:model.defer="title" " es para asociar directamente este elemento HTML y el valor que vaya tomando con el atributo correspondiente del componente de Livewire, solo que la diferencia de hacerlo con " wire:model.live="title" " es que no se va ejecutando la función render() cada que se vaya modificando el atributo del componente, ósea cada que se vayan teclando valores en este caso, sino que ahora será hasta que se desencadene un evento (en este caso con el botón "Crear post" que tiene " wire: click="save" ") que haga que se actualice la página o así. Esto es de utilidad para el rendimiento, en cuestión de que no se esté ejecutando la función render() cada vez que se vayan ingresando valores-->

                <!--En caso de que haya error de validación correspondiente a atributo "title" por valor dado desde acá en elemento HTML en formulario-->
                <x-input-error for="title" />
            </div>

            <div class="mb-4">
                <x-label value="Contenido del post" />
                
                <!--La clase de css "form-control" se definió en un archivo creado llamado "form.css" dentro de resources/css. Donde el estilo se copió de lo que había después de lo de " 'class' => " en archivo "input.blade.php" dentro de resources/views/components. Y para poder aplicarlo se tuvo que importar ese archivo dentro del archivo "app.css" que igual está dentro de resources/css, con "@import 'form.css';" (si no se reflejan al momento limpiar cache de navegador)-->
                <textarea class="form-control w-full" rows="6" wire:model.live="content"></textarea>
            
                <x-input-error for="content" />
            </div>

        </x-slot>

        <x-slot name="footer">
            
            <x-secondary-button wire:click="$set('open', false)"> <!--Lo de " $set('open', false) " corresponde a un método "mágico"-->
                Cancelar
            </x-secondary-button>

            <x-danger-button wire:click="save">
                Crear post
            </x-danger-button>
        </x-slot>

    </x-dialog-modal>
</div>

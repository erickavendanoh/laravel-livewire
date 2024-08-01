<div>
    <a class="btn btn-green" wire:click="$set('open', true)">
        <i class="fa fa-pencil-square"></i>
    </a>

    <x-dialog-modal wire:model.live="open">
        <x-slot name="title">
            Editar el post {{$post->title}}
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <x-label value="Título del post" />
                <x-input wire:model.live="post.title" type="text" class="w-full" />
            </div>

            <div>
                <x-label value="Contenido del post" />
                <textarea wire:model.live="post.content" rows="6" class="form-control w-full"></textarea>
            </div>
        </x-slot>

        <x-slot name="footer">
            
        </x-slot>
    </x-dialog-modal>
</div>

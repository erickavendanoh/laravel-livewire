<div>
    <a class="btn btn-green" wire:click="$set('open', true)">
        <i class="fa fa-pencil-square"></i>
    </a>

    <x-dialog-modal wire:model.live="open">
        <x-slot name="title">
            Editar el post {{$post->title}}
        </x-slot>

        <x-slot name="content">
            
        </x-slot>

        <x-slot name="footer">
            
        </x-slot>
    </x-dialog-modal>
</div>

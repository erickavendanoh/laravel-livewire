<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class EditPost extends Component
{
    public $open = false; //Para mostrar/ocultar modal
    public $post; //propiedad que tendrá como valor el post que se quiera editar

    public function mount(Post $post){
        $this->post = $post;
    }

    public function render()
    {
        return view('livewire.edit-post');
    }
}

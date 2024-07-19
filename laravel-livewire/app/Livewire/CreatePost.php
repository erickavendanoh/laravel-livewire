<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class CreatePost extends Component
{

    public $open = false; //atributo booleano con el que se controlara si se muestra o no el modal
    public $title, $content;

    
    public function save()
    {
        Post::create([
            'title' => $this->title,
            'content' => $this->content
        ]);
    }
    public function render()
    {
        return view('livewire.create-post');
    }
}

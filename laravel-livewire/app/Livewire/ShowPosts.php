<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Post;

class ShowPosts extends Component
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    // protected $listeners = ['render' => 'render']; //Arreglo que contendrá los eventos que este componente va a "oir" de otro componente con la función propia correspondiente que ejecutará cuando lo haga
    protected $listeners = ['render']; //Lo mismo que el de arriba pero de forma abreviada, ya que cuando el evento que se esucha y el método propio que se va a ejecutar se llaman igual solo se puede poner una vez y Livewire entenderá

    public function render()
    {
        $posts = Post::where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%')
                    ->orderBy($this->sort, $this->direction)
                    ->get();

        return view('livewire.show-posts', compact('posts'))
                ->layout('layouts.app');
    }

    public function order($sort){

        if($this->sort == $sort){
            if($this->direction == 'desc'){
                $this->direction = 'asc';
            }else{
                $this->direction = 'desc';
            }
        }else{
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }
}

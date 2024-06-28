<?php

namespace App\Livewire;

use Livewire\Component;

class ShowPosts extends Component
{
    //Los valores que se pasen como parámetros a un componente de Livewire desde las vistas corresponderán a los atributos acá en su clase (Back)
    public $titulo;

    //En caso de que no se quiera asignar el valor al atributo directamente desde la vista, se puede emplear esta función mount, la cual no se llama explicitamente sino que lo que se le ponga como parámetro serán las variables a las que se les de valor desde las llamadas en las vistas del componente (donde el nombre del parámetro y la asignación del valor del mismo desde la vista deben corresponder), y ya acá dentro se le asigna ese valor al atributo correspondiente, el cual es el que se usa en el "front" (archivo blade.php) del componente
    public function mount($title){
        $this->titulo = $title;
    }

    public function render()
    {
        return view('livewire.show-posts');
    }
}

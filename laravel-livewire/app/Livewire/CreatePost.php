<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class CreatePost extends Component
{

    public $open = false; //atributo booleano con el que se controlara si se muestra o no el modal
    
    public $title, $content;

    //reglas de validación
    protected $rules = [
        'title' => 'required|max:10',
        'content' => 'required|min:100'
    ];

    //Método que se va a estar ejecutando cada vez que se vaya modificando algún atributo o propiedad del componente, donde dentro se estará validando si el valor que va obteniendo ese atributo o propiedad ya cumple con su regla de validación correspondiente
    //*para que esto funcione, en el front en el "wire:model" de cada <input> habrá que quitarle el ".defer" y cambiarlo por el ".live"
    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }
    
    public function save()
    {

        $this->validate(); //verifica que los valores dados a los atributos del componente desde los elementos HTML cumplan con las respectivas reglas definidas en $rules, si es así hace todo lo que sigue dentro de este método, si no no hace nada de lo que sigue

        Post::create([
            'title' => $this->title,
            'content' => $this->content
        ]);

        $this->reset(['open', 'title', 'content']); //reset() se emplea para resetar los valores de atributos de un componente. En este caso al estar relacionados directamente con elementos HTML (entradas de formulario del modal) también se "limpiaría" ese formulario. Así como resetear el valor de atributo "open" a false, que es con el que se controla si se muestra o no el formulario, con lo que al volver a false ya no se mostraría.

        $this->dispatch('render')->to(ShowPosts::class); //Evento llamado "render" que se quiere que componente ShowPost "escuche" (en este caso está específico para que el evento "render" de este componente solo lo escuche el componente ShowPosts)
        $this->dispatch('alert', message: 'El post se creó satisfactoriamente');
    }
    public function render()
    {
        return view('livewire.create-post');
    }
}

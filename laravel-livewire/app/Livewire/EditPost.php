<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditPost extends Component
{
    use WithFileUploads;

    public $open = false; //Para mostrar/ocultar modal
    public $id, $title, $content, $imagePost; //Atributos que contendrán los valores del post que se reciba. Aplicando el concepto de "desestructuración"
    public $image; //esta variable será en la que se almacene el valor de la nueva imagen seleccionada, ya que en $imagePost estará la que ya había en el post si es el caso. Se tuvieron que crear dos "para lo mismo" para diferenciar una de otra en las condicionales tanto del front como del back donde se pregunta si el usuario selecciono otra imagen

    protected $rules = [
        'title' => 'required',
        'content' => 'required',
    ];

    public function mount(Post $post){
        $this->id = $post->id;
        $this->title = $post->title;
        $this->content = $post->content;
        $this->imagePost = $post->image;
    }

    public function save(){
        $this->validate();

        $post = Post::findOrFail($this->id);

        //Si se vuelve a seleccionar otra imagen al editar el post, se debe eliminar la imagen que había en ese post, luego subir la nueva y actualizar la url que se tenía en BD con la url de la nueva imagen
        if($this->image){ //se pregunta si se le dió valor al campo imagen (significa que se seleccionó algo en el input file)
            Storage::delete([$this->imagePost]); //se borra del storage la imagen que había
            $imageInsert = $this->image->store('posts'); //se sube la nueva imagen a la vez que la url que genera esa línea de código se almacena en el campo de ese post en la BD
        }else{
            $imageInsert = $this->imagePost; //si no, se deja en variable image la imagen que ya traía el post originalmente
        }

        $post->update([
            'title' => $this->title,
            'content' => $this->content,
            'imagen' => $imageInsert
        ]);

        $this->reset(['open', 'image']);

        $this->dispatch('render')->to(ShowPosts::class); 
        $this->dispatch('alert', message: 'El post se actualizó satisfactoriamente');
    }

    public function render()
    {
        return view('livewire.edit-post');
    }
}

<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Post;
use Livewire\WithFileUploads; //Necesario para parte editar. Para subir poder subir archivos, en este caso si se actualiza la imagen del post desde el modal para editar
use Livewire\WithPagination;

class ShowPosts extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $search=''; //Se inicializó con cadena vacía por tema de Query String, para lo de validación de que no coloque esta propiedad/atributo y su valor en URL cuando tenga este valor con el que se incializa, y que solo lo haga cuando sea distinto, ósea cuanod el usuario si busqué algo, con lo que le dará valor a este atributo

    public $id, $title, $content, $imagePost; //Para parte de editar. Atributos que contendrán los valores del post que se reciba. Aplicando el concepto de "desestructuración"

    public $image; //Para parte de editar. Esta variable será en la que se almacene el valor de la nueva imagen seleccionada, ya que en $imagePost estará la que ya había en el post si es el caso. Se tuvieron que crear dos "para lo mismo" para diferenciar una de otra en las condicionales tanto del front como del back donde se pregunta si el usuario selecciono otra imagen

    public $sort = 'id';
    public $direction = 'desc';

    public $open_edit = false; //Atributo con el que se controlará mostrar/ocultar el modal para editar

    public $cant = '10'; //Atributo/propiedad con la que se controlará la cantidad de registros que quiera ver el usuario. Al principio estaba con valor numérico, pero luego se cambió a string por tema de Query String, pero el funcionamiento sigue siendo igual

    public $readyToLoad = false; //Atributo/propiedad correspondiente a parte de "aplazar carga"

    //Atributo/propiedad empleado para el concepto de Query String, con el cual se coloca cierta información en la URL. Dentro del arreglo se coloca la información que se quiere incluir en la URL. En este caso ya solo colocando el nombre de los atributos/propiedades del componente ya se colocarán en automático en la URL así como los valores que vayan teniendo. La parte del "=> ['except' => ]" es para que cuando tengan el valor indicado ahí, en este caso los que también son su valores iniciales cuando las declaramos se quiten de la URL, esto para que cuando no tengan un valor distinto al inicial aparezcan en la URL y se vean siempre, lo que visualmente no se ve tan agradable en un momento dado ya que se vuelve muy larga, y que solo aparezcan en la URL cuando tengan un valor distinto al indicado
    protected $queryString = [
        'cant' => ['except' => '10'], 
        'sort' => ['except' => 'id'], 
        'direction' => ['except' => 'desc'], 
        'search' => ['except' => '']
    ];

    // protected $listeners = ['render' => 'render']; //Arreglo que contendrá los eventos que este componente va a "oir" de otro componente con la función propia correspondiente que ejecutará cuando lo haga
    protected $listeners = ['render', 'delete']; //Lo mismo que el de arriba pero de forma abreviada, ya que cuando el evento que se esucha y el método propio que se va a ejecutar se llaman igual solo se puede poner una vez y Livewire entenderá

    //Para el modal de editar
    protected $rules = [
        'title' => 'required',
        'content' => 'required',
    ];

    public function render()
    {
        if($this->readyToLoad){
            $posts = Post::where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%')
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->cant);
        }else{
            $posts = [];
        }
        // $posts = Post::where('title', 'like', '%' . $this->search . '%')
        //             ->orWhere('content', 'like', '%' . $this->search . '%')
        //             ->orderBy($this->sort, $this->direction)
        //             ->paginate($this->cant);

        return view('livewire.show-posts', compact('posts'))
                ->layout('layouts.app');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
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

    //Para parte de editar. Con este método se recupera la información del post seleccionado y se abre el modal que muestra dicha información para poder editarla. Y ya con la función update() ahí ya se hace la actualización como tal en la BD y Storage
    public function edit(Post $post) //Se indica que el parámetro que recibe se trata de una instancia del modelo Post
    {
        $this->open_edit = true; //Para que se abra el modal de editar
        $this->id = $post->id;
        $this->title = $post->title;
        $this->content = $post->content;
        $this->imagePost = $post->image;
    }

    public function update()
    {
        $this->validate();

        $post = Post::findOrFail($this->id);

        //Si se vuelve a seleccionar otra imagen al editar el post, se debe eliminar la imagen que había en ese post, luego subir la nueva y actualizar la url que se tenía en BD con la url de la nueva imagen
        if($this->image){ //se pregunta si se le dió valor al campo imagen (significa que se seleccionó algo en el input file)
            Storage::delete($this->imagePost); //se borra del storage la imagen que había
            $this->imagePost = $this->image->store('public/posts'); //se sube la nueva imagen a la vez que la url que genera esa línea de código será ahora el nuevo valor en el atributo "imagePost"
        }

        $post->update([
            'title' => $this->title,
            'content' => $this->content,
            'image' => $this->imagePost //Se guarda en campo "image" del registro de la BD ya sea el valor (ruta) que se tenía desde antes (si no se selecciono ninguna imagen nueva) o el nuevo valor (ruta) de la nueva imagen si es que se selecciono otra, según sea el caso
        ]);

        $this->reset(['open_edit', 'image']);

        // $this->dispatch('render')->to(ShowPosts::class); //Ya no es necesario emitir el evento, como se hacía cuando todo esto se hacía en otro componente (EditPost), porque ya se está realizando la acción sobre este mismo componente
        $this->dispatch('alert', message: 'El post se actualizó satisfactoriamente');
    }

    public function delete(Post $post){
        $id = $post->id;
        $post = Post::findOrFail($id);
        $post->delete();
    }
}

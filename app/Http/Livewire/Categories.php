<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;

use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Storage;

class Categories extends Component
{
    use WithFileUploads;
    use WithPagination;

    //protected $paginationTheme = "bootstrap";

    protected $listeners = ['deleteRow' => 'Destroy'];

    public $name, $search, $image, $selected_id, $pageTitle, $componentName; 
    private $pagination = 5;
    

    public function mount() 
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Categorias';
    }

    public function render()
    {
        if(strlen($this->search) > 0) {
            $categories = Category::orderBy('name', 'asc')->where('name', 'LIKE', '%'. $this->search. '%')->paginate($this->pagination);
        } else {
            $categories = Category::orderBy('name', 'asc')->paginate($this->pagination);
        }
        

        return view('livewire.category.categories', compact('categories'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    //Tema de pagination
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function Edit($id) {
        $category = Category::find($id, ['name', 'id', 'image']);

        $this->name = $category->name;
        $this->selected_id = $category->id;
        $this->image = null;

        $this->emit('show-modal', 'show-modal');
    }

    public function Store() {
        $rules = [
            'name' => 'required|unique:categories|min:3',
        ];

        /* $message = [
            'name.required' => 'El Campo Nombre es Requerido.',
            'name.unique' => 'Ya existe una Categoria con el mismo nombre.',
            'name.min' => 'El nombre debe tener más de 3 letras.'
        ]; */

        $this->validate($rules);

        $category = Category::create([
            'name' => $this->name,
        ]);

        $imagenSubida = '';

        if($this->image) {

            $imagenSubida = uniqid(). '_.'. $this->image->extension();
            $this->image->storeAs('public/categorias', $imagenSubida);

            $category->image = 'categorias/'. $imagenSubida;
            $category->save();
        }

        $this->resetUI();
    } 

    public function resetUI() {
        $this->emit('category-added', 'agregado');
        $this->name = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
    }

    public function Update() {
        $rules = [
            'name' => "required|unique:categories,name,{$this->selected_id}|min:3",
        ];

        $this->validate($rules);

        $category = Category::find($this->selected_id);

        $category->update([
            'name' => $this->name,
        ]);

        if($this->image) {
            $imagenSubida = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/categorias', $imagenSubida);

            $imageName = $category->image;

            $category->image = 'categorias/'. $imagenSubida;
            $category->save();

            if($imageName != null) {
                if(file_exists('storage/' . $imageName)) {
                    unlink('storage/'. $imageName);
                }
            }

            $this->resetUI();
            $this->emit('category_updated', 'actualizado');
        }
    }

    public function Destroy(Category $category) {

        //$category = Category::find($id);
        //dd($category);

        $imageName = $category->image; //Ruta de la Imagen

        $category->delete();

        if($imageName != null) {
            unlink('storage/'. $imageName);
        }

        $this->resetUI();
        $this->emit('category-deleted', 'Eliminado');

    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $name, $barcode, $cost, $price, $stock, $alerts, $category_id, $search, $image, $selected_id, $pageTitle, $componentName;

    private $pagination = 5;

    public function paginationView() {
        return 'vendor.livewire.bootstrap';
    }

    public function mount() {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Productos';
        $this->category_id = 'Elegir';
    }

    public function render()
    {
        $categories = Category::orderBy('name', 'asc')->get();

        if(strlen($this->search) > 0) {
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                            ->select('products.*', 'c.name as category')
                            ->where('products.name', 'LIKE', '%'. $this->search . '%')
                            ->orwhere('products.barcode', 'LIKE', '%'. $this->search . '%')
                            ->orwhere('c.name', 'LIKE', '%'. $this->search . '%')
                            ->orderBy('products.name', 'asc')
                            ->paginate($this->pagination);
        } else {
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                            ->select('products.*', 'c.name as category')
                            ->orderBy('products.name', 'asc')
                            ->paginate($this->pagination);
        } 


        return view('livewire.product.products', compact('products', 'categories'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function resetUI() {
        $this->name = '';
        $this->cost = '';
        $this->price = '';
        $this->barcode = '';
        $this->stock = '';
        $this->alerts = '';
        $this->category_id = 'Elegir';
        $this->selected_id = 0;

    }

    public function Store() {

        $rules = [
            'name' => 'required|unique:products|min:3',
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alerts' => 'required',
            'category_id' => 'required|not_in:Elegir'
        ];

        $messages = [
            'category_id.not_in' => 'Seleccione una opción',
        ];

        $this->validate($rules, $messages);

        $product = Product::create([
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
            'barcode' => $this->barcode,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
            'category_id' => $this->category_id,
        ]);

        if($this->image) {
            $customFileName = uniqid(). '_.'. $this->image->extension();

            $this->image->storeAs('public/productos', $customFileName);

            $product->image = 'productos/' .$customFileName;
            $product->save();
        }

        $this->resetUI();

        $this->emit('product-added', 'Producto Registrado');
    }

    public function Edit(Product $product) {
        $this->name = $product->name; 
        $this->cost = $product->cost; 
        $this->price = $product->price; 
        $this->barcode = $product->barcode; 
        $this->stock = $product->stock; 
        $this->alerts = $product->alerts; 
        $this->category_id = $product->category_id; 
        $this->selected_id = $product->id;
        $this->image = null;

        $this->emit('show-modal', 'editar');
    }

    public function Update() {

        $rules = [
            'name' => "required|min:3|unique:products,name,{$this->selected_id}",
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alerts' => 'required',
            'category_id' => 'required|not_in:Elegir'
        ];

        $messages = [
            'category_id.not_in' => 'Seleccione una opción',
        ];

        $this->validate($rules, $messages);

        $product = Product::find($this->selected_id);

        $product->update([
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
            'barcode' => $this->barcode,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
            'category_id' => $this->category_id,
        ]);

        if($this->image) {
            $imageTemp = $product->image;
            
            $customFileName = uniqid(). '_.'. $this->image->extension();

            $this->image->storeAs('public/productos', $customFileName);

            $product->image = 'productos/' .$customFileName;

            $product->save();

            if($imageTemp != null) {
                if(file_exists('storage/'. $imageTemp)) {
                    unlink('storage/'. $imageTemp);
                }
            }
        }

        $this->resetUI();

        $this->emit('product-updated', 'Producto Actualizado');
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Product $product) {

        $imageTemp = $product->image;
        $product->delete();

        if($imageTemp != null) {
            if(file_exists('storage/'. $imageTemp)) {
                unlink('storage/'. $imageTemp);
            }
        }
        $this->resetUI();
        $this->emit('product-deleted', 'Eliminado');
    }

    
}

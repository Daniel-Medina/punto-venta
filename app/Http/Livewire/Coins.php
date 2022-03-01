<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Denomination;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Storage;

class Coins extends Component
{
    use WithFileUploads;
    use WithPagination;

    //protected $paginationTheme = "bootstrap";

    protected $listeners = ['deleteRow' => 'Destroy'];

    public $type, $value ,$search, $image, $selected_id, $pageTitle, $componentName; 
    private $pagination = 5;
    

    public function mount() 
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Monedas';
        $this->type = 'Elegir';
    }

    public function render()
    {
        if(strlen($this->search) > 0) {
            $coins = Denomination::orderBy('id', 'asc')->where('type', 'LIKE', '%'. $this->search. '%')->paginate($this->pagination);
        } else {
            $coins = Denomination::orderBy('id', 'asc')->paginate($this->pagination);
        }
        

        return view('livewire.denomination.coins', compact('coins'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    //Tema de pagination
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function Edit($id) {
        $denomination = Denomination::find($id, ['type', 'value', 'id', 'image']);

        $this->type = $denomination->type;
        $this->value = $denomination->value;
        $this->selected_id = $denomination->id;
        $this->image = null;

        $this->emit('show-modal', 'show-modal');
    }

    public function Store() {
        $rules = [
            'type' => 'required|not_in:Elegir',
            'value' =>'required|unique:denominations',
        ];


        $this->validate($rules);

        $denomination = Denomination::create([
            'type' => $this->type,
            'value' => $this->value,
        ]);

        if($this->image) {

            $imagenSubida = '';
            $imagenSubida = uniqid(). '_.'. $this->image->extension();
            $this->image->storeAs('public/monedas', $imagenSubida);

            $denomination->image = 'monedas/'. $imagenSubida;
            $denomination->save();
        }

        $this->resetUI();

        $this->emit('item-added', 'agregado');
    } 

    public function resetUI() {
        $this->emit('item-added', 'agregado');
        $this->type = '';
        $this->value = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
    }

    public function Update() {
        $rules = [
            'type' => 'required|not_in:Elegir',
            'value' => "required|unique:denominations,value,{$this->selected_id}",
        ];

        $this->validate($rules);

        $denomination = Denomination::find($this->selected_id);

        $denomination->update([
            'type' => $this->type,
            'value' => $this->value,
        ]);

        if($this->image) {

            $imagenSubida = uniqid() . '_.' . $this->image->extension();

            $this->image->storeAs('public/monedas', $imagenSubida);

            $imageName = $denomination->image;

            $denomination->image = 'monedas/'. $imagenSubida;
            $denomination->save();

            if($imageName != null) {
                if(file_exists('storage/' . $imageName)) {
                    unlink('storage/'. $imageName);
                }
            }

            $this->resetUI();
            $this->emit('item-updated', 'actualizado');
        }
    }

    public function Destroy(Denomination $denomination) {


        $imageName = $denomination->image; //Ruta de la Imagen

        $denomination->delete();

        if($imageName != null) {
            unlink('storage/'. $imageName);
        }

        $this->resetUI();
        $this->emit('item-deleted', 'Eliminado');

    }
}

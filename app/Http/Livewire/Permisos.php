<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Permisos extends Component
{
    use WithPagination;

    protected $listeners = ['deleteRow' => 'Destroy'];

    public $permissionName, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 10;

    public function paginationView() {
        return 'vendor.livewire.bootstrap';
    }

    public function mount() {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Permisos';
    }

    public function render()
    {
        if(strlen($this->search) > 0) {
            $permisos = Permission::where('name', 'LIKE', '%'. $this->search . '%')->paginate($this->pagination);
        } else {
            $permisos = Permission::orderBy('name', 'asc')->paginate($this->pagination);
        }

        return view('livewire.permisos.permisos', compact('permisos'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function CreatePermission() {
        $rules = [
            'permissionName' => 'required|min:2|unique:permissions,name'
        ];

        $message = [
            'permissionName.required' => 'El nombre del permiso es requerido',
            'permissionName.unique' => 'El permiso ya existe',
            'permissionName.min' => 'El nombre debe tener más de 2 caracteres'
        ];

        $this->validate($rules, $message);

        Permission::create([
            'name' => $this->permissionName,
        ]);

        $this->emit('permission-added', 'Permiso Agregado con éxito');
        $this->resetUI();
    }

    public function Edit(Permission $permission) {
        $this->selected_id = $permission->id;
        $this->permissionName = $permission->name;

        $this->emit('show-modal', 'Show modal');
    }

    public function UpdatePermission() {
        $rules = [
            'permissionName' => "required|min:2|unique:permissions,name, {$this->selected_id}"
        ];

        $message = [
            'permissionName.required' => 'El nombre del permiso es requerido',
            'permissionName.unique' => 'El permiso ya existe',
            'permissionName.min' => 'El nombre debe tener más de 2 caracteres'
        ];

        $this->validate($rules, $message);

        $permission = Permission::find($this->selected_id);
        $permission->name = $this->permissionName;
        $permission->save();

        $this->emit('permission-updated', 'Actualizado correctamente');
        $this->resetUI();
    }


    public function Destroy(Permission $permission) {
        $rolesCount = $permission->getRoleNames()->count();

        if($rolesCount > 0) {
            $this->emit('permission-error', 'No se puede eliminar el permiso porque tiene roles asignados.');
            return;
        }

        $permission->delete();

        $this->emit('permission-deleted', 'Eliminado correctamente');
    }

    public function resetUI()
    {
        $this->permissionName = '';
        $this->selected_id = 0;
        $this->search = '';
        $this->resetValidation();
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    use WithPagination;

    protected $listeners = ['deleteRow' => 'Destroy'];

    public $roleName, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function paginationView() {
        return 'vendor.livewire.bootstrap';
    }

    public function mount() {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Roles';
    }

    public function render()
    {
        if(strlen($this->search) > 0) {
            $roles = Role::where('name', 'LIKE', '%'. $this->search . '%')->paginate($this->pagination);
        } else {
            $roles = Role::orderBy('name', 'asc')->paginate($this->pagination);
        }

        return view('livewire.role.roles', compact('roles'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function CreateRole() {
        $rules = [
            'roleName' => 'required|min:2|unique:roles,name'
        ];

        $message = [
            'roleName.required' => 'El nombre del Rol es requerido',
            'roleName.unique' => 'El rol ya existe',
            'roleName.min' => 'El nombre debe tener más de 2 caracteres'
        ];

        $this->validate($rules, $message);

        Role::create([
            'name' => $this->roleName,
        ]);

        $this->emit('role-added', 'Rol Agregado con éxito');
        $this->resetUI();
    }

    public function Edit(Role $role) {
        $this->selected_id = $role->id;
        $this->roleName = $role->name;

        $this->emit('show-modal', 'Show modal');
    }

    public function UpdateRole() {
        $rules = [
            'roleName' => "required|min:2|unique:roles,name, {$this->selected_id}"
        ];

        $message = [
            'roleName.required' => 'El nombre del Rol es requerido',
            'roleName.unique' => 'El rol ya existe',
            'roleName.min' => 'El nombre debe tener más de 2 caracteres'
        ];

        $this->validate($rules, $message);

        $role = Role::find($this->selected_id);
        $role->name = $this->roleName;
        $role->save();

        $this->emit('role-updated', 'Actualizado correctamente');
        $this->resetUI();
    }


    public function Destroy(Role $role) {
        $permissionCount = $role->permissions()->count();

        if($permissionCount > 0) {
            $this->emit('role-error', 'No se puede eliminar el rol porque tiene permisos asignados.');
            return;
        }

        $role->delete();

        $this->emit('role-deleted', 'Eliminado correctamente');
    }

    public function resetUI()
    {
        $this->roleName = '';
        $this->selected_id = 0;
        $this->search = '';
        $this->resetValidation();
    }
}

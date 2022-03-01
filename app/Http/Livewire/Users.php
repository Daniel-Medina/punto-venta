<?php

namespace App\Http\Livewire;

use App\Models\Sale;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

use function PHPUnit\Framework\fileExists;

class Users extends Component
{
    use WithFileUploads;
    use WithPagination;


    //Propiedades Publicas
    public $name, $phone, $email, $profile, $status, $image, $password, $selected_id, $file_loaded, $role;
    public $pageTitle, $componentName, $search;


    private $pagination = 3;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Usuarios';
        $this->status = 'Elegir';
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = User::where('name', 'LIKE', '&'. $this->search . '%')
                ->select('*')->orderBy('name', 'asc')->paginate($this->pagination);
        } else {
            $data = User::select('*')->orderBy('name', 'asc')->paginate($this->pagination);
        }       

        return view('livewire.users.users', [
            'data' => $data,
            'roles' => Role::orderBy('name', 'asc')->get(),
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function resetUI()
    {
        $this->name =  '';
        $this->phone =  '';
        $this->email =  '';
        $this->status =  'Elegir';
        $this->image =  '';
        $this->search =  '';
        $this->selected_id =  '';
        $this->profile = 'Elegir';
        $this->resetValidation();
        $this->resetPage();
    }

    public function edit(User $user)
    {
        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->profile = $user->profile;
        $this->status = $user->status;
        $this->email = $user->email;
        $this->passowrd = '';

        $this->emit('show-modal', 'open');
    }

    
    protected $listeners = [
        'deleteRow' => 'destroy',
        'resetUI' => 'resetUI'
    ];

    public function Store() {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|unique:users|email',
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:3',
        ];

        $messages = [
            'name.required' => 'Ingrese el nombre',
            'name.min' => 'El nombre debe ser mayor a 3 caracteres',
            'email.required' => 'Ingrese el email',
            'email.unique' => 'El email proporcinado ya existe',
            'email.email' => 'El email no es valido',
            'status.required' => 'El estatus es necesario',
            'status.not_in' => 'Seleccione una opción valida',
            'profile.required' => 'El perfil es necesario',
            'profile.not_in' => 'Seleccione una opción valida',
            'password.required' => 'La contraseña no puede estar vacia',
            'password.min' => 'La contraseña debe ser mayor a 3 caracteres',
        ];

        $this->validate($rules, $messages);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'profile' => $this->profile,
            'password' => bcrypt($this->password),
        ]);


        $user->syncRoles($this->profile);


        if ($this->image) {
            $customFileName = uniqid(). '_.' . $this->image->extension();
            $this->image->storeAs('public/users', $customFileName);
            $user->image = 'users/'. $customFileName;
        }

        $user->save();

        $this->resetUI();

        $this->emit('user-added', 'Usuario Registrado');
    }

    public function Update()
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => "required|unique:users,email,{$this->selected_id}|email",
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:3',
        ];

        $messages = [
            'name.required' => 'Ingrese el nombre',
            'name.min' => 'El nombre debe ser mayor a 3 caracteres',
            'email.required' => 'Ingrese el email',
            'email.unique' => 'El email proporcinado ya existe',
            'email.email' => 'El email no es valido',
            'status.required' => 'El estatus es necesario',
            'status.not_in' => 'Seleccione una opción valida',
            'profile.required' => 'El perfil es necesario',
            'profile.not_in' => 'Seleccione una opción valida',
            'password.required' => 'La contraseña no puede estar vacia',
            'password.min' => 'La contraseña debe ser mayor a 3 caracteres',
        ];

        $this->validate($rules, $messages);

        $user = User::find($this->selected_id);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'profile' => $this->profile,
            'password' => bcrypt($this->password),
        ]);

        $user->syncRoles($this->profile);

        if ($this->image) {
            $customFileName = uniqid(). '_.' . $this->image->extension();
            $this->image->storeAs('public/users', $customFileName);

            $imageTemo = $user->image;

            $user->image = 'users/'. $customFileName;

            if ($imageTemo != null) {
                if (fileExists('storage/users/' . $imageTemo)) {
                    unlink('storage/users/' . $imageTemo);
                }
            }
        }

        $user->save();
        $this->resetUI();

        $this->emit('user-updated', 'Usuario Actualizado');
    }


    public function destroy(User $user)
    {
        if ($user) {
            $sale = Sale::where('user_id', $user->id)->count();

            if ($sale > 0) {
                $this->emit('user-withsales', 'No se puede eliminar un usuario con ventas.');
            } else {
                $user->delete();
                $this->resetUI();

                $this->emit('user-deleted', 'Usuario Eliminado');
            }
        }
    }
}

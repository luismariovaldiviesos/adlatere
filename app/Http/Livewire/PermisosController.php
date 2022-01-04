<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use App\Models\User;
use DB;

class PermisosController extends Component
{
    use WithPagination;

    public $permissionName, $search, $selected_id, $pageTitle, $componentName;
    private $pagination =10;

    function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = "Listado";
        $this->componentName = "Permisos";
    }

    public function render()
    {
        if(strlen($this->search) > 0)
            $permisos =  Permission::where('name','like','%'. $this->search. '%')->paginate($this->pagination);
        else
            $permisos =  Permission::orderBy('id','asc')->paginate($this->pagination);

        return view('livewire.permisos.component', [
            'permisos' => $permisos
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function CreatePermission()
    {
        $rules = ['permissionName' => 'required|min:2|unique:permissions,name'];

        $messages = [
            'permissionName.required' => 'el nombre del permiso es requerido',
            'permissionName.min' => 'el tamaño del permiso debe ser minimo dos caracteres',
            'permissionName.unique' => 'el nombre del permiso ya existe'
        ];

        $this->validate($rules,$messages);

        Permission::create([
            'name' => $this->permissionName
        ]);

        $this->emit('permiso-added','Permiso creado satisfactoriamente');
        $this->resetUI();
    }


    public function Edit(Permission $permiso)
    {
        //$role = Role::find($id);
        $this->selected_id = $permiso->id;
        $this->permissionName = $permiso->name;

        $this->emit('show-modal', 'Show Modal');

    }

    public function UpdatePermission()
    {
        $rules = ['permissionName' => "required|min:2|unique:permissions,name, {$this->selected_id}"];

        $messages = [
            'permissionName.required' => 'el nombre del permiso es requerido',
            'permissionName.min' => 'el tamaño del permiso debe ser minimo dos caracteres',
            'permissionName.unique' => 'el nombre del permiso ya existe'
        ];
        $this->validate($rules,$messages);
        $permiso = Permission::find($this->selected_id);
        $permiso->name = $this->permissionName;
        $permiso->save();
        $this->emit('permiso-updated','Permiso actualizado satisfactoriamente');
        $this->resetUI();
    }

    protected $listeners = ['destroy' => 'Destroy'];

    public  function Destroy($id)
    {
        $rolesCount =  Permission::find($id)->getRoleNames()->count();
        if($rolesCount > 0)
        {
            $this->emit('permiso-error','No se puede eliminar el permiso porque tiene roles asociados');
            return;
        }
        Permission::find($id)->delete();
        $this->emit('permiso-deleted','Permiso elimnado con éxito');

    }

    public function resetUI()
    {
        $this->permissionName = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
        $this->resetPage();
    }


}

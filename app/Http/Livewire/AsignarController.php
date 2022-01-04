<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\String\b;

class AsignarController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $componentName, $permisosSelected=[], $oldPermisos=[];
    public $role;

    private $pagination = 10;

    public function mount(){
      $this->componentName      = 'Asignar Permisos';
      $this->role               = 'ELEGIR';
    }

    public function paginationView()
    {
      return 'vendor.livewire.bootstrap';
    }
    public function render()
    {
        /* Obtenesmos permisos, orden nombre y paginacion*/
        $permisos = Permission::select('name','id', DB::raw("0 as checked"))
            ->orderBy('id','asc')
            ->paginate($this->pagination);
       // dd($permisos);
        if ($this->role != 'ELEGIR') {
            $list = Permission::join('role_has_permissions as rp','rp.permission_id','permissions.id')
                ->where('role_id', $this->role)->pluck('permissions.id')->toArray();
                $this->oldPermisos = $list;
        }

        if ($this->role != 'ELEGIR') {
            foreach ($permisos as $permiso) {
                $role = Role::find($this->role);
                $tienePermiso = $role->hasPermissionTo($permiso->name);
                if ($tienePermiso) {
                    $permiso->checked = 1;
                }
            }
        }
        return view('livewire.asignar.component', [
            'roles'     => Role::orderBy('name', 'asc')->get(),
            'permisos'  => $permisos,
        ])->extends('layouts.theme.app')->section('content');
    }

    protected $listeners = ['revokeall' => 'removeAll'];

    public function removeAll()
    {
        if ($this->role == 'ELEGIR') {
            $this->emit('sync-error','Selecciona un rol valido');
            return;
        }

        $role = Role::find($this->role);
        $role->syncPermissions([0]);
        $this->emit('removeall',"Se revocaron todos lo permisos al role $role->name");
    }

    public function syncAll()
    {
        if ($this->role == 'ELEGIR') {
            $this->emit('sync-error','Selecciona un rol valido');
            return;
        }
        $role = Role::find($this->role);
        $permisos = Permission::pluck('id')->toArray();
        $role->syncPermissions($permisos);
        $this->emit('syncall',"Se sincronizaron todos lo permisos al role $role->name");
    }

    public function syncPermiso($state, $permisoName)
    {
        //dd($state);
        if ($this->role != 'ELEGIR') {
            $roleName = Role::find($this->role);
            if ($state) {
                $roleName->givePermissionTo($permisoName);
                $this->emit('permi', "Permiso asignado al rol: $roleName->name");
            }else {
                $roleName->revokePermissionTo($permisoName);
                $this->emit('permi', "Permiso revocado al rol: $roleName->name");
            }
        }else {
            $this->emit('sync-error','Selecciona un rol valido');
        }
    }

}

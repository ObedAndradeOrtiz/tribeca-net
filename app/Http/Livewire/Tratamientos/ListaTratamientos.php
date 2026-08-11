<?php

namespace App\Http\Livewire\Tratamientos;

use App\Models\Ocupacion;
use App\Models\OcupacionImagen;
use App\Models\Tratamiento;
use App\Models\TratamientoArea;
use App\Models\Areas;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ListaTratamientos extends Component
{
    use WithFileUploads;

    public $actividad = 'Activo';

    public $tratamientos;

    public $busqueda;

    public $modalOcupacion = false;

    public $departamento_id;

    public $tipo;

    public $parentesco;

    public $nombre;

    public $ci;

    public $edad;

    public $telefono;

    public $estado = 'Activo';

    public $fecha_inicio;

    public $fecha_fin;

    public $ocupacion_id;

    public $editando = false;

    public $imagenes = [];

    public $imagenesExistentes = [];

    public $ocupaciones;
    public $opcion='departamento';

    protected $listeners = ['render' => 'render'];

    // ================= IMÁGENES =================
    public function quitarImagen($index)
    {
        unset($this->imagenes[$index]);
        $this->imagenes = array_values($this->imagenes);
    }

    public function eliminarImagen($id)
    {
        $img = OcupacionImagen::find($id);

        if ($img) {
            Storage::delete('public/'.$img->ruta);
            $img->delete();
        }

        $this->imagenesExistentes = OcupacionImagen::where('ocupacion_id', $this->ocupacion_id)->get();
    }

    // ================= GUARDAR =================
    public function guardarOcupacion()
    {
        $this->validate([
            'departamento_id' => 'required',
            'tipo' => 'required',
            'nombre' => 'required',
            'ci' => 'required',
            'fecha_inicio' => 'required',
        ]);

        // 🔥 BUSCAR O CREAR USER POR CI
        $user = User::where('ci', $this->ci)->first();

        if (! $user) {
            $user = new User();

            $user->name = $this->nombre;
            $user->ci = $this->ci;
            $user->edad = $this->edad;
            $user->telefono = $this->telefono;
            $user->rol = 'Cliente';
            $user->estado = 'Activo';

            $user->save();
        } else {
            // actualizar datos por si cambian
            $user->update([
                'name' => $this->nombre,
                'edad' => $this->edad,
                'telefono' => $this->telefono,
                'estado' => 'Activo',
            ]);
        }

        // 🔥 VALIDAR DUPLICADO (POR USER_ID + DEPTO)
        $existe = Ocupacion::where('tratamiento_id', $this->departamento_id)
            ->where('user_id', $user->id)
            ->where('estado', 'Activo')
            ->exists();

        if ($existe) {
            $this->emit('alert', 'Este usuario ya está registrado en este departamento');

            return;
        }

        // 🔥 SOLO 1 DUEÑO
        if ($this->tipo == 'dueno') {

            $existeDueno = Ocupacion::where('tratamiento_id', $this->departamento_id)
                ->where('tipo', 'dueno')
                ->where('estado', 'Activo')
                ->exists();

            if ($existeDueno) {
                $this->emit('alert', 'Ya existe un dueño principal en este departamento');

                return;
            }
        }

        // 🔥 CREAR OCUPACIÓN (CON USER_ID)
        $ocupacion = Ocupacion::create([
            'tratamiento_id' => $this->departamento_id,
            'user_id' => $user->id,
            'tipo' => $this->tipo,
            'parentesco' => $this->parentesco,
            'fecha_inicio' => $this->fecha_inicio,
            'estado' => 'Activo',
        ]);

        // 🔥 IMÁGENES
        if ($this->imagenes) {
            foreach ($this->imagenes as $img) {

                $path = $img->store('public/ocupantes');
                $path = 'ocupantes/'.basename($path);

                OcupacionImagen::create([
                    'ocupacion_id' => $ocupacion->id,
                    'ruta' => $path,
                ]);
            }
        }

        $this->resetCampos();
        $this->emit('render');
    }

    // ================= EDITAR =================
    public function editarOcupacion($id)
    {
        $o = Ocupacion::find($id);

        $this->ocupacion_id = $id;
        $this->editando = true;

        $this->departamento_id = $o->tratamiento_id;
        $this->tipo = $o->tipo;
        $this->parentesco = $o->parentesco;
        $this->fecha_inicio = $o->fecha_inicio;
        $this->estado = $o->estado;

        $this->imagenesExistentes = OcupacionImagen::where('ocupacion_id', $id)->get();

        $this->modalOcupacion = true;
    }

    // ================= ACTUALIZAR =================
    public function actualizarOcupacion()
    {
        $o = Ocupacion::find($this->ocupacion_id);

        if ($this->estado == 'Inactivo' && ! $o->fecha_fin) {
            $o->fecha_fin = now();
        }

        $o->update([
            'tipo' => $this->tipo,
            'parentesco' => $this->parentesco,
            'estado' => $this->estado,
        ]);

        // 🔥 USER INACTIVO
        if ($this->estado == 'Inactivo') {
            User::where('id', $o->user_id)->update(['estado' => 'Inactivo']);
        }

        // 🔥 NUEVAS IMÁGENES
        if ($this->imagenes) {
            foreach ($this->imagenes as $img) {

                $path = $img->store('public/ocupantes');
                $path = 'ocupantes/'.basename($path);

                OcupacionImagen::create([
                    'ocupacion_id' => $o->id,
                    'ruta' => $path,
                ]);
            }
        }

        $this->resetCampos();
        $this->emit('render');
    }

    // ================= RESET =================
    public function resetCampos()
    {
        $this->reset([
            'departamento_id', 'tipo', 'parentesco', 'nombre', 'ci',
            'edad', 'telefono', 'fecha_inicio', 'imagenes',
            'imagenesExistentes', 'ocupacion_id', 'editando',
        ]);

        $this->modalOcupacion = false;
    }

    public function toggleArea($tratamiento_id, $area_id)
    {
        $registro = TratamientoArea::where('tratamiento_id', $tratamiento_id)
            ->where('area_id', $area_id)
            ->first();

        if ($registro) {
            $registro->estado = $registro->estado == 'Activo' ? 'Inactivo' : 'Activo';
            $registro->save();
        } else {
            TratamientoArea::create([
                'tratamiento_id' => $tratamiento_id,
                'area_id' => $area_id,
                'estado' => 'Activo',
            ]);
        }

        $this->emit('render');
    }

    // ================= RENDER =================
    public function render()
    {
        $this->tratamientos = Tratamiento::where('nombre', 'LIKE', '%'.$this->busqueda.'%')
            ->orderBy('id', 'desc')
            ->get();

        $areas = Areas::where('estado', 'Activo')->get();

        // 🔥 cargar permisos actuales
        $permisosDB = TratamientoArea::where('estado', 'Activo')->get();

        $permisos = [];

        foreach ($permisosDB as $p) {
            $permisos[$p->tratamiento_id][$p->area_id] = true;
        }
        $this->ocupaciones = Ocupacion::select(
            'ocupacions.*',
            'users.name as nombre',
            'users.ci as ci',
            'users.edad as edad'
        )
            ->leftJoin('users', 'users.id', '=', 'ocupacions.user_id')
            ->orderBy('ocupacions.id', 'desc')
            ->get();

        return view('livewire.tratamientos.lista-tratamientos', compact('permisosDB','permisos','areas'));
    }
}

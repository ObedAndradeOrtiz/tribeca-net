<?php

namespace App\Http\Livewire\Tratamientos;

use App\Models\Ocupacion;
use App\Models\OcupacionImagen;
use App\Models\Tratamiento;
use App\Models\TratamientoArea;
use App\Models\Areas;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
    public $filtroAccesoArea = '';
    public $filtroEstadoDepartamento = 'Todos';
    public $filtroEstadoOcupacion = 'Todos';
    public $modalReporteDepartamento = false;
    public $reporteDepartamento = null;
    public $reporteTab = 'personas';
    public $reportePersonas = [];
    public $reporteUsoSalon = [];
    public $reporteUsoSalonResumen = [];
    public $reporteUsoSalonTotal = 0;

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

    public function verReporteDepartamento($tratamientoId)
    {
        $departamento = Tratamiento::find($tratamientoId);

        if (! $departamento) {
            $this->emit('alert', 'Departamento no encontrado');

            return;
        }

        $this->reporteDepartamento = [
            'id' => $departamento->id,
            'nombre' => $departamento->nombre,
        ];
        $this->reporteTab = 'personas';
        $this->reportePersonas = $this->personasDepartamento($departamento->id);
        $this->cargarUsoSalonDepartamento($departamento);
        $this->modalReporteDepartamento = true;
    }

    protected function personasDepartamento($tratamientoId): array
    {
        return Ocupacion::select(
            'ocupacions.*',
            'users.name as nombre',
            'users.ci as ci',
            'users.edad as edad',
            'users.telefono as telefono'
        )
            ->leftJoin('users', 'users.id', '=', 'ocupacions.user_id')
            ->where('ocupacions.tratamiento_id', $tratamientoId)
            ->orderBy('ocupacions.fecha_inicio', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'nombre' => $item->nombre ?: 'Sin nombre',
                    'ci' => $item->ci ?: '-',
                    'tipo' => $item->tipo ?: '-',
                    'parentesco' => $item->parentesco ?: '',
                    'fecha_inicio' => $item->fecha_inicio,
                    'fecha_fin' => $item->fecha_fin,
                    'estado' => $item->estado ?: '-',
                ];
            })
            ->toArray();
    }

    protected function cargarUsoSalonDepartamento(Tratamiento $departamento): void
    {
        $anioInicio = 2024;
        $anioActual = (int) now()->year;
        $patrones = $this->patronesDepartamento($departamento->nombre);

        $registros = DB::table('ingresos_bancarios as ib')
            ->leftJoin('ingresos_bancarios_aplicaciones as iba', function ($join) {
                $join->on('iba.ingreso_bancario_id', '=', 'ib.id')
                    ->where('iba.estado', '!=', 'Anulado');
            })
            ->select(
                'ib.id',
                'ib.fecha',
                'ib.anio',
                'ib.depositante',
                'ib.detalle',
                'ib.tipo_ingreso',
                'ib.monto',
                'ib.numero_comprobante',
                'ib.observacion',
                'iba.observacion as observacion_aplicacion',
                'iba.departamento_nombre',
                'iba.nombre_departamento',
                'iba.codigo_departamento'
            )
            ->whereRaw('COALESCE(ib.anio, YEAR(ib.fecha), YEAR(ib.created_at)) >= ?', [$anioInicio])
            ->where(function ($query) {
                $query->where('ib.tipo_ingreso', 'like', '%salon%')
                    ->orWhere('ib.tipo_ingreso', 'like', '%salón%')
                    ->orWhere('ib.detalle', 'like', '%SALON%')
                    ->orWhere('ib.detalle', 'like', '%SALÓN%')
                    ->orWhere('ib.observacion', 'like', '%SALON%')
                    ->orWhere('ib.observacion', 'like', '%SALÓN%')
                    ->orWhere('iba.observacion', 'like', '%SALON%')
                    ->orWhere('iba.observacion', 'like', '%SALÓN%');
            })
            ->where(function ($query) use ($patrones) {
                foreach ($patrones as $patron) {
                    $query->orWhere('ib.detalle', 'like', '%'.$patron.'%')
                        ->orWhere('ib.observacion', 'like', '%'.$patron.'%')
                        ->orWhere('ib.nombre_departamento', 'like', '%'.$patron.'%')
                        ->orWhere('ib.codigo_departamento', 'like', '%'.$patron.'%')
                        ->orWhere('iba.departamento_nombre', 'like', '%'.$patron.'%')
                        ->orWhere('iba.nombre_departamento', 'like', '%'.$patron.'%')
                        ->orWhere('iba.codigo_departamento', 'like', '%'.$patron.'%')
                        ->orWhere('iba.observacion', 'like', '%'.$patron.'%');
                }
            })
            ->orderBy('ib.fecha', 'desc')
            ->get()
            ->unique('id')
            ->values();

        $this->reporteUsoSalon = $registros->map(function ($item) {
            $anio = (int) ($item->anio ?: ($item->fecha ? date('Y', strtotime($item->fecha)) : now()->year));

            return [
                'id' => $item->id,
                'anio' => $anio,
                'fecha' => $item->fecha,
                'depositante' => $item->depositante ?: '-',
                'detalle' => $item->observacion_aplicacion ?: $item->observacion ?: $item->detalle ?: 'Uso de salon',
                'comprobante' => $item->numero_comprobante ?: '-',
                'monto' => (float) $item->monto,
            ];
        })->toArray();

        $resumen = [];
        for ($anio = $anioInicio; $anio <= $anioActual; $anio++) {
            $resumen[$anio] = 0;
        }

        foreach ($this->reporteUsoSalon as $uso) {
            if (isset($resumen[$uso['anio']])) {
                $resumen[$uso['anio']]++;
            }
        }

        $this->reporteUsoSalonResumen = $resumen;
        $this->reporteUsoSalonTotal = array_sum($resumen);
    }

    protected function patronesDepartamento($nombre): array
    {
        $nombre = trim((string) $nombre);
        $codigo = trim(preg_replace('/\s+/', ' ', preg_replace('/\b(DPTO|DEPTO|DEPARTAMENTO)\b/i', '', $nombre)));

        return array_values(array_unique(array_filter([
            $nombre,
            str_replace(' ', '', $nombre),
            $codigo,
            str_replace(' ', '', $codigo),
            'DPTO '.$codigo,
            'DEPTO '.$codigo,
            'DEPARTAMENTO '.$codigo,
        ])));
    }

    protected function areaIdPorNombre($texto)
    {
        return Areas::where('estado', 'Activo')
            ->where('area', 'like', '%'.$texto.'%')
            ->value('id');
    }

    // ================= RENDER =================
    public function render()
    {
        $areas = Areas::where('estado', 'Activo')->get();
        $areaPiscinaId = $this->areaIdPorNombre('PISCINA');
        $areaSalonId = $this->areaIdPorNombre('SALON') ?: $this->areaIdPorNombre('SALÓN');

        $queryTratamientos = Tratamiento::where('nombre', 'LIKE', '%'.$this->busqueda.'%');

        if ($this->filtroEstadoDepartamento === 'Activo') {
            $queryTratamientos->whereIn('estado', ['Activo', 'Ocupado']);
        } elseif ($this->filtroEstadoDepartamento !== 'Todos') {
            $queryTratamientos->where('estado', $this->filtroEstadoDepartamento);
        }

        if ($this->filtroAccesoArea === 'piscina' && $areaPiscinaId) {
            $queryTratamientos->whereExists(function ($query) use ($areaPiscinaId) {
                $query->select(DB::raw(1))
                    ->from('tratamiento_areas')
                    ->whereColumn('tratamiento_areas.tratamiento_id', 'tratamientos.id')
                    ->where('tratamiento_areas.area_id', $areaPiscinaId)
                    ->where('tratamiento_areas.estado', 'Activo');
            });
        }

        if ($this->filtroAccesoArea === 'salon' && $areaSalonId) {
            $queryTratamientos->whereExists(function ($query) use ($areaSalonId) {
                $query->select(DB::raw(1))
                    ->from('tratamiento_areas')
                    ->whereColumn('tratamiento_areas.tratamiento_id', 'tratamientos.id')
                    ->where('tratamiento_areas.area_id', $areaSalonId)
                    ->where('tratamiento_areas.estado', 'Activo');
            });
        }

        $this->tratamientos = $queryTratamientos
            ->orderBy('id', 'desc')
            ->get();

        // 🔥 cargar permisos actuales
        $permisosDB = TratamientoArea::where('estado', 'Activo')->get();

        $permisos = [];

        foreach ($permisosDB as $p) {
            $permisos[$p->tratamiento_id][$p->area_id] = true;
        }
        $queryOcupaciones = Ocupacion::select(
            'ocupacions.*',
            'users.name as nombre',
            'users.ci as ci',
            'users.edad as edad'
        )
            ->leftJoin('users', 'users.id', '=', 'ocupacions.user_id');

        if ($this->filtroEstadoOcupacion !== 'Todos') {
            $queryOcupaciones->where('ocupacions.estado', $this->filtroEstadoOcupacion);
        }

        $this->ocupaciones = $queryOcupaciones
            ->orderBy('ocupacions.id', 'desc')
            ->get();

        return view('livewire.tratamientos.lista-tratamientos', compact('permisosDB','permisos','areas', 'areaPiscinaId', 'areaSalonId'));
    }
}

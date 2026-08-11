<?php

namespace App\Http\Livewire\Residentes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class AdminResidentes extends Component
{
    public $nombre = '';

    public $ci = '';

    public $departamentos = [];

    public $codigoGenerado = '';

    public $mensaje = '';

    public $busquedaDepartamento = '';

    public function mount()
    {
        abort_unless(Auth::check() && Auth::user()->rol !== 'residente', 403);
    }

    public function crearCodigo()
    {
        $this->validate([
            'nombre' => ['nullable', 'string', 'max:255'],
            'ci' => ['nullable', 'string', 'max:255'],
            'departamentos' => ['required', 'array', 'min:1'],
        ]);

        $codigo = $this->generarCodigoUnico();

        $codigoId = DB::table('resident_access_codes')->insertGetId([
            'code' => $codigo,
            'name' => $this->nombre ?: null,
            'ci' => $this->ci ?: null,
            'status' => 'Activo',
            'created_by' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($this->departamentos as $tratamientoId) {
            $departamento = DB::table('tratamientos')->where('id', $tratamientoId)->first();

            if (! $departamento) {
                continue;
            }

            DB::table('resident_department_access')->insert([
                'access_code_id' => $codigoId,
                'tratamiento_id' => $departamento->id,
                'departamento_nombre' => $departamento->nombre,
                'status' => 'Aprobado',
                'requested_at' => now(),
                'approved_at' => now(),
                'approved_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->codigoGenerado = $codigo;
        $this->mensaje = 'Codigo creado correctamente.';
        $this->reset(['nombre', 'ci', 'departamentos']);
    }

    public function aprobar($accessId)
    {
        DB::table('resident_department_access')
            ->where('id', $accessId)
            ->update([
                'status' => 'Aprobado',
                'approved_at' => now(),
                'approved_by' => Auth::id(),
                'updated_at' => now(),
            ]);
    }

    public function rechazar($accessId)
    {
        DB::table('resident_department_access')
            ->where('id', $accessId)
            ->update([
                'status' => 'Rechazado',
                'updated_at' => now(),
            ]);
    }

    public function regenerarCodigo($codeId)
    {
        $codigo = $this->generarCodigoUnico();

        DB::table('resident_access_codes')
            ->where('id', $codeId)
            ->update([
                'code' => $codigo,
                'updated_at' => now(),
            ]);

        $this->codigoGenerado = $codigo;
        $this->mensaje = 'Codigo regenerado correctamente.';
    }

    public function desactivarCodigo($codeId)
    {
        DB::table('resident_access_codes')
            ->where('id', $codeId)
            ->update([
                'status' => 'Inactivo',
                'updated_at' => now(),
            ]);
    }

    protected function generarCodigoUnico()
    {
        do {
            $codigo = Str::upper(Str::random(4).'-'.Str::random(4));
        } while (DB::table('resident_access_codes')->where('code', $codigo)->exists());

        return $codigo;
    }

    public function getDepartamentosDisponiblesProperty()
    {
        return DB::table('tratamientos')
            ->when(trim($this->busquedaDepartamento) !== '', function ($q) {
                $busqueda = '%'.trim($this->busquedaDepartamento).'%';

                $q->where(function ($subquery) use ($busqueda) {
                    $subquery->where('nombre', 'like', $busqueda)
                        ->orWhere('TIPO', 'like', $busqueda);
                });
            })
            ->select('id', 'nombre', 'TIPO')
            ->orderBy('nombre')
            ->get();
    }

    public function getSolicitudesProperty()
    {
        return DB::table('resident_department_access as rda')
            ->leftJoin('users as u', 'u.id', '=', 'rda.user_id')
            ->where('rda.status', 'Solicitado')
            ->select('rda.*', 'u.name as user_name', 'u.email', 'u.ci')
            ->orderByDesc('rda.requested_at')
            ->get();
    }

    public function getCodigosProperty()
    {
        return DB::table('resident_access_codes as rac')
            ->leftJoin('users as u', 'u.id', '=', 'rac.user_id')
            ->select('rac.*', 'u.name as user_name')
            ->orderByDesc('rac.id')
            ->limit(30)
            ->get();
    }

    public function render()
    {
        return view('livewire.residentes.admin-residentes');
    }
}

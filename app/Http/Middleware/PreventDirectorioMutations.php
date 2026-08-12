<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PreventDirectorioMutations
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check() || strtoupper((string) Auth::user()->rol) !== 'DIRECTORIO') {
            return $next($request);
        }

        if ($request->routeIs('logout')) {
            return $next($request);
        }

        if (! $request->isMethodSafe() && ! $this->isLivewireRequest($request) && ! $request->routeIs('logout')) {
            abort(403, 'El rol DIRECTORIO solo tiene permisos de lectura.');
        }

        if ($this->isLivewireRequest($request)) {
            foreach ($this->calledMethods($request) as $method) {
                if ($this->isBlockedMethod($method)) {
                    abort(403, 'El rol DIRECTORIO solo tiene permisos de lectura.');
                }
            }
        }

        DB::beginTransaction();

        try {
            $response = $next($request);
        } finally {
            DB::rollBack();
        }

        return $response;
    }

    protected function isLivewireRequest(Request $request): bool
    {
        return $request->is('livewire/*')
            || $request->hasHeader('X-Livewire')
            || $request->has('fingerprint');
    }

    protected function calledMethods(Request $request): array
    {
        $updates = $request->input('updates', []);

        if (! is_array($updates)) {
            return [];
        }

        $methods = [];

        foreach ($updates as $update) {
            if (($update['type'] ?? null) !== 'callMethod') {
                continue;
            }

            $method = $update['payload']['method'] ?? null;

            if (is_string($method) && $method !== '') {
                $methods[] = $method;
            }
        }

        return $methods;
    }

    protected function isBlockedMethod(string $method): bool
    {
        $method = strtolower($method);

        $allowed = [
            'render',
            'gotoPage',
            'nextPage',
            'previousPage',
            'setPage',
            'ver',
            'verImagen',
            'cerrarImagen',
            'abrirReporteDeudas',
            'generarReporteDeudas',
            'descargarReporte',
            'descargarPlantillaIngresos',
            'descargarPdf',
            'descargarPDF',
            'exportar',
            'exportPdf',
            'imprimir',
        ];

        foreach ($allowed as $allowedMethod) {
            if ($method === strtolower($allowedMethod) || str_starts_with($method, strtolower($allowedMethod))) {
                return false;
            }
        }

        $blockedPrefixes = [
            'agregar',
            'anular',
            'aprobar',
            'asignar',
            'borrar',
            'cambiar',
            'confirmar',
            'crear',
            'dar',
            'desactivar',
            'dividir',
            'editar',
            'eliminar',
            'guardar',
            'importar',
            'marcar',
            'mover',
            'pagar',
            'quitar',
            'reactivar',
            'rechazar',
            'regenerar',
            'registrar',
            'solicitar',
            'subir',
            'update',
            'usar',
            'vender',
        ];

        foreach ($blockedPrefixes as $prefix) {
            if (str_starts_with($method, $prefix)) {
                return true;
            }
        }

        $blockedExact = [
            'abrircrear',
            'abrircrearexpensas',
            'abrireditar',
            'abririmportaringresos',
            'abrirmodaldividirpago',
            'abrirregularizar',
            'abrirnuevo',
            'cerrarcaja',
            'dividirrapidopago',
            'guardarregularizacion',
            'guardardivisionpago',
            'validarimportacioningresos',
        ];

        return in_array($method, $blockedExact, true);
    }
}

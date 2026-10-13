<?php
namespace App\Http\Controllers;

use App\Models\AsignacionGuardia;
use App\Models\Guardia;
use App\Models\Acceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AsignacionGuardiaController extends Controller
{
    // ==========================================
    // LISTAR ASIGNACIONES
    // ==========================================
    public function index()
    {
        $asignaciones = AsignacionGuardia::with([
            'guardia',
            'acceso'
        ])
        ->orderByDesc('id_asignacion_guardia')
        ->paginate(10);

        return view(
            'asignacion-guardia.index',
            compact('asignaciones')
        );
    }

    // ==========================================
    // FORMULARIO DE REGISTRO
    // ==========================================
    public function create()
    {
        $guardias = Guardia::where('estado', 1)
            ->orderBy('nombres')
            ->get();

        $accesos = Acceso::orderBy('id_acceso')
            ->get();

        return view(
            'asignacion-guardia.create',
            compact('guardias', 'accesos')
        );
    }

    // ==========================================
    // GUARDAR ASIGNACIÓN
    // ==========================================
    public function store(Request $request)
    {
        $datos = $request->validate([
            'id_guardia' => 'required|integer|exists:guardias,id_guardia',
            'id_acceso' => 'required|integer|exists:accesos,id_acceso',
            'fecha_inicio' => 'required|date'
        ]);

        DB::transaction(function () use ($datos) {

            // Bloquear al guardia durante la validación
            $guardia = Guardia::where(
                'id_guardia',
                $datos['id_guardia']
            )
            ->lockForUpdate()
            ->firstOrFail();

            // Verificar que el guardia esté activo
            if (!$guardia->estado) {
                throw ValidationException::withMessages([
                    'id_guardia' =>
                        'No se puede asignar un guardia inactivo.'
                ]);
            }

            // Verificar si ya tiene una asignación activa
            $asignacionActiva = AsignacionGuardia::where(
                'id_guardia',
                $datos['id_guardia']
            )
            ->where('estado', 1)
            ->exists();

            if ($asignacionActiva) {
                throw ValidationException::withMessages([
                    'id_guardia' =>
                        'Este guardia ya tiene una asignación activa.'
                ]);
            }

            // Registrar asignación
            AsignacionGuardia::create([
                'id_guardia' => $datos['id_guardia'],
                'id_acceso' => $datos['id_acceso'],
                'fecha_inicio' => $datos['fecha_inicio'],
                'fecha_fin' => null,
                'estado' => 1
            ]);
        });

        return redirect()
            ->route('asignacion-guardia.index')
            ->with(
                'success',
                'Guardia asignado correctamente al acceso.'
            );
    }

    // ==========================================
    // MOSTRAR DETALLES
    // ==========================================
    public function show($id)
    {
        $asignacion = AsignacionGuardia::with([
            'guardia',
            'acceso'
        ])
        ->findOrFail($id);

        return view(
            'asignacion-guardia.show',
            compact('asignacion')
        );
    }

    // ==========================================
    // FORMULARIO DE EDICIÓN
    // ==========================================
    public function edit($id)
    {
        $asignacion = AsignacionGuardia::findOrFail($id);

        // No permitir editar asignaciones finalizadas
        if (!$asignacion->estado) {
            return redirect()
                ->route('asignacion-guardia.index')
                ->with(
                    'error',
                    'No se puede editar una asignación finalizada.'
                );
        }

        $guardias = Guardia::where('estado', 1)
            ->orWhere(
                'id_guardia',
                $asignacion->id_guardia
            )
            ->orderBy('nombres')
            ->get();

        $accesos = Acceso::orderBy('id_acceso')
            ->get();

        return view(
            'asignacion-guardia.edit',
            compact(
                'asignacion',
                'guardias',
                'accesos'
            )
        );
    }

    // ==========================================
    // ACTUALIZAR ASIGNACIÓN
    // ==========================================
    public function update(Request $request, $id)
    {
        $datos = $request->validate([
            'id_guardia' => 'required|integer|exists:guardias,id_guardia',
            'id_acceso' => 'required|integer|exists:accesos,id_acceso',
            'fecha_inicio' => 'required|date'
        ]);

        DB::transaction(function () use ($id, $datos) {

            // Bloquear guardias involucrados para evitar
            // asignaciones simultáneas al mismo guardia.
            $asignacionActual = AsignacionGuardia::findOrFail($id);

            $idsGuardias = array_unique([
                (int) $asignacionActual->id_guardia,
                (int) $datos['id_guardia']
            ]);

            sort($idsGuardias);

            Guardia::whereIn('id_guardia', $idsGuardias)
                ->orderBy('id_guardia')
                ->lockForUpdate()
                ->get();

            $asignacion = AsignacionGuardia::where(
                'id_asignacion_guardia',
                $id
            )
            ->lockForUpdate()
            ->firstOrFail();

            if (!$asignacion->estado) {
                throw ValidationException::withMessages([
                    'asignacion' =>
                        'No se puede editar una asignación finalizada.'
                ]);
            }

            // Verificar el estado del nuevo guardia
            $guardia = Guardia::findOrFail(
                $datos['id_guardia']
            );

            if (!$guardia->estado) {
                throw ValidationException::withMessages([
                    'id_guardia' =>
                        'No se puede asignar un guardia inactivo.'
                ]);
            }

            // Verificar que no tenga otra asignación activa
            $otraAsignacion = AsignacionGuardia::where(
                'id_guardia',
                $datos['id_guardia']
            )
            ->where('estado', 1)
            ->where(
                'id_asignacion_guardia',
                '!=',
                $id
            )
            ->exists();

            if ($otraAsignacion) {
                throw ValidationException::withMessages([
                    'id_guardia' =>
                        'El guardia seleccionado ya tiene otra asignación activa.'
                ]);
            }

            // Actualizar información
            $asignacion->update([
                'id_guardia' => $datos['id_guardia'],
                'id_acceso' => $datos['id_acceso'],
                'fecha_inicio' => $datos['fecha_inicio']
            ]);
        });

        return redirect()
            ->route('asignacion-guardia.index')
            ->with(
                'success',
                'Asignación de guardia actualizada correctamente.'
            );
    }

    // ==========================================
    // FINALIZAR ASIGNACIÓN
    // ==========================================
    public function finalizar($id)
    {
        DB::transaction(function () use ($id) {

            $asignacion = AsignacionGuardia::where(
                'id_asignacion_guardia',
                $id
            )
            ->lockForUpdate()
            ->firstOrFail();

            // Comprobar que siga activa
            if (!$asignacion->estado) {
                throw ValidationException::withMessages([
                    'asignacion' =>
                        'Esta asignación ya se encuentra finalizada.'
                ]);
            }

            // Evitar finalizar antes de la fecha de inicio
            if ($asignacion->fecha_inicio->gt(
                now()->startOfDay()
            )) {
                throw ValidationException::withMessages([
                    'asignacion' =>
                        'No se puede finalizar una asignación con fecha de inicio futura.'
                ]);
            }

            // Finalizar y conservar historial
            $asignacion->update([
                'fecha_fin' => now()->toDateString(),
                'estado' => 0
            ]);
        });

        return redirect()
            ->route('asignacion-guardia.index')
            ->with(
                'success',
                'Asignación de guardia finalizada correctamente.'
            );
    }

    // ==========================================
    // ELIMINAR ASIGNACIÓN
    // ==========================================
    public function destroy($id)
    {
        $asignacion = AsignacionGuardia::findOrFail($id);

        // Evitar eliminar asignaciones activas
        if ($asignacion->estado) {
            return redirect()
                ->route('asignacion-guardia.index')
                ->with(
                    'error',
                    'Primero debe finalizar la asignación antes de eliminarla.'
                );
        }

        $asignacion->delete();

        return redirect()
            ->route('asignacion-guardia.index')
            ->with(
                'success',
                'Asignación de guardia eliminada correctamente.'
            );
    }
}

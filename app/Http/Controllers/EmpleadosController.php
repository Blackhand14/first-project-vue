<?php

namespace App\Http\Controllers;

use App\Models\Empleados;
use Illuminate\Http\Request;
use App\Models\Departamentos;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class EmpleadosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = Empleados::select('empleados.id', 'empleados.nombre', 'correo', 'telefono', 'departamento_id', 'departamentos.nombre as departamento')
            ->join('departamentos', 'departamentos.id', '=', 'empleados.departamento_id')
            ->paginate(10);

        $departamentos = Departamentos::all();
        return Inertia::render('Empleados/Index', ['empleados' => $empleados, 'departamentos' => $departamentos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:150',
            'correo' => 'required|max:80',
            'telefono' => 'required|max:10',
            'departmaneto_id' => 'required|numeric',
        ]);

        $empleado = new Empleados($request->input());
        $empleado->save();
        return redirect('empleados');
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleados $empleados)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empleados $empleados)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empleados $empleados)
    {
        $request->validate([
            'nombre' => 'required|max:150',
            'correo' => 'required|max:80',
            'telefono' => 'required|max:10',
            'departmaneto_id' => 'required|numeric',
        ]);

        $empleados->update($request->input());
        return redirect('empleados');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empleados $empleados)
    {
        $empleados->delete();
        return redirect('empleados');
    }

    public function EmpleadoporDepartamento()
    {
        $datos = Empleados::select(DB::raw('count(empleados.id as count, departamentos.name'))
            ->join('departamentos', 'departamentos.id', '=', 'empleados.departamento_id')
            ->groupBy('departamentos.name')->get();

        return Inertia::render('Empelados/Grafica', ['datos' => $datos]);
    }

    public function reportes()
    {
        $empleados = Empleados::select('empleados.id', 'empleados.nombre', 'correo', 'telefono', 'departamento_id', 'departamentos.nombre as departamento')
            ->join('departamentos', 'departamentos.id', '=', 'empleados.departamento_id')
            ->get();

        $departamentos = Departamentos::all();
        return Inertia::render('Empleados/Reportes', ['empleados' => $empleados, 'departamentos' => $departamentos]);
    }
}

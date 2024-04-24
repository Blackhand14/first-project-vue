<?php

namespace App\Http\Controllers;

use App\Models\Departamentos;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepartamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departamentos = Departamentos::all();
        return Inertia::render('Departamentos/Index', ['departamentos' => $departamentos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Departamentos/Crear');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|max:100']);

        $departamento = new Departamentos($request->input());
        $departamento->save();
        return redirect('departamentos');
    }

    /**
     * Display the specified resource.
     */
    public function show(Departamentos $departamentos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $departamentos = Departamentos::findOrFail($id);
        return Inertia::render('Departamentos/Editar', ['departamentos' => $departamentos]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate(['nombre' => 'required|max:100']);

        $departamentos = Departamentos::findOrFail($id);
        $departamentos->update($request->all());
        return redirect('departamentos');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $departamentos = Departamentos::findOrFail($id);
        $departamentos->delete();
        return redirect('departamentos');
    }
}

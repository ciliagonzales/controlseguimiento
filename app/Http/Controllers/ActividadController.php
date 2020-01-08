<?php

namespace App\Http\Controllers;

use App\actividad;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actividades = \DB::select("SELECT  a.ID as ID,o.NombreOficina as oficina,ob.Descripcion as objetivo,p.Descripcion as proceso,a.Descripcion as actividad 
        FROM actividades a JOIN oficinas o ON a.IDOficina = o.IDOficina 
        JOIN objetivos ob ON a.IDObjetivo = ob.ID JOIN procestrategicos p ON a.IDProceso = p.ID");
        return compact('actividades');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $actividad = new Actividad();
        $actividad->IDOficina       = $request->actividad['oficina'];
        $actividad->IDObjetivo      = $request->actividad['objetivo']; 
        $actividad->IDProceso       = $request->actividad['proceso']; 
        $actividad->Descripcion     = $request->actividad['actividad'];
        $actividad->save();
        return  "bien";

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $actividades = \DB::select("SELECT ID,Descripcion as Actividad FROM actividades WHERE IDProceso = $id");
        return compact('actividades');
    }
    public function showActividad($id)
    {
        $actividades = Actividad::where('ID',$id)->get();
        $actividad = $actividades[0]['Descripcion'];
        return compact('actividad');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function edit(actividad $actividad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function update($id,$des)
    {
        Actividad::where('ID',$id)->update(['Descripcion' => $des]);
        return "OK";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $eliminar   =   Actividad::where('ID',$id)->delete();
        if($eliminar){
            return "OK";
        }else{
            return "FAIL";
        }
    }
}

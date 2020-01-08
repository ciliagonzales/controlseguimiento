<?php

namespace App\Http\Controllers;

use App\subactividades;
use Illuminate\Http\Request;

class SubactividadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subactividades = \DB::select("SELECT s.ID,o.NombreOficina as oficina,ob.Descripcion as objetivo, 
        p.Descripcion as proceso, a.Descripcion as actividad,
        s.SubActividad as subactividad FROM subactividades s 
        JOIN oficinas o ON s.IDOficina = o.IDOficina 
        JOIN objetivos ob ON s.IDObjetivo = ob.ID 
        JOIN procestrategicos p ON s.IDProceso = p.ID 
        JOIN actividades a ON s.IDActividad = a.ID");
        return compact('subactividades');
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
        $subactividades = new Subactividades();
        $subactividades->IDOficina      = $request->subactividad['oficina'];
        $subactividades->IDObjetivo     = $request->subactividad['objetivo'];
        $subactividades->IDProceso      = $request->subactividad['proceso'];
        $subactividades->IDActividad    = $request->subactividad['actividad'];
        $subactividades->SubActividad   = $request->subactividad['subactividad'];
        $subactividades->Meta           = $request->subactividad['meta'];
        $subactividades->UnidadMedida   = $request->subactividad['unidad'];
        $subactividades->IDEncargado    = $request->subactividad['responsable'];
        $subactividades->Trimestre1     = $request->subactividad['triuno'];
        $subactividades->Trimestre2     = $request->subactividad['tridos'];
        $subactividades->Trimestre3     = $request->subactividad['tritres'];
        $subactividades->Trimestre4     = $request->subactividad['tricuatro'];
        $subactividades->save();
        return "bien";

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\subactividades  $subactividades
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $Subactividad = array();
        $subactividad = Subactividades::select('ID','SubActividad','Meta')->where('IDActividad',$id)->get();
        return compact('subactividad');
    }
    public function showSubActividad($id)
    {
        $subactividades = Subactividades::where('ID',$id)->get();
        $subactividad = $subactividades[0]['SubActividad'];
        return compact('subactividad');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\subactividades  $subactividades
     * @return \Illuminate\Http\Response
     */
    public function edit(subactividades $subactividades)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\subactividades  $subactividades
     * @return \Illuminate\Http\Response
     */
    public function update($id,$des)
    {
        Subactividades::where('ID',$id)->update(['SubActividad' => $des]);
        return "OK";;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\subactividades  $subactividades
     * @return \Illuminate\Http\Response
     */
    public function destroy(subactividades $subactividades)
    {
        //
    }
    public function ejecucion()
    {
        $monto1 = 0;
        $monto2 = 0;
        $monto3 = 0;
        $monto4 = 0;
        // $avance = \DB::select("SELECT s.ID, o.NombreOficina,s.SubActividad,e.monto FROM entregable e JOIN oficinas o ON e.IDOficina = o.IDOficina JOIN subactividades s ON e.IDSubactividad=s.ID WHERE e.trimestre = 1");
        $anual  = \DB::select("SELECT s.ID, o.NombreOficina,s.SubActividad,s.Trimestre1,s.Trimestre2,s.Trimestre3,s.Trimestre4 FROM subactividades s JOIN oficinas o ON s.IDOficina = o.IDOficina");
        $avances = array();
        foreach ($anual as $key) {
            $subs1 = \DB::select("SELECT e.monto FROM entregable e WHERE e.trimestre = 1 AND e.IDSubactividad=$key->ID");
            $subs2 = \DB::select("SELECT e.monto FROM entregable e WHERE e.trimestre = 2 AND e.IDSubactividad=$key->ID");
            $subs3 = \DB::select("SELECT e.monto FROM entregable e WHERE e.trimestre = 3 AND e.IDSubactividad=$key->ID");
            $subs4 = \DB::select("SELECT e.monto FROM entregable e WHERE e.trimestre = 4 AND e.IDSubactividad=$key->ID");
            if(count($subs1) > 0)
            {
                $monto1 = $subs1[0]->monto;            
            }else{
                $monto1 = 0;
            }
            if(count($subs2) > 0)
            {
                $monto2 = $subs2[0]->monto;            
            }else{
                $monto2 = 0;
            }
            if(count($subs3) > 0)
            {
                $monto3 = $subs3[0]->monto;            
            }else{
                $monto3 = 0;
            }
            if(count($subs4) > 0)
            {
                $monto4 = $subs4[0]->monto;            
            }else{
                $monto4 = 0;
            }
            array_push($avances,array('ID' => $key->ID,'NombreOficina'=>$key->NombreOficina,'SubActividad'=>$key->SubActividad,'monto1'=>$monto1,'monto2'=>$monto2,'monto3'=>$monto3,'monto4'=>$monto4));

        }
        return compact('avances','anual');
    }
}

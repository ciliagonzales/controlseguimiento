<?php

namespace App\Http\Controllers;

use App\procestrategicos;
use Illuminate\Http\Request;

class ProcestrategicosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $procesos   = \DB::select("SELECT p.ID as ID, o.NombreOficina as oficina,
        ob.Descripcion as objetivo, p.Descripcion as proceso FROM procestrategicos p 
        JOIN oficinas o on p.IDOficina=o.IDOficina
        JOIN objetivos ob ON p.IDObjetivo = ob.ID");

        return compact('procesos');
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
        $procesos   = new Procestrategicos();
        $procesos->IDOficina   = $request->procesoz['oficina'];
        $procesos->IDObjetivo  = $request->procesoz['objetivo'];
        $procesos->Descripcion = $request->procesoz['zproceso'];
        $procesos->save();
        return "ok";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\procestrategicos  $procestrategicos
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $procesos = Procestrategicos::all()->where("IDObjetivo",$id);
        return compact('procesos');
    }
    public function showProceso($id)
    {
        $procesos = Procestrategicos::all()->where("ID",$id);
        return compact('procesos');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\procestrategicos  $procestrategicos
     * @return \Illuminate\Http\Response
     */
    public function edit(procestrategicos $procestrategicos)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\procestrategicos  $procestrategicos
     * @return \Illuminate\Http\Response
     */
    public function update($id,$des)
    {
        Procestrategicos::where('ID',$id)->update(['Descripcion' => $des]);
        return "OK";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\procestrategicos  $procestrategicos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $eliminar   =   Procestrategicos::where('ID',$id)->delete();
        if($eliminar){
            return "OK";
        }else{
            return "FAIL";
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\objetivos;
use Illuminate\Http\Request;

class ObjetivosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $objetivos = Objetivos::all()->where("IDOficina",$id);
        return compact('objetivos');
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
        $objetivos = new Objetivos();
        $objetivos->IDOficina   = $request->objetivo['oficina'];
        $objetivos->Descripcion = ucwords($request->objetivo['objetivo']);
        $objetivos->save();
        return "success";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\objetivos  $objetivos
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $objetivos = \DB::select("SELECT o.ID as ID, of.NombreOficina as oficina, o.Descripcion as objetivo 
        FROM objetivos o
        JOIN oficinas of 
        ON o.IDOficina = of.IDOficina");
        return compact('objetivos');
    }
    public function showObjetivo($id)
    {
        $objetivos = Objetivos::where("ID",$id)->get();
        $des = $objetivos[0]['Descripcion'];
        return compact('des');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\objetivos  $objetivos
     * @return \Illuminate\Http\Response
     */
    public function edit(objetivos $objetivos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\objetivos  $objetivos
     * @return \Illuminate\Http\Response
     */
    public function update($id,$des)
    {
        Objetivos::where('ID',$id)->update(['Descripcion' => $des]);
        return "OK";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\objetivos  $objetivos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $eliminar   =   Objetivos::where('ID',$id)->delete();
        if($eliminar){
            return "OK";
        }else{
            return "FAIL";
        }
    }
}

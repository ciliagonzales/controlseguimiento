<?php

namespace App\Http\Controllers;

use App\oficinas;
use App\User;
use App\encargadoOficina;
use Illuminate\Http\Request;

class OficinasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->tipo == 1){
            $oficinas = Oficinas::all();
        }else{
            $user = \Auth::user()->user;
            $objencargado = \DB::select("select * from encargadooficina where user = '$user'");
            $IDOficina = $objencargado[0]->IDOficina;
            $oficinas = Oficinas::where("IDOficina","=",$IDOficina)->get();
        }
        $montos = array();
        foreach ($oficinas as $key) {
            // $monto  = \DB::select("SELECT o.NombreOficina, IFNULL(SUM(e.monto),0) as monto 
            // FROM oficinas o 
            // LEFT JOIN entregable e ON e.IDOficina = o.IDOficina
            // WHERE e.IDOficina = $key->IDOficina
            // GROUP BY o.IDOFICINA ORDER BY o.IDOFICINA ASC");
            // $monto = \DB::select("SELECT o.NombreOficina, 
            // IFNULL(ROUND((SUM(e.monto) / SUM(s.Meta))*100,2),0) as monto FROM oficinas o 
            // LEFT JOIN entregable e ON e.IDOficina = o.IDOficina 
            // JOIN subactividades s ON o.IDOficina = s.IDOficina WHERE e.IDOficina = $key->IDOficina");
            // $monto = \DB::select("SELECT o.NombreOficina, IFNULL(ROUND((SUM(e.monto) / SUM(s.Meta))*100,2),0) as monto 
            // FROM oficinas o LEFT JOIN entregable e ON e.IDOficina = o.IDOficina 
            // JOIN subactividades s ON e.IDEntregable = s.ID WHERE e.IDOficina = $key->IDOficina");
            // print_r($monto);
            $monto = \DB::select("SELECT ROUND((SELECT SUM(e.monto) FROM entregable e WHERE e.IDOficina = $key->IDOficina)/(SELECT IFNULL(SUM(s.meta),1) FROM subactividades s WHERE IDOficina = $key->IDOficina)*100,2) as 'percent'");
            if(count($monto) == 0)
            {
                array_push($montos,0);
            }else{
                array_push($montos,$monto[0]->percent);
            } 
        }
        return compact('oficinas','montos');
    }
    /*
    |avance trimestral agrupadas por oficinas
    |
    |
    
    */
    public function avanceTrimestral($t)
    {
        $oficinas = Oficinas::all();
        $montos = array();
        foreach ($oficinas as $key) {
            // $monto  = \DB::select("SELECT o.NombreOficina, IFNULL(SUM(e.monto),0) as monto 
            // FROM oficinas o 
            // LEFT JOIN entregable e ON e.IDOficina = o.IDOficina
            // WHERE e.IDOficina = $key->IDOficina and e.trimestre = $t
            // GROUP BY o.IDOFICINA ORDER BY o.IDOFICINA ASC");
            $monto = \DB::select("SELECT o.NombreOficina, 
            IFNULL(ROUND((SUM(e.monto) / SUM(s.Meta))*100,2),0) as monto FROM oficinas o 
            LEFT JOIN entregable e ON e.IDOficina = o.IDOficina 
            JOIN subactividades s ON o.IDOficina = s.IDOficina WHERE e.IDOficina = $key->IDOficina 
            GROUP BY o.IDOFICINA ORDER BY o.IDOFICINA ASC");
            if(count($monto) == 0)
            {
                array_push($montos,0);
            }else{
                array_push($montos,(int)$monto[0]->monto);
            } 
        }
        return compact('montos');
    }
    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    public function create($id)
    {
        $encargado  = Encargadooficina::where('ID',$id)->get();
        $nombre     = $encargado[0]['Encargado'];
        return compact('nombre');
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    public function store(Request $request)
    {
        $oficina = new Oficinas();
        $oficina->NombreOficina = $request->oficina['nombre'];
        $oficina->save();
        return "ok";
    }
    public function storeEncargado(Request $request)
    {
        $encargado = new Encargadooficina();
        $encargado->Encargado = ucwords($request->encargado['nombre']);
        $encargado->IDOficina = $request->encargado['oficina'];
        $encargado->user = $request->encargado['user'];
        $user = new User();
        // $user->id = strtolower($request->encargado['user']);
        $user->user = strtolower($request->encargado['user']);
        $user->password = bcrypt("Inicio01");
        $user->tipo = 2;
        $user->save();
        $encargado->save();
        return "ok";
    }
    public function showEncargado($id)
    {
        $encargados = \DB::select("SELECT ID,Encargado FROM encargadooficina where IDOficina = $id");
        return compact('encargados');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\oficinas  $oficinas
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $oficinas = \DB::select("SELECT e.ID as ID, o.NombreOficina as oficina,
         e.Encargado as encargado FROM encargadooficina e 
         JOIN oficinas o ON e.IDOficina = o.IDOficina");
        return compact('oficinas');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\oficinas  $oficinas
     * @return \Illuminate\Http\Response
     */
    public function edit(oficinas $oficinas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\oficinas  $oficinas
     * @return \Illuminate\Http\Response
     */
    public function update($id,$des)
    {
        Encargadooficina::where('ID',$id)->update(['Encargado' => $des]);
        return "ok";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\oficinas  $oficinas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $eliminar = encargadoOficina::where('ID',$id)->delete();
        if($eliminar){
            return "OK";
        }else{
            return "FAIL";
        }
        
    }
}

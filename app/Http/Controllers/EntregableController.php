<?php

namespace App\Http\Controllers;

use App\entregable;
use Illuminate\Http\Request;

class EntregableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipo = \Auth::user()->tipo;
        $user = \Auth::user()->user;
        $pass = \Auth::user()->password;
        $objOficina = \DB::select("select IDOficina from encargadooficina where user = '$user'");
        
            
        if($tipo == 1)
        {
            $entregables = \DB::select("SELECT of.NombreOficina as oficina, o.Descripcion as objetivo, 
            p.Descripcion as proceso, e.IDEntregable as ID, a.Descripcion as actividad,
            s.SubActividad as subactividad,e.archivo as archivo,e.monto as monto,
            e.trimestre as trimestre,e.nombreArchivo as nombreArchivo, 
            date_format(e.created_at, '%d-%m-%Y') as fecha 
            FROM entregable e 
            JOIN subactividades s on e.IDSubactividad = s.ID 
            JOIN procestrategicos p ON s.IDProceso = p.ID 
            JOIN objetivos o ON p.IDObjetivo = o.ID 
            JOIN oficinas of ON o.IDOficina = of.IDOficina 
            JOIN actividades a ON s.IDActividad = a.ID");
        }else if($tipo == 2){
            $IDOficina = $objOficina[0]->IDOficina;
            $entregables = \DB::select("SELECT of.NombreOficina as oficina, o.Descripcion as objetivo, 
            p.Descripcion as proceso, e.IDEntregable as ID, a.Descripcion as actividad,
            s.SubActividad as subactividad,e.archivo as archivo,e.monto as monto,
            e.trimestre as trimestre,e.nombreArchivo as nombreArchivo, 
            date_format(e.created_at, '%d-%m-%Y') as fecha 
            FROM entregable e 
            JOIN subactividades s on e.IDSubactividad = s.ID 
            JOIN procestrategicos p ON s.IDProceso = p.ID 
            JOIN objetivos o ON p.IDObjetivo = o.ID 
            JOIN oficinas of ON o.IDOficina = of.IDOficina 
            JOIN actividades a ON s.IDActividad = a.ID
            WHERE e.IDOficina = $IDOficina");
        }
        
         return compact('entregables');
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
		$exploded       =   explode(',',$request->subactividad['archivo']);
        $decoded        =   base64_decode($exploded[1]);
        $ext            =   "";
        if(str_contains($exploded[0],'jpeg'))
        {
            $ext = 'jpg';
        }
        else if(str_contains($exploded[0],'png'))
        {
            $ext = 'png';
        }
        else if(str_contains($exploded[0],'pdf'))
        {
            $ext = 'pdf';
        }
        else if(str_contains($exploded[0],'spreadsheetml'))
        {
            $ext = 'xlsx';
        }
        else if(str_contains($exploded[0],'wordprocessingml'))
        {
            $ext = 'docx';
        }else if (str_contains($exploded[0],'presentationml')) {
            $ext = 'pptx';
        }
        $fileName       =   str_random().'.'.$ext;
        $path           =   public_path().'/archivos/'.$fileName;
        file_put_contents($path,$decoded);
        if($ext != "")
        {
            $entregable = new Entregable();
            $entregable->IDOficina      = $request->subactividad['oficina'];
            $entregable->IDSubactividad = $request->subactividad['ID'];
            $entregable->monto          = $request->subactividad['monto'];
            $entregable->trimestre      = $request->subactividad['trimestre'];
            $entregable->archivo        = $fileName;
            $entregable->nombreArchivo  = $request->subactividad['nombre'];
            $entregable->save();
            $mensaje = "Entregable cargado de manera exitosa";
        } else{
            $mensaje = "no ingreso un archivo válido";
        }
        
        return $mensaje;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\entregable  $entregable
     * @return \Illuminate\Http\Response
     */
    public function show($o,$t)
    {
        if($t == 1)
        {
            $metasTrimestrales = \DB::select("SELECT 
            o.NombreOficina,ob.Descripcion as objetivos, pe.Descripcion as proceso, a.Descripcion as actividad,
            e.IDEntregable as id,SUM(e.monto) as monto,s.SubActividad, s.Meta as Meta, 
            ROUND((SUM(e.monto) / (s.Trimestre1))*100,2) as percent,s.Trimestre1 as trimestral, 
            ROUND((SUM(e.monto) / s.Meta)*100,2) as anual, s.UnidadMedida as unidad 
            FROM entregable e 
            JOIN subactividades s ON e.IDSubactividad = s.ID
            JOIN actividades a ON s.IDActividad = a.ID
            JOIN procestrategicos pe ON s.IDProceso = pe.ID
            JOIN objetivos ob ON s.IDObjetivo = ob.ID
            JOIN oficinas o ON o.IDOficina = e.IDOficina 
            WHERE s.IDOficina = $o AND (e.trimestre = $t) 
            AND YEAR(s.created_at) = YEAR(curdate()) GROUP BY e.IDSubactividad");

            $series = \DB::select("SELECT SUM(e.monto) as monto, s.Trimestre".$t." as Meta 
            FROM entregable e JOIN subactividades s ON e.IDSubactividad = s.ID 
            WHERE s.IDOficina = $o AND (e.trimestre = $t) 
            AND YEAR(s.created_at) = YEAR(curdate()) 
            GROUP BY e.IDSubactividad");

        }else if($t == 2){
            $metasTrimestrales = \DB::select("SELECT 
            o.NombreOficina,ob.Descripcion as objetivos, pe.Descripcion as proceso, a.Descripcion as actividad,
            e.IDEntregable as id,SUM(e.monto) as monto,s.SubActividad, s.Meta as Meta, 
            ROUND((SUM(e.monto) / (s.Trimestre2))*100,2) as percent,s.Trimestre2 as trimestral, 
            ROUND((SUM(e.monto) / s.Meta)*100,2) as anual, s.UnidadMedida as unidad 
            FROM entregable e 
            JOIN subactividades s ON e.IDSubactividad = s.ID
            JOIN actividades a ON s.IDActividad = a.ID
            JOIN procestrategicos pe ON s.IDProceso = pe.ID
            JOIN objetivos ob ON s.IDObjetivo = ob.ID
            JOIN oficinas o ON o.IDOficina = e.IDOficina 
            WHERE s.IDOficina = $o AND (e.trimestre = $t) 
            AND YEAR(s.created_at) = YEAR(curdate()) GROUP BY e.IDSubactividad");

            $series = \DB::select("SELECT SUM(e.monto) as monto, s.Trimestre".$t." as Meta 
            FROM entregable e JOIN subactividades s ON e.IDSubactividad = s.ID 
            WHERE s.IDOficina = $o AND (e.trimestre = $t) 
            AND YEAR(s.created_at) = YEAR(curdate()) 
            GROUP BY e.IDSubactividad");

        }else if($t == 3){
            $metasTrimestrales = \DB::select("SELECT 
            o.NombreOficina,ob.Descripcion as objetivos, pe.Descripcion as proceso, a.Descripcion as actividad,
            e.IDEntregable as id,SUM(e.monto) as monto,s.SubActividad, s.Meta as Meta, 
            ROUND((SUM(e.monto) / (s.Trimestre3))*100,2) as percent,s.Trimestre3 as trimestral, 
            ROUND((SUM(e.monto) / s.Meta)*100,2) as anual, s.UnidadMedida as unidad 
            FROM entregable e 
            JOIN subactividades s ON e.IDSubactividad = s.ID
            JOIN actividades a ON s.IDActividad = a.ID
            JOIN procestrategicos pe ON s.IDProceso = pe.ID
            JOIN objetivos ob ON s.IDObjetivo = ob.ID
            JOIN oficinas o ON o.IDOficina = e.IDOficina 
            WHERE s.IDOficina = $o AND (e.trimestre =$t) 
            AND YEAR(s.created_at) = YEAR(curdate()) GROUP BY e.IDSubactividad");

            $series = \DB::select("SELECT SUM(e.monto) as monto, s.Trimestre".$t." as Meta 
            FROM entregable e JOIN subactividades s ON e.IDSubactividad = s.ID 
            WHERE s.IDOficina = $o AND (e.trimestre = $t) 
            AND YEAR(s.created_at) = YEAR(curdate()) 
            GROUP BY e.IDSubactividad");
            
        }else if($t == 4){
            $metasTrimestrales = \DB::select("SELECT 
            o.NombreOficina,ob.Descripcion as objetivos, pe.Descripcion as proceso, a.Descripcion as actividad,
            e.IDEntregable as id,SUM(e.monto) as monto,s.SubActividad, s.Meta as Meta, 
            ROUND((SUM(e.monto) / (s.Trimestre4))*100,2) as percent,s.Trimestre4 as trimestral, 
            ROUND((SUM(e.monto) / s.Meta)*100,2) as anual, s.UnidadMedida as unidad 
            FROM entregable e 
            JOIN subactividades s ON e.IDSubactividad = s.ID
            JOIN actividades a ON s.IDActividad = a.ID
            JOIN procestrategicos pe ON s.IDProceso = pe.ID
            JOIN objetivos ob ON s.IDObjetivo = ob.ID
            JOIN oficinas o ON o.IDOficina = e.IDOficina 
            WHERE s.IDOficina = $o AND (e.trimestre =$t) 
            AND YEAR(s.created_at) = YEAR(curdate()) GROUP BY e.IDSubactividad");
            
            $series = \DB::select("SELECT SUM(e.monto) as monto, s.Trimestre".$t." as Meta 
            FROM entregable e JOIN subactividades s ON e.IDSubactividad = s.ID 
            WHERE s.IDOficina = $o AND (e.trimestre = $t) 
            AND YEAR(s.created_at) = YEAR(curdate()) 
            GROUP BY e.IDSubactividad");
        }
        
        
        $var = array();
        $avance = 0;
        $meta = 0;
        // array_push($var,(int)$series[0]->monto,(int)$series[0]->Meta);
        foreach ($series as $key) {
            $avance += (int)$key->monto;
            $meta   += (int)$key->Meta;
        }
        array_push($var,$avance,($meta-$avance));
        return compact("metasTrimestrales","var");
    }

    public function avances($o,$t)
    {
        if($t == 1)
        {
            $metasTrimestrales = \DB::select("SELECT 
            o.NombreOficina,ob.Descripcion as objetivos, pe.Descripcion as proceso, a.Descripcion as actividad,
            e.IDEntregable as id,e.monto,s.SubActividad, s.Meta as Meta, 
            ROUND((s.Trimestre1 / s.Meta)*100,2) as esperado,
            ROUND((e.monto / s.Trimestre1)*100,2) as percent,
            ROUND((e.monto / s.Meta)*100,2) as anual,
            s.UnidadMedida as unidad 
            FROM entregable e 
            JOIN subactividades s ON e.IDSubactividad = s.ID
            JOIN actividades a ON s.IDActividad = a.ID
            JOIN procestrategicos pe ON s.IDProceso = pe.ID
            JOIN objetivos ob ON s.IDObjetivo = ob.ID
            JOIN oficinas o ON o.IDOficina = e.IDOficina 
            WHERE s.IDOficina = $o AND e.trimestre = $t 
            AND YEAR(s.created_at) = YEAR(curdate())");
            
        }else if($t == 2){
            $metasTrimestrales = \DB::select("SELECT 
            o.NombreOficina,ob.Descripcion as objetivos, pe.Descripcion as proceso, a.Descripcion as actividad,
            e.IDEntregable as id,SUM(e.monto) as monto,s.SubActividad, s.Meta as Meta, 
            ROUND(((s.Trimestre1 + s.Trimestre2) / s.Meta)*100,2) as esperado,
            ROUND((SUM(e.monto) / (s.Trimestre1 + s.Trimestre2))*100,2) as percent, 
            ROUND((SUM(e.monto) / s.Meta)*100,2) as anual, s.UnidadMedida as unidad 
            FROM entregable e 
            JOIN subactividades s ON e.IDSubactividad = s.ID
            JOIN actividades a ON s.IDActividad = a.ID
            JOIN procestrategicos pe ON s.IDProceso = pe.ID
            JOIN objetivos ob ON s.IDObjetivo = ob.ID
            JOIN oficinas o ON o.IDOficina = e.IDOficina 
            WHERE s.IDOficina = $o AND (e.trimestre <= $t) 
            AND YEAR(s.created_at) = YEAR(curdate()) GROUP BY e.IDSubactividad");
            
        }else if($t == 3){
            $metasTrimestrales = \DB::select("SELECT 
            o.NombreOficina,ob.Descripcion as objetivos, pe.Descripcion as proceso, a.Descripcion as actividad,
            e.IDEntregable as id,SUM(e.monto) as monto,s.SubActividad, s.Meta as Meta, 
            ROUND(((s.Trimestre1 + s.Trimestre2 + s.Trimestre3) / s.Meta)*100,2) as esperado,
            ROUND((SUM(e.monto) / (s.Trimestre1 + s.Trimestre2 + s.Trimestre3))*100,2) as percent, 
            ROUND((SUM(e.monto) / s.Meta)*100,2) as anual, s.UnidadMedida as unidad 
            FROM entregable e 
            JOIN subactividades s ON e.IDSubactividad = s.ID
            JOIN actividades a ON s.IDActividad = a.ID
            JOIN procestrategicos pe ON s.IDProceso = pe.ID
            JOIN objetivos ob ON s.IDObjetivo = ob.ID
            JOIN oficinas o ON o.IDOficina = e.IDOficina 
            WHERE s.IDOficina = $o AND (e.trimestre <=$t) 
            AND YEAR(s.created_at) = YEAR(curdate()) GROUP BY e.IDSubactividad");

        }else if($t == 4){
            $metasTrimestrales = \DB::select("SELECT 
            o.NombreOficina,ob.Descripcion as objetivos, pe.Descripcion as proceso, a.Descripcion as actividad,
            e.IDEntregable as id,SUM(e.monto) as monto,s.SubActividad, s.Meta as Meta, 
            ROUND(((s.Trimestre1 + s.Trimestre2 + s.Trimestre3 + s.Trimestre4) / s.Meta)*100,2) as esperado,
            ROUND((SUM(e.monto) / (s.Trimestre1 + s.Trimestre2 + s.Trimestre3 + s.Trimestre4))*100,2) as percent, 
            ROUND((SUM(e.monto) / s.Meta)*100,2) as anual, s.UnidadMedida as unidad 
            FROM entregable e 
            JOIN subactividades s ON e.IDSubactividad = s.ID
            JOIN actividades a ON s.IDActividad = a.ID
            JOIN procestrategicos pe ON s.IDProceso = pe.ID
            JOIN objetivos ob ON s.IDObjetivo = ob.ID
            JOIN oficinas o ON o.IDOficina = e.IDOficina 
            WHERE s.IDOficina = $o AND (e.trimestre <=$t) 
            AND YEAR(s.created_at) = YEAR(curdate()) GROUP BY e.IDSubactividad");
        }
        return compact("metasTrimestrales");
        
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\entregable  $entregable
     * @return \Illuminate\Http\Response
     */
    public function edit(entregable $entregable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\entregable  $entregable
     * @return \Illuminate\Http\Response
     */
    public function update($id,$cant)
    {
        $c = (double) $cant;
        $z = \DB::table('entregable')->where('IDEntregable',$id)->update(['monto' => $c]);
        return "OK";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\entregable  $entregable
     * @return \Illuminate\Http\Response
     */
    public function destroy(entregable $entregable)
    {
        //
    }
    public function metas()
    {
        $of1t1 = \DB::select("SELECT (SELECT IFNULL(SUM(e.monto),0) FROM entregable e WHERE e.IDOficina = 1 AND e.trimestre = 1)/(SELECT IFNULL(SUM(s.Trimestre1),1) FROM subactividades s WHERE IDOficina = 1) as 'percent'");
        $of1t2 = \DB::select("SELECT (SELECT IFNULL(SUM(e.monto),0) FROM entregable e WHERE e.IDOficina = 1 AND e.trimestre = 2)/(SELECT IFNULL(SUM(s.Trimestre2),1) FROM subactividades s WHERE IDOficina = 1) as 'percent'");
        $of1t3 = \DB::select("SELECT (SELECT IFNULL(SUM(e.monto),0) FROM entregable e WHERE e.IDOficina = 1 AND e.trimestre = 3)/(SELECT IFNULL(SUM(s.Trimestre3),1) FROM subactividades s WHERE IDOficina = 1) as 'percent'");
        $of1t4 = \DB::select("SELECT (SELECT IFNULL(SUM(e.monto),0) FROM entregable e WHERE e.IDOficina = 1 AND e.trimestre = 4)/(SELECT IFNULL(SUM(s.Trimestre4),1) FROM subactividades s WHERE IDOficina = 1) as 'percent'");
        $of2t1 = \DB::select("SELECT (SELECT IFNULL(SUM(e.monto),0) FROM entregable e WHERE e.IDOficina = 2 AND e.trimestre = 1)/(SELECT IFNULL(SUM(s.Trimestre1),1) FROM subactividades s WHERE IDOficina = 2) as 'percent'");
        $of2t2 = \DB::select("SELECT (SELECT IFNULL(SUM(e.monto),0) FROM entregable e WHERE e.IDOficina = 2 AND e.trimestre = 2)/(SELECT IFNULL(SUM(s.Trimestre2),1) FROM subactividades s WHERE IDOficina = 2) as 'percent'");
        $of2t3 = \DB::select("SELECT (SELECT IFNULL(SUM(e.monto),0) FROM entregable e WHERE e.IDOficina = 2 AND e.trimestre = 3)/(SELECT IFNULL(SUM(s.Trimestre3),1) FROM subactividades s WHERE IDOficina = 2) as 'percent'");
        $of2t4 = \DB::select("SELECT (SELECT IFNULL(SUM(e.monto),0) FROM entregable e WHERE e.IDOficina = 2 AND e.trimestre = 4)/(SELECT IFNULL(SUM(s.Trimestre4),1) FROM subactividades s WHERE IDOficina = 2) as 'percent'");
        $of3t1 = \DB::select("SELECT (SELECT IFNULL(SUM(e.monto),0) FROM entregable e WHERE e.IDOficina = 3 AND e.trimestre = 1)/(SELECT IFNULL(SUM(s.Trimestre1),1) FROM subactividades s WHERE IDOficina = 3) as 'percent'");
        $of3t2 = \DB::select("SELECT (SELECT IFNULL(SUM(e.monto),0) FROM entregable e WHERE e.IDOficina = 3 AND e.trimestre = 2)/(SELECT IFNULL(SUM(s.Trimestre2),1) FROM subactividades s WHERE IDOficina = 3) as 'percent'");
        $of3t3 = \DB::select("SELECT (SELECT IFNULL(SUM(e.monto),0) FROM entregable e WHERE e.IDOficina = 3 AND e.trimestre = 3)/(SELECT IFNULL(SUM(s.Trimestre3),1) FROM subactividades s WHERE IDOficina = 3) as 'percent'");
        $of3t4 = \DB::select("SELECT (SELECT IFNULL(SUM(e.monto),0) FROM entregable e WHERE e.IDOficina = 3 AND e.trimestre = 4)/(SELECT IFNULL(SUM(s.Trimestre4),1) FROM subactividades s WHERE IDOficina = 3) as 'percent'");
        $of4t1 = \DB::select("SELECT (SELECT IFNULL(SUM(e.monto),0) FROM entregable e WHERE e.IDOficina = 4 AND e.trimestre = 1)/(SELECT IFNULL(SUM(s.Trimestre1),1) FROM subactividades s WHERE IDOficina = 4) as 'percent'");
        $of4t2 = \DB::select("SELECT (SELECT IFNULL(SUM(e.monto),0) FROM entregable e WHERE e.IDOficina = 4 AND e.trimestre = 2)/(SELECT IFNULL(SUM(s.Trimestre2),1) FROM subactividades s WHERE IDOficina = 4) as 'percent'");
        $of4t3 = \DB::select("SELECT (SELECT IFNULL(SUM(e.monto),0) FROM entregable e WHERE e.IDOficina = 4 AND e.trimestre = 3)/(SELECT IFNULL(SUM(s.Trimestre3),1) FROM subactividades s WHERE IDOficina = 4) as 'percent'");
        $of4t4 = \DB::select("SELECT (SELECT IFNULL(SUM(e.monto),0) FROM entregable e WHERE e.IDOficina = 4 AND e.trimestre = 4)/(SELECT IFNULL(SUM(s.Trimestre4),1) FROM subactividades s WHERE IDOficina = 4) as 'percent'");
        return compact('of1t1','of1t2','of1t3','of1t4','of2t1','of2t2','of2t3','of2t4','of3t1','of3t2','of3t3','of3t4','of4t1','of4t2','of4t3','of4t4');
    }
}

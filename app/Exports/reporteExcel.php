<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;

class reporteExcel implements FromArray
{
    /**
    * @return \Illuminate\Support\Arr 
    */
    public function array(): array
    {
        $resultado = \DB::select("CALL `SP_Reportegeneral`();");
        $resultadoArray[] = array("fecha","cantidad","IATA","ruta","codReserva","cliente","pasajeros","formapago","estado","compra","venta","ganancia","montoSoles");
        foreach ($resultado as $result) 
        {
            $resultadoArray[] = array(
                'fecha' => $result->fecha,
                'cantidad' => $result->cantidad,
                'IATA' => $result->IATA,
                'ruta' => $result->ruta,
                'codReserva' => $result->codReserva,
                'cliente' => $result->cliente,
                'pasajeros' => $result->pasajeros,
                'formapago' => $result->formapago,
                'estado' => $result->estado,
                'compra' => $result->compra,
                'venta' => $result->venta,
                'ganancia' => $result->ganancia,
                'montoSoles' => $result->montoSoles
            );
        } 
        return $resultadoArray;
    }
}
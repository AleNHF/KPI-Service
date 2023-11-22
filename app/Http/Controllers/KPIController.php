<?php

namespace App\Http\Controllers;

use App\Models\KPIResult;
use Illuminate\Support\Facades\Http;

class KPIController extends Controller
{
    public function tiempoCicloCompras()
    {
        try {
            $response = Http::get('http://ruta-del-microservicio-compras/tiempo-ciclo-compras');

            if ($response->failed()) {
                return response()->json(['error' => 'Error al obtener los datos del microservicio de compras.']);
            }

            $data = $response->json();

            $resultado = new KPIResult();
            $resultado->tipo = 'tiempo_ciclo_compras';
            $resultado->valor = $data['tiempo_ciclo_compras'];
            $resultado->save();

            return response()->json(['tiempo_ciclo_compras' => $data['tiempo_ciclo_compras']]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al calcular y almacenar el tiempo de ciclo de compras.', 'mensaje' => $e->getMessage()]);
        }
    }

    public function getVolumenVentas($dateStart, $dateEnd)
    {
        $response = Http::get('http://microservicio-ventas/sales/volumen', [
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd,
        ]);

        $result = $response->json();

        KPIResult::create([
            'tipo' => 'Volumen de Ventas',
            'valor' => $result['volumen_ventas'],
        ]);

        return $result;
    }

    public function getIngresosVentas($fechaInicio, $fechaFin)
    {
        $response = Http::get('http://microservicio-ventas/sales/ingresos', [
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
        ]);

        $result = $response->json();

        // Almacena el resultado en la base de datos local
        KPIResult::create([
            'tipo' => 'Ingresos de Ventas',
            'valor' => $result['ingresos_ventas'], // Ajusta según la respuesta real
        ]);

        return $result;
    }
}

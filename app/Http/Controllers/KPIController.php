<?php

namespace App\Http\Controllers;

use App\Models\KPIResult;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class KPIController extends Controller
{
    public function supplierDeliveryTimeAverage()
    {
        try {
            $client = new Client();
            $response = $client->get('http://localhost:3000/api/order-microservice/order/supplier-delivery-time-average');

            $data = json_decode($response->getBody(), true);

            /* $resultado = new KPIResult();
            $resultado->tipo = 'tiempo_ciclo_compras';
            $resultado->valor = $data['tiempo_ciclo_compras'];
            $resultado->save(); */

            return response()->json(['tiempo_ciclo_compras' => $data]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al calcular y almacenar el tiempo de ciclo de compras.', 'mensaje' => $e->getMessage()]);
        }
    }

    public function bestSellerProducts()
    {
        try {
            $client = new Client();
            $response = $client->post('http://localhost:3000/api/sale-microservice/sales/best-seller');

            $data = json_decode($response->getBody(), true);

            /* $resultado = new KPIResult();
            $resultado->tipo = 'tiempo_ciclo_compras';
            $resultado->valor = $data['tiempo_ciclo_compras'];
            $resultado->save(); */

            return response()->json(['best-seller-products' => $data]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener los productos más vendidos', 'mensaje' => $e->getMessage()]);
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

    public function getIncomePerYear(Request $request)
    {
        try {
            $startYear = $request->query('startYear');
            $client = new Client();
            $response = $client->post("http://localhost:3000/api/sale-microservice/sales/income-per-year?startYear=$startYear");

            $data = json_decode($response->getBody(), true);

            /* $resultado = new KPIResult();
            $resultado->tipo = 'tiempo_ciclo_compras';
            $resultado->valor = $data['tiempo_ciclo_compras'];
            $resultado->save(); */

            return response()->json(['income-per-year' => $data]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el total de ventas por año', 'mensaje' => $e->getMessage()]);
        }
    }

    public function getLastSales()
    {
        try {
            $client = new Client();
            $response = $client->post("http://localhost:3000/api/sale-microservice/last-sales");

            $data = json_decode($response->getBody(), true);

            /* $resultado = new KPIResult();
            $resultado->tipo = 'tiempo_ciclo_compras';
            $resultado->valor = $data['tiempo_ciclo_compras'];
            $resultado->save(); */

            return response()->json(['last-sales' => $data]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener las ultimas ventas por año', 'mensaje' => $e->getMessage()]);
        }
    }
}

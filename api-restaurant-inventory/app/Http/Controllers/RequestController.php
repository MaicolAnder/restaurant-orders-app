<?php

namespace App\Http\Controllers;

use App\Models\Ingredientes;
use \App\Models\Solicitudes;
use \App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RequestController extends Controller
{
    use ResponseAPI;

    private Solicitudes $solicitudes;
    private string $url_marketplace;

    public function __construct(Solicitudes $solicitudes)
    {
        $this->solicitudes      = $solicitudes;
        $this->url_marketplace  = $_ENV['API_MARKETPLACE'];
    }

    public function index()
    {
        $orders = $this->solicitudes->all();
        return ResponseAPI::success($orders);
    }

    public function getBuysOnMarketplace($tipo_movimiento = 'Compra') {
        $solicitudes = Solicitudes::where('tipo_movimiento', $tipo_movimiento)->orderBy('fecha_registro', 'DESC')->get();
        foreach ($solicitudes as $solicitud) {
            $solicitud->ingrediente = Ingredientes::where('id_ingrediente', $solicitud->id_ingrediente)->first();
        }
        return ResponseAPI::success($solicitudes, 200);

    }

    public function buyIngredient(string $nombre_ingrediente) {
        $ingrediente = Ingredientes::where(['nombre_ingrediente' => $nombre_ingrediente, 'id_estado' => 4])->first();

        if ($ingrediente) {
            $response = Http::get($this->url_marketplace, [
                'ingredient' => strtolower($ingrediente->nombre_ingrediente)
            ]);

            if($response->successful()){
                $cantidad = $response->object()->quantitySold;
                if($cantidad > 0){
                    $solicitud = new Solicitudes();
                    $solicitud->cantidad = $cantidad;
                    $solicitud->id_ingrediente = $ingrediente->id_ingrediente;
                    $this->store($solicitud);
                    return ResponseAPI::success($solicitud, 200);
                }
                return ResponseAPI::fail('No QuantitySold');
            }
            return ResponseAPI::fail('API Erro response');
        } else {
            return ResponseAPI::fail('Erro information');
        }
    }

    public function store(Solicitudes $solicitud){
        return $solicitud->save();
    }
}

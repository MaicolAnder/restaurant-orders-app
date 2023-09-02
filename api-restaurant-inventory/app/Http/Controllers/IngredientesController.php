<?php

namespace App\Http\Controllers;

use App\Models\Ingredientes;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use App\Traits\ResponseAPI;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class IngredientesController extends Controller
{
    use ResponseAPI;

    private Ingredientes $ingredientes;
    private Response  $statusList;
    private String    $url_api;

    public function __construct(Ingredientes $ingredientes)
    {
        $this->ingredientes = $ingredientes;
        $this->url_api      = $_ENV['API_STATUS_URL'];
        $this->statusList   = Http::timeout(-1)->get($this->url_api);
    }

    /**
     * Muestra todos los registros
     */
    public function index()
    {
        $orders = $this->ingredientes->all();
        foreach ($orders as $order) {
            $order['estado'] = $this->findStatusById($order->id_estado);
            unset($order->id_estado);
        }
        return ResponseAPI::success($orders);
    }

    public function show(int $id){
        $ingrediente = $this->ingredientes->find($id);
        return ResponseAPI::success($ingrediente);

    }

    /**
     * Muestra todos el inventario de cada ingrediente activo
     */
    public function showInventoryIngredients(int $idIngredient = null, int $idStatus = 4)
    {
        $_arr = DB::table('solicitudes')
                ->join('ingredientes', 'solicitudes.id_ingrediente', '=', 'ingredientes.id_ingrediente')
                ->select(
                    'ingredientes.id_ingrediente',
                    DB::raw('(SELECT ifnull(SUM(cantidad),0) FROM solicitudes WHERE tipo_movimiento = \'Compra\'  AND id_ingrediente = ingredientes.id_ingrediente) cant_compra'),
                    DB::raw('(SELECT ifnull(SUM(cantidad),0) FROM solicitudes WHERE tipo_movimiento = \'Entrega\' AND id_ingrediente = ingredientes.id_ingrediente) cant_entrega'),
                    DB::raw('(SELECT ifnull(SUM(cantidad),0) FROM solicitudes WHERE tipo_movimiento = \'Compra\'  AND id_ingrediente = ingredientes.id_ingrediente) - (SELECT ifnull(SUM(cantidad),0) FROM solicitudes WHERE tipo_movimiento = \'Entrega\' AND id_ingrediente = ingredientes.id_ingrediente) cant_disponible'),
                    'nombre_ingrediente')
                ->where('ingredientes.id_estado', '=', $idStatus)
                ->Where(function (Builder $query) use ($idIngredient) {
                    if ($idIngredient == null) {
                        $query->where(`'1'`, '=', `'1'`);
                    } else {
                        $query->where('ingredientes.id_ingrediente', '=', $idIngredient);
                    }
                })
                ->groupBy('ingredientes.id_ingrediente')
                ->get();
        return ResponseAPI::success($_arr);
    }

    /**
     * Selecciona una receta aleatoriamente y crea una orden nueva
     */
    public function newOrder(){
        // Selecciona receta activa al azar

        return ResponseAPI::success([], 201, 'created');
    }

    public function findStatusById(int $id): Object {
        foreach ($this->statusList->object()->data as $value) {
            if($value->id_estado == $id){
                return $value;
            }
        }
        return null;
    }

    /*
    SELECT
	(SELECT SUM(cantidad) FROM solicitudes WHERE tipo_movimiento = 'Compra'  AND id_ingrediente = s.id_ingrediente) -
	(SELECT SUM(cantidad) FROM solicitudes WHERE tipo_movimiento = 'Entrega' AND id_ingrediente = s.id_ingrediente) total,
	i.nombre_ingrediente
FROM solicitudes s
INNER JOIN ingredientes i ON s.id_ingrediente = i.id_ingrediente
GROUP BY i.id_ingrediente;
    */

}

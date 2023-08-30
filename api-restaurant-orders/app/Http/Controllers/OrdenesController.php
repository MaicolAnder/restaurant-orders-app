<?php

namespace App\Http\Controllers;

use App\Models\Ingredientes;
use App\Models\Ordenes;
use App\Models\Recetas;
use App\Models\IngredientesRecetas;
use App\Traits\ResponseAPI;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class OrdenesController extends Controller
{
    private IngredientesRecetas $ingrReceta;
    private Ordenes     $ordenes;
    private Response    $statusList;
    private Response    $inventoryList;
    private String      $url_sts;
    private String      $url_inv;

    public function __construct(Ordenes $ordenes)
    {
        $this->ordenes       = $ordenes;
        $this->url_sts       = $_ENV['API_STATUS_URL'];
        $this->url_inv       = $_ENV['API_INVENTORY_URL'];
        $this->statusList    = Http::timeout(-1)->get($this->url_sts);
    }

    /**
     * Lista todos los registros con su respectivo estado
     */
    public function index($id_estado = null)
    {
        $orders = null;
        if($id_estado == null){
            $orders = $this->ordenes->get();
        } else {
            $orders = Ordenes::where('id_estado', $id_estado)->get();
        }

        foreach($orders as $order){
            $order->desc_estado = $this->findStatusById($order->id_estado);
            $order->desc_receta = $this->findRecetaById($order->id_receta);
        }
        return ResponseAPI::success($orders);
    }

    /**
     * Muestra el recurso especificado.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $order = $this->ordenes->find($id);
        if (!$order) {
            return ResponseAPI::fail("not_data_found", 400);
        }
        $order->desc_estado = $this->findStatusById($order->id_estado);
        $order->desc_receta = $this->findRecetaById($order->id_receta);

        return ResponseAPI::success([$order]);
    }

    /**
     * Selecciona una receta aleatoriamente y crea una orden nueva
     */
    public function newOrder(){
        // Válida petición del la API de estados
        if($this->statusList->status() !== 200){
            ResponseAPI::fail("List status not found");
        }

        // Seleccionar receta aleatoria
        $receta = $this->selectRandomOrden();

        // Crea una orden con receta seleccionada con estado
        // Nueva Orden => 1
        try {
            $created = $this->ordenes->create([
                'id_estado'     => $this->statusList->object()->data[0]->id_estado,
                'id_receta'     => $receta->id_receta
            ]);
            return ResponseAPI::success($created, 201, 'created');
        } catch (QueryException $e){
            return ResponseAPI::fail("No se ha podido realizar la orden");
        }
    }

    /**
     * Actualiza el estado de la orden especificada
     * Valida unicamente ordenes de [Nueva orden a En preparación a Entregado]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(int $id)
    {
        // Buscar y validar orden
        $orden = $this->ordenes->find($id);
        if($orden){
            // Valida si estado pasa de 1 a 2 o de 2 a 3
            $respuesta = null;
            $id_estado = (int) $orden->id_estado + 1;            
            switch ($id_estado) {
                case 1:
                    $respuesta = ResponseAPI::fail("Orden no disponible para actualizar");
                    break;
                case 2:
                    $respuesta = $this->takeOrder($orden, $id_estado);
                    break;
                case 3:
                    $respuesta = $this->deliverOrder($orden, $id_estado);
                    break;
                default:
                    $respuesta = ResponseAPI::fail("Orden no disponible para actualizar");
                    break;
            }
            return $respuesta;
        }

        return ResponseAPI::fail('data not found', 400);
    }

    /**
     * Toma orden y valida existencia de ingredientes en bodega
     * Realiza petición a plaza de mercado si bodega no tiene existencia
     * @param \App\Models\Ordenes orden
     * @param int id_estado
     * @return ResponseAPI
     */
    private function takeOrder(Ordenes $orden, int $id_estado) {

        do {
            // Pedir ingredientes en bodega y validar existencia ingrediente de receta
            $ingredientesParaPedido = $this->validaInventarioReceta($orden->id_receta, $bodegaConIngredientes);
            
            // Si no existe cantidad requerida, se compran los ingrediente en la plaza
            if(!$bodegaConIngredientes){
                $this->solicitarIngredienteEnPlaza($ingredientesParaPedido);
            }
        } while (!$bodegaConIngredientes);

        try{
            $this->ordenes
                    ->where($this->ordenes->getPK(), $orden->id_orden)
                    ->update(['id_estado' => $id_estado]);
            $ordenes = $this->ordenes->find($orden->id_orden);
            return ResponseAPI::success($ordenes, 200, 'Order being prepared');
        } catch(QueryException $e){
            return ResponseAPI::fail($e->getMessage());
        }
    }
    
    private function deliverOrder(Ordenes $orden, int $id_estado) {
        try{
            $this->ordenes
                    ->where($this->ordenes->getPK(), $orden->id_orden)
                    ->update(['id_estado' => $id_estado, 'fecha_entrega' => now()]);
            $ordenes = $this->ordenes->find($orden->id_orden);
            return ResponseAPI::success($ordenes, 200, 'Order delivered');
        } catch(QueryException $e){
            return ResponseAPI::fail($e->getMessage());
        }
    }

    /**
     * Realiza peticion de compra de ingrediente faltante en la plaza de mercado
     * API ms-inventory
     * @param Array ingrediente
     */
    private function solicitarIngredienteEnPlaza(Array $ingredientes): void {
        foreach ($ingredientes as $nombre_ingrediente) {
            $buy = Http::post($this->url_inv . '/buy/' . $nombre_ingrediente);
            if($buy->status() == 200){

            }
        }
    }

    private function validaInventarioReceta(int $id_receta, &$bodegaConIngredientes)  {

        // Obtener, validar y actualizar API con la cantidad de ingredientes de la receta
        $ingredientesReceta     = $this->getIngredienteByIdReceta($id_receta);
        $this->inventoryList    = Http::timeout(-1)->get($this->url_inv.'/inventory');
        
        $bodegaConIngredientes  = true;
        $ingredientesParaPedido = [];

        foreach ($ingredientesReceta as $ingrediente) {
            $inventario = $this->findInventoryByIdIngredient($ingrediente->id_ingrediente);

            if((int) $ingrediente->cantidad_requerida > (int) $inventario->cant_disponible){
                array_push($ingredientesParaPedido, $inventario->nombre_ingrediente);
                $bodegaConIngredientes = false;
            }
        }
        return $ingredientesParaPedido;
    }
    
    /**
     * Selecciona receta random
     * @param status int
     * @return Receta
     */
    private function selectRandomOrden($status = 6) : Recetas {
        return Recetas::where('id_estado', $status)->inRandomOrder()->first();
    }

    /**
     * Obtiene ingredientes de una receta determinada
     * @param id_receta int
     * @return Collection
     */
    private function getIngredienteByIdReceta(int $id_receta) {
        return IngredientesRecetas::where('id_receta', $id_receta)
                ->orderBy('id_ingrediente')
                ->get();
    }

    private function findRecetaById(int $id_receta) : Recetas {
        return Recetas::where('id_receta', $id_receta)->first();
    }
    private function findStatusById(int $id): Object {
        foreach ($this->statusList->object()->data as $value) {
            if($value->id_estado == $id){
                return $value;
            }
        }
        return null;
    }

    private function findInventoryByIdIngredient(int $id): Object {
        foreach ($this->inventoryList->object()->data as $value) {
            if($value->id_ingrediente == $id){
                return $value;
            }
        }
        return null;
    }
}

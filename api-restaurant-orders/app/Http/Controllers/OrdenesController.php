<?php

namespace App\Http\Controllers;

use App\Models\Ordenes;
use App\Models\Recetas;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Expr\Cast\Object_;

class OrdenesController extends Controller
{
    private Ordenes $ordenes;
    private Response  $statusList;
    private String    $url_api;

    public function __construct(Ordenes $ordenes)
    {
        $this->ordenes      = $ordenes;
        $this->url_api      = $_ENV['API_STATUS_URL'];
        $this->statusList   = Http::timeout(-1)->get($this->url_api);
    }

    /**
     * Muestra todos los registros
     */
    public function index()
    {
        $orders = $this->ordenes->all();
        foreach($orders as $order){
            $order = 1;
        }
        return ResponseAPI::success($orders);
    }

    /**
     * Selecciona una receta aleatoriamente y crea una orden nueva
     */
    public function newOrder(){
        // Selecciona receta activa al azar
        $random = [];
        $recetas = Recetas::where('id_estado', 6)->get();
        foreach ($recetas as $receta) {
            array_push($random, $receta->id_receta);
        }
        $plateSelected = array_rand($random, 1);
        
        // Válida petición de estados
        if($this->statusList->status() !== 200){
            return ResponseAPI::fail("List status not found");
        }

        // Crea una orden
        $created = $this->ordenes->create([
            'id_estado'     => $this->statusList->object()->data[0]->id_estado,
            'id_receta'     => $plateSelected
        ]);
        return ResponseAPI::success($created, 201, 'created');
    }

    /**
     * Muestra el recurso especificado.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $ordenes = $this->ordenes->find($id);
        if (!$ordenes) {
            return ResponseAPI::fail("not_data_found", 400);
        }
        return ResponseAPI::success($ordenes);
    }

    /**
     * Actualiza el estado del recurso especificado
     * validando unicamente ordenes según requerido
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateOrder(int $id)
    {
        $status  = null;
        $row = $this->ordenes->find($id);
        if($row){
            $status = $row->id_estado + 1;
            $validStatus = $this->findStatusById($status);
            if($validStatus && in_array($status, [2,3])){
                try{
                    $this->ordenes
                    ->where($this->ordenes->getPK(), $id)
                    ->update([
                        'id_estado'     => $validStatus->id_estado,
                        'fecha_entrega' => ($status == 3) ? now() : null
                    ]);
                    $ordenes = $this->ordenes->find($id);
                    return ResponseAPI::success($ordenes, 200, 'updated');
                } catch(QueryException $e){
                    return ResponseAPI::fail($e->getMessage());
                }
            }
            return ResponseAPI::fail('status not valid', 500);
        }
        return ResponseAPI::fail('data not found', 400);
    }

    
    /**
     * Eliminar el recurso especificado del almacenamiento.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $ordenes = $this->ordenes->destroy($id);
            if($ordenes){
                return ResponseAPI::success($ordenes, 200, 'deleted');
            } else {
                return ResponseAPI::fail('not_data_found', 400);
            }
        } catch(QueryException $e){
            return ResponseAPI::fail($e->getMessage());
        }
    }

    public function findStatusById(int $id): Object {
        foreach ($this->statusList->object()->data as $value) {
            if($value->id_estado == $id){
                return $value;
            }
        }
        return null;
    }
}

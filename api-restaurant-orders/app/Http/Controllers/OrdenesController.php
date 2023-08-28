<?php

namespace App\Http\Controllers;

use App\Models\Ordenes;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class OrdenesController extends Controller
{
    private $ordenes;

    public function __construct(Ordenes $ordenes)
    {
        $this->ordenes = $ordenes;
    }

    public function index()
    {
        $orders = $this->ordenes->all();
        return ResponseAPI::success($orders);

    }
    /**
     * Almacene un recurso recién creado en el almacenamiento.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $created = $this->ordenes->create([
                'id_plato'      => $request->input('id_plato'),
                'id_estado'     => $request->input('id_estado'),
                'fecha_orden'   => $request->input('fecha_orden'),
                'fecha_entrega' => $request->input('fecha_entrega')
            ]);
            return ResponseAPI::success($created, 201, 'created');
        } catch(QueryException $e){
            return ResponseAPI::fail($e->getMessage());
        }
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
     * Actualiza el recurso especificado en el almacenamiento.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $this->ordenes
            ->where($this->ordenes->getPK(), $id)
            ->update([
                'id_plato'      => $request->input('id_plato'),
                'id_estado'     => $request->input('id_estado'),
                // 'fecha_orden'   => $request->input('fecha_orden'),
                'fecha_entrega' => $request->input('fecha_entrega')
            ]);
            $ordenes = $this->ordenes->find($id);
            return ResponseAPI::success($ordenes, 200, 'updated');
        } catch(QueryException $e){
            return ResponseAPI::fail($e->getMessage());
        }

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
}

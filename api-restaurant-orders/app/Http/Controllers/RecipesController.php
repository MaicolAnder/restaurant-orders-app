<?php

namespace App\Http\Controllers;

use App\Models\Recetas;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class RecipesController extends Controller
{
    private $recetas;

    public function __construct(Recetas $recetas)
    {
        $this->recetas = $recetas;
    }

    public function index()
    {
        $orders = $this->recetas->all();
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
            $created = $this->recetas->create([
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
        $recetas = $this->recetas->find($id);
        if (!$recetas) {
            return ResponseAPI::fail("not_data_found", 400);
        }
        return ResponseAPI::success($recetas);
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
            $this->recetas
            ->where($this->recetas->getPK(), $id)
            ->update([
                'id_plato'      => $request->input('id_plato'),
                'id_estado'     => $request->input('id_estado'),
                // 'fecha_orden'   => $request->input('fecha_orden'),
                'fecha_entrega' => $request->input('fecha_entrega')
            ]);
            $recetas = $this->recetas->find($id);
            return ResponseAPI::success($recetas, 200, 'updated');
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
            $recetas = $this->recetas->destroy($id);
            if($recetas){
                return ResponseAPI::success($recetas, 200, 'deleted');
            } else {
                return ResponseAPI::fail('not_data_found', 400);
            }
        } catch(QueryException $e){
            return ResponseAPI::fail($e->getMessage());
        }
    }
}

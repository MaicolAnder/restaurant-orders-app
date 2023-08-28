<?php

namespace App\Http\Controllers;

use App\Models\Estados;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class StatusController extends Controller
{
    private $estados;

    public function __construct(Estados $estados)
    {
        $this->estados = $estados;
    }

    public function index()
    {
        $orders = $this->estados->all();
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
            $created = $this->estados->create([
                'estado' => $request->input('estado'),
                'descripcion' => $request->input('descripcion'),
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
        $estados = $this->estados->find($id);
        if (!$estados) {
            return ResponseAPI::fail("not_data_found", 400);
        }
        return ResponseAPI::success($estados);
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
            $this->estados
            ->where($this->estados->getPK(), $id)
            ->update([
                'estado' => $request->input('estado'),
                'descripcion' => $request->input('descripcion')
            ]);
            $estados = $this->estados->find($id);
            return ResponseAPI::success($estados, 200, 'updated');
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
            $estados = $this->estados->destroy($id);
            if($estados){
                return ResponseAPI::success($estados, 200, 'deleted');
            } else {
                return ResponseAPI::fail('not data found to delete', 400);
            }
        } catch(QueryException $e){
            return ResponseAPI::fail($e->getMessage());
        }
    }
}

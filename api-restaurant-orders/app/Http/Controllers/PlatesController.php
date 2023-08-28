<?php

namespace App\Http\Controllers;

use App\Models\Platos;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class PlatesController extends Controller
{
    private String      $api_status;
    private Platos      $platos;
    private Response    $statusList;

    public function __construct(Platos $platos)
    {
        $this->platos       = $platos;
        $this->statusList   = Http::get($_ENV['API_STATUS_URL']);
    }

    public function index()
    {   
        $orders = $this->platos->all();
        return ResponseAPI::success($orders);

    }
    /**
     * Crea registros para un nuevo plato.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($this->statusList->status() !== 200){
            return ResponseAPI::fail("List status not found");
        }
        
        try{
            $created = $this->platos->create([
                'nombre_plato'  => $request->input('nombre_plato'),
                'id_estado'     => $this->statusList->object()->data[0]->id_estado
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
        $platos = $this->platos->find($id);
        if (!$platos) {
            return ResponseAPI::fail("not_data_found", 400);
        }
        return ResponseAPI::success($platos);
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!$this->findStatusById($request->input('id_estado'))){
            return ResponseAPI::fail("Envie un estado válido");
        }

        try{
            $this->platos
            ->where($this->platos->getPK(), $id)
            ->update([
                'nombre_plato'  => $request->input('nombre_plato'),
                'id_estado'     => $request->input('id_estado'),
            ]);
            $platos = $this->platos->find($id);
            return ResponseAPI::success($platos, 200, 'updated');
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
            $platos = $this->platos->destroy($id);
            if($platos){
                return ResponseAPI::success($platos, 200, 'deleted');
            } else {
                return ResponseAPI::fail('not_data_found', 400);
            }
        } catch(QueryException $e){
            return ResponseAPI::fail($e->getMessage());
        }
    }

    public function findStatusById(int $id): string {
        foreach ($this->statusList->object() as $value) {
            if($value->id_estado == $id){
                return true;
            }
        }
        return false;
    }
}

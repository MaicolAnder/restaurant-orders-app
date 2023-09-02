<?php

namespace App\Http\Controllers;

use App\Models\IngredientesRecetas;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class IngredientesRecetasController extends Controller
{
    use ResponseAPI;

    private String      $api_status;
    private IngredientesRecetas $ing_receta;
    private Response    $statusList;

    public function __construct(IngredientesRecetas $ing_receta)
    {
        $this->ing_receta   = $ing_receta;
        $this->statusList   = Http::get($_ENV['API_STATUS_URL']);
    }

    public function index()
    {
        $orders = $this->ing_receta->all();
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
            $created = $this->ing_receta->create([
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
        $ing_receta = $this->ing_receta->find($id);
        if (!$ing_receta) {
            return ResponseAPI::fail("not_data_found", 400);
        }
        return ResponseAPI::success($ing_receta);
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
            $this->ing_receta
            ->where($this->ing_receta->getPK(), $id)
            ->update([
                'nombre_plato'  => $request->input('nombre_plato'),
                'id_estado'     => $request->input('id_estado'),
            ]);
            $ing_receta = $this->ing_receta->find($id);
            return ResponseAPI::success($ing_receta, 200, 'updated');
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
            $ing_receta = $this->ing_receta->destroy($id);
            if($ing_receta){
                return ResponseAPI::success($ing_receta, 200, 'deleted');
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

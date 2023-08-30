<?php

namespace App\Http\Controllers;

use App\Models\Ingredientes;
use App\Models\IngredientesRecetas;
use App\Models\Recetas;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Http;

class RecipesController extends Controller
{
    private Recetas $recetas;
    private string  $url_inv;
    private $listInventory;

    public function __construct(Recetas $recetas)
    {
        $this->recetas = $recetas;
        $this->url_inv       = $_ENV['API_INVENTORY_URL'];

    }

    public function index()
    {
        $orders = $this->recetas->all();
        return ResponseAPI::success($orders);
    }

    public function recipesWithIngredientsDetail()
    {
        $this->listInventory = Http::get($this->url_inv);
        $recipes = $this->recetas->all();
        foreach ($recipes as $recipe) {
            $recipe->ingredientes = IngredientesRecetas::where('id_receta', $recipe->id_receta)->get();
            foreach ($recipe->ingredientes as $value) {
                $value->nombre = $this->findIngredientById($value->id_ingrediente)->nombre_ingrediente;

            }
        }
        return ResponseAPI::success($recipes);
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
                'nombre_receta' => $request->input('nombre_receta'),
                'id_estado'     => $request->input('id_estado')
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
                'nombre_receta' => $request->input('nombre_receta'),
                'id_estado'     => $request->input('id_estado')
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

    public function findIngredientById(int $id) {
        foreach ($this->listInventory->object()->data as $value) {
            if($value->id_ingrediente == $id){
                return $value;
            }
        }
        return null;
    }
}

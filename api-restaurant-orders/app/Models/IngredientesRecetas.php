<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientesRecetas extends Model
{
    use HasFactory;

    public      $timestamps = false;
    protected   $table      = 'ingredientes_receta';
    protected   $primaryKey = 'id_ingre_receta';
    protected   $guarded    = [];

    function getPK(){
        return $this->primaryKey;
    }
}

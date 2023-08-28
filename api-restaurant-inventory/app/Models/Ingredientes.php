<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredientes extends Model
{
    use HasFactory;

    public      $timestamps = false;
    protected   $table      = 'ingredientes';
    protected   $primaryKey = 'id_ingrediente';
    protected   $guarded    = [];

    function getPK(){
        return $this->primaryKey;
    }
}

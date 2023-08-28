<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recetas extends Model
{
    use HasFactory;

    public      $timestamps = false;
    protected   $table      = 'recetas';
    protected   $primaryKey = 'id_recetas';
    protected   $guarded    = [];

    function getPK(){
        return $this->primaryKey;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitudes extends Model
{
    use HasFactory;

    public      $timestamps = false;
    protected   $table      = 'solicitudes';
    protected   $primaryKey = 'id_solicitud';
    protected   $guarded    = [];

    function getPK(){
        return $this->primaryKey;
    }
}

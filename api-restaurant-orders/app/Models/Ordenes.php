<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordenes extends Model
{
    use HasFactory;

    public      $timestamps = false;
    protected   $table      = 'ordenes';
    protected   $primaryKey = 'id_orden';
    protected   $guarded    = [];

    function getPK(){
        return $this->primaryKey;
    }
}

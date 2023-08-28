<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platos extends Model
{
    use HasFactory;

    public      $timestamps = false;
    protected   $table      = 'platos';
    protected   $primaryKey = 'id_plato';
    protected   $guarded    = [];

    function getPK(){
        return $this->primaryKey;
    }
}

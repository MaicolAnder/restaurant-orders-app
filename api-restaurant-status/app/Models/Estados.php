<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estados extends Model
{
    use HasFactory;

    public      $timestamps = false;
    protected   $table      = 'estados';
    protected   $primaryKey = 'id_estado';
    protected   $guarded    = [];

    function getPK(){
        return $this->primaryKey;
    }
}

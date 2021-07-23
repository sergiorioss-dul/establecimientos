<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    // Leer las rutas por slug y no por id
    public function getRouteKeyName()
    {
        return 'slug';
    }
    // Crear relacion 1:N
    public function establecimientos()
    {
        return $this->hasMany(Establecimiento::class);
    }
}

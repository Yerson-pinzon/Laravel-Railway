<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    protected $fillable = ['nombre', 'email','telefono'];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'compras');
    }
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';
    protected $fillable = ['nombre', 'estado','stock'];

    public function Proveedor()
    {
        return $this->belongsToMany(Proveedor::class, 'compras');
    }
    
    public function compras()
    {
        return $this->hasMany(Compra::class);
    }
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
    public function cliente()
    {
        return $this->belongsToMany(Cliente::class, 'compras');
    }
}

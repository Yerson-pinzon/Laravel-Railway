<?php

namespace App\Observers;
use App\Models\Venta;

class VentaObserver
{
    public function created(Venta $venta)
    {
        $this->actualizarStock($venta);
    }

    public function updated(Venta $venta)
    {
        if ($venta->isDirty('cantidad')) {
            $cambio = $venta->getOriginal('cantidad') - $venta->cantidad;
            $this->actualizarStock($venta, $cambio);
        }
    }

    public function deleted(Venta $venta)
    {
        $this->actualizarStock($venta, $venta->cantidad);
    }

    private function actualizarStock(Venta $venta, $cantidad = null)
    {
        $cantidad = $cantidad ?? $venta->cantidad;
        $producto = $venta->producto;
        $producto->stock -= $cantidad;
        $producto->save();
    }
}

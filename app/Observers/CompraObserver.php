<?php

namespace App\Observers;

use App\Models\Compra;

class CompraObserver
{
    public function created(Compra $compra)
    {
        $this->actualizarStock($compra);
    }

    public function updated(Compra $compra)
    {
        // Si la cantidad ha cambiado, actualiza el stock
        if ($compra->isDirty('cantidad')) {
            $cambio = $compra->cantidad - $compra->getOriginal('cantidad');
            $this->actualizarStock($compra, $cambio);
        }
    }

    public function deleted(Compra $compra)
    {
        // Resta la cantidad del stock cuando se elimina una compra
        $this->actualizarStock($compra, -$compra->cantidad);
    }

    private function actualizarStock(Compra $compra, $cantidad = null)
    {
        $cantidad = $cantidad ?? $compra->cantidad;
        $producto = $compra->producto;
        $producto->stock += $cantidad;
        $producto->save();
    }
}

<?php

namespace App\Policies;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return $user->hasAnyRole(['Super Admin', 'Admin', 'Oficina Compras', 'Oficina ventas', 'Oficina Inventario', 'Usuario']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Producto $producto): bool
    {
        //
        return $user->hasAnyRole(['Super Admin', 'Admin', 'Oficina Compras', 'Oficina ventas', 'Oficina Inventario','Usuario']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->hasAnyRole(['Super Admin', 'Admin', 'Oficina Compras', 'Oficina ventas', 'Oficina Inventario']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Producto $producto): bool
    {
        //
        return $user->hasAnyRole(['Super Admin', 'Admin', 'Oficina Compras', 'Oficina ventas', 'Oficina Inventario']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Producto $producto): bool
    {
        //
        return $user->hasAnyRole(['Super Admin', 'Admin', 'Oficina Compras', 'Oficina ventas', 'Oficina Inventario']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Producto $producto): bool
    {
        //
        return $user->hasAnyRole(['Super Admin', 'Admin', 'Oficina Compras', 'Oficina ventas', 'Oficina Inventario']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Producto $producto): bool
    {
        //
        return $user->hasAnyRole(['Super Admin', 'Admin', 'Oficina Compras', 'Oficina ventas', 'Oficina Inventario']);
    }
}

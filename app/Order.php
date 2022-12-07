<?php

// Rendelés model

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // items attribútum, rendelés elemek lista
    public function getItemsAttribute () {
        return OrderItem::selectRaw('order_items.product_id, order_items.price, products.name as product_name')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('order_items.order_id', $this->id)
            ->get();
    }

    // törölt-e a rendelés
    public function isDeleted () {
        return ($this->id && $this->deleted_at);
    }

    // delete metódus felülírva
    // rendelés törlése
    // nincs fizikai törlés, csak a deleted_at mezőt tölti ki
    public function delete () {
        if ($this->id && !$this->isDeleted()) {
            $this->deleted_at = date('Y-m-d H:i:s');
            $this->save();
        }
    }
}

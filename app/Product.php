<?php

// Termék model

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{

    // items attribútum, termék elemek lista
    public function getItemsAttribute () {
        return ProductItem::selectRaw('id, name, price')
            ->whereRaw('product_items.deleted_at is null and products_join_items.product_id = ' . $this->id)
            ->join('products_join_items', 'product_items.id', '=', 'products_join_items.item_id')
            ->get();
    }

    // total_price attribútum
    // alapár + tételek nettó ára
    public function getTotalPriceAttribute () {
        if ($this->id && !$this->isDeleted()) {
            $total = $this->price;
            foreach ($this->items as $item) {
                $total += $item->price;
            }
            return $total;
        }
    }

    // termék elemek beállítása
    public function setItems ($items) {
        if ($this->id && !$this->isDeleted()) {
            $this->clearItems();
            foreach ($items as $key => $value) {
                DB::table('products_join_items')->insert(['product_id' => $this->id, 'item_id' => $value]);
            }
        }
    }

    // termék elemek eltávolítása
    public function clearItems () {
        if ($this->id && !$this->isDeleted()) {
            DB::table('products_join_items')->where('product_id', $this->id)->delete();
        }
    }

    // törölt-e a termék
    public function isDeleted () {
        return ($this->id && $this->deleted_at);
    }

    // delete metódus felülírva
    // termék törlése
    // nincs fizikai törlés, csak a deleted_at mezőt tölti ki
    // a termék elemek kapcsolatokat eltávolítja
    public function delete () {
        if ($this->id && !$this->isDeleted()) {
            $this->deleted_at = date('Y:m:d H:i:s');
            $this->save();
            $this->clearItems();
        }
    }
}

<?php

// Termék elem model

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductItem extends Model
{

    // törölt-e a termék elem
    public function isDeleted () {
        return ($this->id && $this->deleted_at);
    }

    // delete metódus felülírva
    // termék elem törlése
    // nincs fizikai törlés, csak a deleted_at mezőt tölti ki
    public function delete () {
        if ($this->id && !$this->isDeleted()) {
            $this->deleted_at = date('Y:m:d H:i:s');
            $this->save();
            DB::table('products_join_items')->where('item_id', $this->id)->delete();
        }
    }
}

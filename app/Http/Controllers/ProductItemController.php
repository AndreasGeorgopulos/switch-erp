<?php

// Admin termék elemek controller

namespace App\Http\Controllers;

use App\ProductItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ProductItemController extends Controller
{
    // termék elem kezelő oldal
    public function index () {
        return view('product.item.index');
    }

    // termék elem json adatok lekérése
    public function getData ($index = -1) {
        $limit = $index >= 0 ? config('skylc.pager.product_items') : 100000;
        $offset = $index >= 0 ? $index * $limit : 0;

        $total = ProductItem::selectRaw('count(id) as total')->whereRaw('deleted_at is null')->first()->total;
        $items = ProductItem::selectRaw('*')
            ->whereRaw('deleted_at is null')
            ->orderBy('price', 'asc')
            ->orderBy('name', 'asc')
            ->offset($offset)
            ->limit($limit)
            ->get();

        return Response::json([
            'items' => $items,
            'total' => $total,
            'limit' => $limit
        ]);
    }

    // termék elem mentése
    public function save (Request $request) {
        $result = ['success' => 0];

        if (!$item = ProductItem::find($request->get('id'))) {
            $item = new ProductItem();
        }

        foreach ($request->all() as $key => $value) {
            if (!in_array($key, ['id', 'created_at', 'updated_at', 'deleted_at', 'items']))
                $item->$key = $value;
        }
        $item->save();
        $result['success'] = 1;

        return Response::json($result);
    }

    // termék elem törlése
    public function remove ($id) {
        $result = ['success' => 0];
        if ($item = ProductItem::find($id)) {
            $item->delete();
            $result['success'] = 1;
        }
        return Response::json($result);
    }
}

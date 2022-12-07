<?php

// Admin termék controller

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    // termék kezelő oldal
    public function index () {
        return view('product.index');
    }

    // termék json adatok lekérése
    public function getData ($index = -1) {
        $limit = $index >= 0 ? config('skylc.pager.products') : 100000;
        $offset = $index >= 0 ? $index * $limit : 0;

        $total = Product::selectRaw('count(id) as total')->whereRaw('deleted_at is null')->first()->total;

        $fields = [
            'products.*',
            DB::raw('LOWER(COALESCE(GROUP_CONCAT(DISTINCT product_items.name ORDER BY product_items.name ASC SEPARATOR \', \'), \'\')) AS items_title'),
            DB::raw('COALESCE(SUM(product_items.price), 0) AS items_net_price'),
            DB::raw('COALESCE(SUM(product_items.price), 0) + products.price AS net_total'),
            DB::raw('ROUND((COALESCE(SUM(product_items.price), 0) + products.price) * ' . config('skylc.vat') . ') AS gross_total'),
        ];

        $products = Product::select($fields)
            ->leftJoin('products_join_items', 'products_join_items.product_id', '=', 'products.id')
            ->leftJoin('product_items', 'product_items.id', '=', 'products_join_items.item_id')
            ->whereRaw('products.deleted_at is null')
            ->groupBy('products.id')
            ->orderBy('products.name', 'asc')
            ->offset($offset)
            ->limit($limit)
            ->get();

        foreach ($products as &$p) {
            $p->items = $p->items;
        }

        return Response::json([
            'products' => $products,
            'total' => $total,
            'limit' => $limit
        ]);
    }

    // termék mentése
    public function save (Request $request) {
        $result = ['success' => 0];

        if (!$product = Product::find($request->get('id'))) {
            $product = new Product();
        }

        foreach ($request->all() as $key => $value) {
            if (in_array($key, ['name', 'price']))
                $product->$key = $value;
        }
        $product->save();
        $product->setItems($request->get('items'));

        $result['success'] = 1;

        return Response::json($result);
    }

    // termék törlése
    public function remove ($id) {
        $result = ['success' => 0];
        if ($product = Product::find($id)) {
            $product->delete();
            $result['success'] = 1;
        }
        return Response::json($result);
    }
}

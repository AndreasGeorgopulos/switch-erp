<?php

// Admin rendelés controller

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{
    // rendelés kezelő oldal
    public function index () {
        return view('order.index');
    }

    // rendelés json adatok lekérése
    public function getData ($index = -1) {
        $limit = $index >= 0 ? config('skylc.pager.orders') : 100000;
        $offset = $index >= 0 ? $index * $limit : 0;

        $total = Order::selectRaw('count(id) as total')->whereRaw('deleted_at is null')->first()->total;

        $fields = [
            'orders.*',
            'users.name as user_name',
            DB::raw('COALESCE(GROUP_CONCAT(DISTINCT products.name ORDER BY products.name ASC SEPARATOR \', \'), \'\') AS items_title'),
            DB::raw('SUM(order_items.price) AS net_total'),
            DB::raw('SUM(order_items.price) * ' . config('skylc.vat') . ' AS gross_total'),
        ];

        $orders = Order::select($fields)
            ->whereRaw('orders.deleted_at is null')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->leftJoin('order_items', 'order_items.order_id', '=', 'orders.id')
            ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
            ->groupBy('orders.id')
            ->orderBy('id', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();
        foreach ($orders as &$o) {
            $o->items = $o->items;
        }

        return Response::json([
            'orders' => $orders,
            'total' => $total,
            'limit' => $limit
        ]);
    }

    // rendelés törlése
    public function remove ($id) {
        $result = ['success' => 0];
        if ($order = Order::find($id)) {
            $order->delete();
            $result['success'] = 1;
        }
        return Response::json($result);
    }
}

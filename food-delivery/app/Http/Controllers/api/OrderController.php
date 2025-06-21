<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\DetailOrder;
use App\Models\Merchant;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $orders = Order::where("user_id", $user->id)->get();
        return $orders;
        // return (OrderResource::collection($orders))
        //     ->response()
        //     ->setStatusCode(200);
    }

    function merchantGetOrder() {
        $user = Auth::user();
        $merchant = Merchant::firstWhere("user_id", $user->id);
        $orders = Order::where("merchant_id", $merchant->id)->get();

        return $orders;
    }

    public function store(OrderRequest $request)
    {
        $user = Auth::user();
        $payload = $request->validated();
        
        $latestOrder = Order::firstWhere("user_id", $user->id);

        if ($latestOrder->is_done == false) {
            foreach ($payload["menu"] as $menu) {
                $detailOrder = DetailOrder::create();
                $detailOrder->order_id = $latestOrder->id;
                $detailOrder->user_id =  $user->id;
                $detailOrder->menu_id = $menu["id"];
                $detailOrder->stok = $menu["stok"];
                $detailOrder->merchant_id = $payload["merchant_id"];
                $detailOrder->save();

                return $latestOrder;
            }
        } else {
            // Create a new order
            $order = Order::create($payload);
            $order->user_id = $user->id;
            $order->is_done = false;
            $order->merchant_id = $payload["merchant_id"];
            $order->save();

            foreach ($payload["menu"] as $menu) {
                $detailOrder = DetailOrder::create();
                $detailOrder->order_id = $order->id;
                $detailOrder->user_id =  $user->id;
                $detailOrder->menu_id = $menu["id"];
                $detailOrder->stok = $menu["stok"];
                $detailOrder->merchant_id = $payload["merchant_id"];
                $detailOrder->save();
            }

            return $order;
        }
    }

    public function show($id)
    {
        $order = \App\Models\Order::where('id', $id)->first();

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ], 404);
        }

        return (new OrderResource($order))
            ->response()
            ->setStatusCode(200);
    }

    public function update(OrderRequest $request, $id)
    {
        $order = \App\Models\Order::where('id', $id)->first();

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ], 404);
        }

        $order->update($request->validated());

        return (new OrderResource($order))
            ->response()
            ->setStatusCode(200);
    }

    public function destroy($id)
    {
        $order = \App\Models\Order::where('id', $id)->first();

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ], 404);
        }

        $order->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Order deleted successfully',
        ], 200);
    }    

}


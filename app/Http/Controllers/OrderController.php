<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginate = request('paginate', 10);
        $term     = request('search', '');
        $status     = request('status', '');
       
        $orders = Order::search($term)->paginate($paginate);

        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderStoreRequest $request)
    {
        $attributes = $request->validated();

        $order = Order::create($attributes);

        $orderDetails = Cart::where('user_id', '=', $attributes['user_id'])->get();

            foreach ($orderDetails as $orderDetail) {

                $orderDetailsData['order_id'] = $order->id;
                $orderDetailsData['product_id'] = $orderDetail->product_id;
                $orderDetailsData['quantity'] = $orderDetail->quantity;
                $orderDetailsData['unit_price'] = $orderDetail->unit_price;
                $orderDetailsData['sub_total'] = $orderDetail->sub_total;

                OrderDetails::create($orderDetailsData);

            }

            //Delete cart contents.
            Cart::where('user_id', '=', $attributes['user_id'])->delete();

        return (new OrderResource($order))
            ->additional([
                'message' => 'Order successfully.',
                'status' => 'success'
            ])->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderUpdateRequest $request, Order $order)
    {
        $attributes = $request->validated();

        $order->update($attributes);

        return response([
            'message' => 'Order updated successfully.',
            'status'  => 'success',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return response([
            'message' => 'Order deleted successfully.',
            'status'  => 'success'
        ], Response::HTTP_OK);
    }
}

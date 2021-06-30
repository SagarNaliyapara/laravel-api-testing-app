<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function index()
    {
        return OrderResource::collection(Order::query()->paginate());
    }

    public function show($id)
    {
        $order = Order::find($id);
        return response()->json([$order], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|min:3|max:20',
            'customer_email' => 'required|email',
            'customer_phone' => 'required',
            'customer_address' => 'required|string',
            'bike_id' => 'required|exists:bikes,id'
        ]);
        $order = new Order;
        $order->order_number = "AMP" . rand(15, 100000);
        $order->customer_name = $request->input('customer_name');
        $order->customer_email = $request->input('customer_email');
        $order->customer_phone = $request->input('customer_phone');
        $order->customer_address = $request->input('customer_address');
        $order->bike_id = $request->input('bike_id');

        $order->save();
        return response()->json($order, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());

        return response()->json($order, Response::HTTP_ACCEPTED);
    }
}

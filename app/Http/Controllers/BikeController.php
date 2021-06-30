<?php

namespace App\Http\Controllers;

use App\Http\Resources\BikeResource;
use App\Models\Bike;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class BikeController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return BikeResource::collection(Bike::query()->paginate());
    }

    public function show($id): BikeResource
    {
        $bike = Bike::find($id);
        abort(404);
        if (is_null($bike)) {
            abort(404);
        } else {
            $bike->order;
        }
        return new BikeResource($bike);
    }

    public function store(Request $request)
    {
        $request->validate([
            'model' => 'required|string',
            'color' => 'required|string',
            'sku_code' => 'required|string',
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);

        $bike = new Bike;
        $bike->model = $request->input('model');
        $bike->color = $request->input('color');
        $bike->sku_code = $request->input('sku_code');
        $bike->warehouse_id = $request->input('warehouse_id');

        $bike->save();
        return response()->json($bike, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id'
        ]);

        $bike = Bike::findOrFail($id);
        $bike->update($request->all());
        return response()->json($bike);
    }

    public function destroy($id)
    {
        $bike = Bike::findOrFail($id);

        if (!is_null($bike)) {
            $bike->delete();
            return response()->json(["response" => "Bike has been deleted"], Response::HTTP_ACCEPTED);
        }
    }
}

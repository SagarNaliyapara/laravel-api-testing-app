<?php

namespace App\Http\Controllers;

use App\Http\Resources\WarehouseResource;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        return WarehouseResource::collection(Warehouse::query()->get());
    }

    public function show(Warehouse $warehouse)
    {
        return $warehouse;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255|string|unique:warehouses',
        ]);

        $warehouse = Warehouse::create($request->all());
        return response()->json($warehouse, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validateRequest($request);
        if ($validator->fails()) {
            return response()->json(["error" => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $warehouse = Warehouse::findOrFail($id);
        $warehouse->update($request->all());
        return $warehouse;
    }

    public function destroy($id)
    {
        $warehouse = Warehouse::findOrFail($id);

        if (!is_null($warehouse)) {
            $warehouse->delete();
            return response()->json(["response" => "Warehouse has been deleted"], Response::HTTP_ACCEPTED);
        }
    }

    private function validateRequest(Request $request)
    {
        $rules = [
            'name' => 'required|min:2|max:255|string|unique:warehouses',
        ];

    }
}

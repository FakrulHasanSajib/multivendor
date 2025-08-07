<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Resources\VendorResource;

class VendorController extends Controller
{
    public function index()
    {
        return VendorResource::collection(Vendor::paginate(10));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:vendors,email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $vendor = Vendor::create($validatedData);

        return new VendorResource($vendor);
    }

    public function show(Vendor $vendor)
    {
        return new VendorResource($vendor);
    }

    public function update(Request $request, Vendor $vendor)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:vendors,email,' . $vendor->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $vendor->update($validatedData);

        return new VendorResource($vendor);
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return response(null, 204);
    }
}
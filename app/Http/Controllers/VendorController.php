<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::with('products')->where('user_id', Auth::id())->get();
        return response()->json($vendors);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:vendors,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $vendor = Vendor::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return response()->json($vendor, 201);
    }

    public function show($id)
    {
        $vendor = Vendor::with('products')->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return response()->json($vendor);
    }

    public function update(Request $request, $id)
    {
        $vendor = Vendor::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:vendors,email,' . $vendor->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $vendor->update($request->only('name', 'email', 'phone', 'address'));

        return response()->json($vendor);
    }

    public function destroy($id)
    {
        $vendor = Vendor::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $vendor->delete();

        return response()->json(['message' => 'Vendor deleted successfully']);
    }
}

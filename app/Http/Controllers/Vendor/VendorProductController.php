<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Auth facade ব্যবহারের জন্য
use App\Models\Product;
use App\Models\Vendor; 

class VendorProductController extends Controller
{
    /**
     * ভেন্ডরের পণ্য তালিকা দেখায়
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // নিশ্চিত করুন যে ব্যবহারকারী লগইন করা আছে এবং তার সাথে ভেন্ডর মডেলের রিলেশন আছে।
        // যদি তা না থাকে, তাহলে এটি ত্রুটি দেবে।
        $vendorId = Auth::user()->vendor->id;
        $products = Product::where('vendor_id', $vendorId)->latest()->paginate(10);

        return view('vendor.products.index', compact('products'));
    }

    /**
     * একটি নতুন পণ্য সংরক্ষণ করে।
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // ইনপুট ভ্যালিডেশন
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'required',
            // যদি ইমেজের জন্য ভ্যালিডেশন দরকার হয়, এখানে যুক্ত করুন:
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // বর্তমান ভেন্ডরকে খুঁজে বের করুন
        $vendor = auth()->user()->vendor;

        // নতুন পণ্য তৈরি করুন
        Product::create([
            'vendor_id' => $vendor->id,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            // যদি ইমেজের জন্য কোড দরকার হয়, এখানে যুক্ত করুন
            // 'image' => $imagePath,
        ]);

        return redirect()->route('vendor.products.index')->with('success', 'Product added successfully!');
    }

    /**
     * একটি পণ্য আপডেট করে।
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // ইনপুট ভ্যালিডেশন
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'required',
            // যদি ইমেজের জন্য ভ্যালিডেশন দরকার হয়, এখানে যুক্ত করুন:
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // পণ্যটি খুঁজে বের করুন
        $product = Product::findOrFail($id);

        // পণ্য আপডেট করুন
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            // যদি ইমেজের জন্য কোড দরকার হয়, এখানে যুক্ত করুন
            // 'image' => $imagePath,
        ]);

        return redirect()->route('vendor.products.index')->with('success', 'Product updated successfully!');
    }
}
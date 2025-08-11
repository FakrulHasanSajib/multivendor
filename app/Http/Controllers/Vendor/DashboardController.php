<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
// use App\Models\Order; // অর্ডার ম্যানেজমেন্ট যুক্ত করার পর এটি ব্যবহার করবেন

class DashboardController extends Controller
{
    /**
     * ভেন্ডর ড্যাশবোর্ড প্রদর্শন করে।
     */
    public function index()
    {
        // ১. বর্তমানে লগইন করা ব্যবহারকারীকে পান
        $user = Auth::user();

        // ২. ব্যবহারকারীর সাথে যুক্ত ভেন্ডর প্রোফাইলটি পান
        //    এর জন্য User মডেলের সাথে Vendor মডেলের রিলেশন তৈরি করতে হবে।
        $vendor = $user->vendor;

        // যদি কোনো কারণে ভেন্ডর প্রোফাইল না থাকে, তবে তাকে একটি বার্তা দিয়ে রিডাইরেক্ট করুন
        if (!$vendor) {
            // এই সমস্যা সাধারণত হবে না যদি আপনার ভেন্ডর রেজিস্ট্রেশন প্রক্রিয়া ঠিক থাকে।
            // তবে এটি একটি সেফটি চেক।
            return redirect()->route('home')->with('error', 'Vendor profile is not set up correctly.');
        }

        // ৩. এই ভেন্ডরের জন্য প্রয়োজনীয় ডেটা গণনা করুন
        //    - মোট কতগুলো পণ্য আছে?
        $totalProducts = Product::where('vendor_id', $vendor->id)->count();

        //    - কম স্টক আছে এমন পণ্যের সংখ্যা (উদাহরণস্বরূপ, স্টক ৫ এর কম)
        $lowStockProductsCount = Product::where('vendor_id', $vendor->id)
                                        ->where('stock', '<', 5)
                                        ->count();

        //    - মোট কতগুলো অর্ডার পেয়েছে? (অর্ডার সিস্টেম তৈরির পর)
        //    $totalOrders = Order::whereHas('products', function($query) use ($vendor) {
        //        $query->where('vendor_id', $vendor->id);
        //    })->count();

        //    - মোট আয় কত? (অর্ডার সিস্টেম তৈরির পর)
        //    $totalRevenue = ... ;


        // ৪. ডেটাগুলো ভিউতে পাঠান
        return view('vendor.dashboard', [
            'totalProducts' => $totalProducts,
            'lowStockProductsCount' => $lowStockProductsCount,
            // 'totalOrders' => $totalOrders,
        ]);
    }
}
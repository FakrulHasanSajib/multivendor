{{-- layouts/vendor_app.blade.php নামে একটি মাস্টার লেআউট তৈরি করতে পারেন --}}
@extends('layouts.app') {{-- আপাতত ডিফল্ট লেআউট ব্যবহার করুন, পরে পরিবর্তন করতে পারবেন --}}

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Vendor Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4>Welcome, {{ Auth::user()->name }}!</h4>
                    <p>Here is a summary of your shop.</p>

                    <div class="row mt-4">
                        {{-- Total Products Card --}}
                        <div class="col-md-4">
                            <div class="card text-white bg-primary mb-3">
                                <div class="card-header">Total Products</div>
                                <div class="card-body">
                                    <h1 class="card-title">{{ $totalProducts }}</h1>
                                    <a href="{{ route('vendor.products.index') }}" class="text-white">View Products &rarr;</a>
                                </div>
                            </div>
                        </div>

                        {{-- Low Stock Products Card --}}
                        <div class="col-md-4">
                            <div class="card text-white bg-warning mb-3">
                                <div class="card-header">Low Stock Products</div>
                                <div class="card-body">
                                    <h1 class="card-title">{{ $lowStockProductsCount }}</h1>
                                    <a href="#" class="text-white">View Details &rarr;</a>
                                </div>
                            </div>
                        </div>

                        {{-- Total Orders Card (পরে যুক্ত করার জন্য) --}}
                        <div class="col-md-4">
                            <div class="card text-white bg-success mb-3">
                                <div class="card-header">Total Orders</div>
                                <div class="card-body">
                                    {{-- <h1 class="card-title">{{ $totalOrders }}</h1> --}}
                                    <h1 class="card-title">0</h1> {{-- আপাতত ০ রাখুন --}}
                                    <a href="#" class="text-white">View Orders &rarr;</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
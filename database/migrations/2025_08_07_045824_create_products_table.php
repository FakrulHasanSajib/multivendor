<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// পরিবর্তন ১: ক্লাসের নাম ফাইলের নামের সাথে মিলিয়ে CreateProductsTable করা হয়েছে
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // পরিবর্তন ২: Schema::table এর বদলে Schema::create ব্যবহার করা হয়েছে, কারণ এটি নতুন টেবিল তৈরি করছে
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // এখানে আপনার products টেবিলের কলামগুলো যোগ করুন
            // যেমন:
            // $table->string('name');
            // $table->text('description')->nullable();
            // $table->decimal('price', 8, 2);
            
            // আপনি যদি vendor_id যোগ করতে চান, তাহলে সেটিও এখানে করতে পারেন
            $table->unsignedBigInteger('vendor_id'); // Assuming vendor_id is a foreign key
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // পরিবর্তন ৩: down() মেথডে টেবিলটি ড্রপ করার কোড যোগ করা হয়েছে
        Schema::dropIfExists('products');
    }
};
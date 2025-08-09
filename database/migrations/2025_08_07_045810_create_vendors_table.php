<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
             $table->id();
        $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
        $table->string('shop_name');
        $table->string('shop_slug')->unique();
        $table->text('address')->nullable();
        $table->string('phone')->nullable();
        $table->enum('status', ['active', 'inactive'])->default('inactive');
        $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendors');
    }
}
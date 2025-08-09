<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
  protected $fillable = ['user_id', 'shop_name', 'shop_slug', 'address', 'phone', 'status'];

public function user() {
    return $this->belongsTo(User::class);
}

public function products() {
    return $this->hasMany(Product::class);
}
}
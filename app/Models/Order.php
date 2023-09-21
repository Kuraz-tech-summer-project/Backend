<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table='order';
    protected $fillable=['users_id','product_id','quantity','status'];
    function user(){
        return $this->belongsTo(User::class);
    }
    function product(){
        return $this->belongsTo(Product::class);
    }
}


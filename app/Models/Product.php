<?php

namespace App\Models;

use App\Models\Images;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $table='product';
    protected $fillable=['quantity','price','date','category'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function images(){
        return  $this->belongTo(Images::class);
    }

}

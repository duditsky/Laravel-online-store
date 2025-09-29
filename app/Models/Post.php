<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
   protected $fillable = ['text','product_id','order_id','user_id'];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
     public function order():BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
      public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

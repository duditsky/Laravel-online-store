<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
   public function category(): BelongsTo
      {
      return $this->belongsTo(Category::class);
      }
   public function getCountPrice()   
   {
      if(!is_null($this->pivot))
      {
         return $this->pivot->count*$this->price;
      }
      return $this->price;
   }
   public function posts()
   {
      return $this->hasMany(Post::class);
   }
}

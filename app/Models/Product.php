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
      if (!is_null($this->pivot)) {
         return $this->pivot->count * $this->price;
      }
      return $this->price;
   }
   public function posts()
   {
      return $this->hasMany(Post::class);
   }
   public function scopeWithSort($query, $sortType)
   {
      return match ($sortType) {
         'price_asc'  => $query->orderBy('price', 'asc'),
         'price_desc' => $query->orderBy('price', 'desc'),
         'name_asc'   => $query->orderBy('name', 'asc'),
         'name_desc'  => $query->orderBy('name', 'desc'),
         'newest'     => $query->latest(),
         default      => $query->orderBy('id', 'desc'),
      };
   }
}

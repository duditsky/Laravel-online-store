<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   
   protected $fillable = [
      'user_id',
      'status',
      'name',
      'phone',
      'address',
      'shipping_method',
      'payment_method'
   ];

   public function products()
   {
      return $this->belongsToMany(Product::class)->withPivot('count')->withTimestamps();
   }

   public function getFullPrice()
   {
      $sum = 0;
      foreach ($this->products as $product) {
         $sum += $product->getCountPrice();
      }
      return $sum;
   }

   public function user()
   {
      return $this->belongsTo(User::class);
   }

   public function getStatusAttribute(): string
   {

      return match ($this->attributes['status']) {
         0 => 'New',
         1 => 'Pending',
         2 => 'Shipped',
         3 => 'Completed',
         4 => 'Cancelled',
         default => 'Unknown',
      };
   }
   public function posts()
   {
      return $this->hasMany(Post::class);
   }
}

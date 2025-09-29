<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Order extends Authenticatable
{
    use HasFactory, Notifiable;

 protected $fillable = ['status' ];     



   public function products()
   {
      return $this->belongsToMany(Product::class)->withPivot('count')->withTimestamps();
   }

   public function getFullPrice()
   {
      $sum=0;
      foreach($this->products as $product)
      {
          $sum+=$product->getCountPrice();
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

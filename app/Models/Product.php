<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    protected $appends = ['average_rating', 'discounted_price'];
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function getDiscountedPriceAttribute()
    {
        if (isset($this->discount_percentage) && $this->discount_percentage > 0) {
            return round($this->price * (1 - $this->discount_percentage / 100), 2);
        }

        return $this->price;
    }

    protected $with = ['category'];

    
    
}

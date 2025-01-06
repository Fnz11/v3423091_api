<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clothes extends Model
{
    use HasFactory;

    protected $casts = [
        'color' => 'array',
        'price' => 'decimal:2',
    ];

    protected $appends = ['image_url'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'size',
        'limited_edition',
        'color',
        'image',
    ];

    // Relationship with Category
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_clothes');
    }

    public function getColorAttribute($value)
    {
        return json_decode($value) ?: [];
    }

    public function setColorAttribute($value)
    {
        $this->attributes['color'] = json_encode($value);
    }

    public function hasEnoughStock($quantity)
    {
        return $this->stock >= $quantity;
    }

    public function decrementStock($quantity)
    {
        if ($this->hasEnoughStock($quantity)) {
            $this->decrement('stock', $quantity);
            return true;
        }
        return false;
    }

    public function incrementStock($quantity)
    {
        $this->increment('stock', $quantity);
        return true;
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }
        // Use the API endpoint instead of direct storage URL
        return url("/api/v1/assets/images/clothes/{$this->image}");
    }
}

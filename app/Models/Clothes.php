<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clothes extends Model
{
    use HasFactory;

    protected $casts = [
        'color' => 'array',
    ];

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
}

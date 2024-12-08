<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relationship with Clothes
    public function clothes()
    {
        return $this->belongsToMany(Clothes::class, 'category_clothes');
    }
}

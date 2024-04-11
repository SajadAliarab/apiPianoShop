<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'price',
        'reviews',
        'rating',
        'stock',
        'image',
        'discount',
        'description',
        'status',
        'brand',
        'category',
    ];
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\SliderResource;

class Slide extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'link',
        'file',
        'alt'
    ];

}

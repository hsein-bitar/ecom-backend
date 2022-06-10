<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'details',
        'category',
        'price',
        'image_uri',
        'admin_id',
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'text',
        'rating',
        'user_id',
        'item_id',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}

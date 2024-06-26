<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'location', 'genre', 'description', 'image_url', 'owner_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'favorites', 'shop_id', 'user_id');
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function reviews()
    {
    return $this->hasMany(Review::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
}

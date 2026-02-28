<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'slug', 'visible'];
    protected $casts = [
        'visible' => 'boolean',
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'category_post');
    }
}

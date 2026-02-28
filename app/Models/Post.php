<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id','title','slug','picture','short_content','content',
        'added','updated','comment','pending','public','active'
    ];

    protected $casts = [
        'added'   => 'datetime',
        'updated' => 'datetime',
        'comment' => 'integer',
        'pending' => 'integer',
        'public'  => 'integer',
        'active'  => 'integer',
    ];
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_post');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

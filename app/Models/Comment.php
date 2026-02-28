<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false;

    protected $fillable = ['post_id', 'user_id', 'content', 'datetime'];

    protected $casts = [
        'datetime' => 'datetime',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function writer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

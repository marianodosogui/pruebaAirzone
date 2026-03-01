<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['username', 'full_name'];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    // Con esto vemos las categorias donde un usuario a creado un post o donde a comentado en un post
    public function userCategories()
    {
        return Category::query()
            ->whereHas('posts', fn ($q) =>
                $q->where('user_id', $this->id)
            )
            ->orWhereHas('posts.comments', fn ($q) =>
                $q->where('user_id', $this->id)
            )
            ->distinct();
    }
}

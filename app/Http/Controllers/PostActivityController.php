<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostActivityController extends Controller
{
    public function show(Post $post)
    {
        $post->load([
            'owner',
            'comments.writer',
        ]);

        // usuarios participantes (únicos)
        $users = $post->comments
            ->pluck('writer')
            ->filter()
            ->unique('id')
            ->values();


        // Con este return si las tablas relacionadas crecen automaticamente devolveriamos esa informacion nueva,
        // siempre y cuando desde los modelos y las relaciones controlemos lo que queremos devolver, por seguridad y privacidad
        // podriamos generar un return más definido donde controlemos cada informacion de las relaciones que vamos a mandar
        
        return response()->json([
            'body' => [
                'post' => [
                    'id' => $post->id,
                    'title' => $post->title,
                    'short_content' => $post->short_content,
                    'owner' => $post->owner,
                    'users' => $users,
                    'comments' => $post->comments,
                ]
            ]
        ]);

    }
}

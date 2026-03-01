<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Response;

class CategoryController extends Controller
{

    public function index()
    {
        // Puedes paginar si quieres: Category::query()->paginate(20)
        $categories = Category::query()
            ->orderBy('id', 'desc')
            ->get();

        return CategoryResource::collection($categories);
    }


    public function store(CategoryStoreRequest  $request)
    {
        $category = Category::create([
            'name' => $request->string('name'),
            'slug' => $request->string('slug'),
            'visible' => $request->has('visible') ? (bool) $request->input('visible') : true,
        ]);

        return (new CategoryResource($category))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->fill($request->validated());
        $category->save();

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        // controlamos que no exista ningun post asociado a esa categoria
        if ($category->posts()->exists()) {
            return response()->json([
                'message' => 'No se puede eliminar la categoría porque está asociada a uno o más posts. Desasóciala primero.'
            ], 409);
        }
        $category->delete();

        return response()->noContent(); 
    }
}

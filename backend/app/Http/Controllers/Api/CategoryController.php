<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /*
        Muestra una lista de categorías con paginación y ordenadas por nombre. Devuelve una colección de recursos de categoría.
    */
    public function index()
    {
        $categories = Category::query()
            ->search(request('search'))
            ->active(request('active'))
            ->sort(
                request('sort', 'name'),
                request('direction', 'asc')
            )
            ->paginate(
                request('per_page', 10)
            )
            ->withQueryString();

        return CategoryResource::collection($categories);
    }

    // Crear una nueva categoría en la base de datos
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return new CategoryResource($category);
    }

    // Muestra los detalles de una categoría específica
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    // Actualiza una categoría existente en la base de datos
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return new CategoryResource($category);
    }

    // Elimina una categoría de la base de datos
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->noContent();
    }
}

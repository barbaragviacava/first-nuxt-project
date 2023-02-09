<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @property CategoryRepository $repository
 */
class CategoryController extends Controller
{
    /**
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        return $this->repository->paginate($request->all());
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return CategoryResource
     */
    public function store(CategoryRequest $request): CategoryResource
    {
        return new CategoryResource($this->repository->create($request->all())->load('parentCategory'));
    }

    /**
     * @param  \App\Models\Category  $category
     * @return CategoryResource
     */
    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category->load('parentCategory'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return CategoryResource
     */
    public function update(CategoryRequest $request, Category $category): CategoryResource
    {
        return new CategoryResource($this->repository->update($category, $request->all())->load('parentCategory'));
    }

    /**
     * @param  \App\Models\Category  $category
     */
    public function destroy(Category $category): void
    {
        $this->repository->delete($category);
    }

    /**
     * @param Category $category
     */
    public function toggleActive(Category $category): void
    {
        $this->repository->toggleActive($category);
    }
}

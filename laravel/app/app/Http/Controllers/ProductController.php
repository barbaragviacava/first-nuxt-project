<?php

namespace App\Http\Controllers;

use App\Http\Requests\MassChangeRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @property ProductRepository $repository
 */
class ProductController extends Controller
{
    /**
     * @param ProductRepository $repository
     */
    public function __construct(ProductRepository $repository)
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
     * @return ProductResource
     */
    public function store(ProductStoreRequest $request): ProductResource
    {
        return new ProductResource($this->repository->create($request->all())->load('category'));
    }

    /**
     * @param  \App\Models\Product  $product
     * @return ProductResource
     */
    public function show(Product $product): ProductResource
    {
        return new ProductResource($product->load('category'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return ProductResource
     */
    public function update(ProductUpdateRequest $request, Product $product): ProductResource
    {
        return new ProductResource($this->repository->update($product, $request->all())->load('category'));
    }

    /**
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product): void
    {
        $this->repository->delete($product);
    }

    /**
     * @param Product $product
     */
    public function toggleActive(Product $product): void
    {
        $this->repository->toggleActive($product);
    }

    /**
     * @param MassChangeRequest $request
     */
    public function activeMany(MassChangeRequest $request): void
    {
        $this->repository->setActiveValue($request->input('ids'), Product::ACTIVE_YES);
    }

    /**
     * @param MassChangeRequest $request
     */
    public function inactiveMany(MassChangeRequest $request): void
    {
        $this->repository->setActiveValue($request->input('ids'), Product::ACTIVE_NO);
    }

    /**
     * @param MassChangeRequest $request
     */
    public function destroyMany(MassChangeRequest $request): void
    {
        $this->repository->deleteMany($request->input('ids'));
    }

}

<?php

namespace App\Http\Controllers;


use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Lists\ProductsList;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService)
    {
        //..
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        abort_if(!Auth::user()->isOwner(), 403);

        return Inertia::render('Products/ProductsList', [
            'filters'       => Request::all(['search', 'trashed']),
            'table_columns' => ProductsList::get(),
            'table_rows'    => $this->productService->getList(),
        ]);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        abort_if(!Auth::user()->isOwner(), 403);

        return Inertia::render('Products/Create');
    }

    /**
     * @param ProductStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ProductStoreRequest $request): RedirectResponse
    {
        abort_if(!Auth::user()->isOwner(), 403);

        Product::create(
            $request->validated()
        );

        return Redirect::route('products')->with('success', 'Product created.');
    }


    /**
     * @param Product $product
     * @return Response
     */
    public function edit(Product $product): Response
    {
        abort_if(!Auth::user()->isOwner(), 403);

        return Inertia::render('Products/Edit', [
            'product' => new ProductResource($product),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Product $product
     * @param ProductUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(Product $product, ProductUpdateRequest $request): RedirectResponse
    {
        abort_if(!Auth::user()->isOwner(), 403);

        $product->update(
            $request->validated()
        );

        return Redirect::back()->with('success', 'Product updated.');
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        abort_if(!Auth::user()->isOwner(), 403);

        $product->delete();

        return Redirect::route('products')->with('success', 'Product deleted.');
    }

}

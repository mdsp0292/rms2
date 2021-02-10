<?php

namespace App\Http\Controllers;


use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     *
     */
    public function index()
    {
        if(!Auth::user()->isOwner()){
            return Inertia::render('Dashboard/Index');
        }

        return Inertia::render('Products/Index', [
            'filters' => Request::all(['search', 'trashed']),
            'products' => new ProductCollection(
                Product::orderByName()
                    ->filter(Request::only(['search', 'trashed']))
                    ->paginate()
                    ->appends(Request::all())
            ),
        ]);
    }


    public function create()
    {
        if(!Auth::user()->isOwner()){
            abort(403, 'Unauthorized action.');
        }

        return Inertia::render('Products/Create');
    }

    /**
     * @param ProductStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ProductStoreRequest $request)
    {
        if(!Auth::user()->isOwner()){
            abort(403, 'Unauthorized action.');
        }

        Product::create(
            $request->validated()
        );

        return Redirect::route('products')->with('success', 'Product created.');
    }


    /**
     * @param Product $product
     * @return \Inertia\Response
     */
    public function edit(Product $product)
    {
        if(!Auth::user()->isOwner()){
            abort(403, 'Unauthorized action.');
        }

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
        if(!Auth::user()->isOwner()){
            abort(403, 'Unauthorized action.');
        }

        $product->update(
            $request->validated()
        );

        return Redirect::back()->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        if(!Auth::user()->isOwner()){
            abort(403, 'Unauthorized action.');
        }

        $product->delete();

        return Redirect::route('products')->with('success', 'Product deleted.');
    }

    public function restore(Product $product)
    {
        if(!Auth::user()->isOwner()){
            abort(403, 'Unauthorized action.');
        }

        $product->restore();

        return Redirect::route('products')->with('success', 'Product restored.');
    }
}

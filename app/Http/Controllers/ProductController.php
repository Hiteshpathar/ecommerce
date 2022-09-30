<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Discount;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function test()
    {
        return Product::find(1)->cart;
    }

    public function index(Request $request)
    {
        $products = Product::filter($request->only('search', 'status'))->paginate(25);
        return view('admin/productsList', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProductCategory::all();
        $discounts = Discount::where('is_active', 1)->get();
        return view('admin/addProduct', ['categories' => $categories, 'discounts' => $discounts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'images' => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif',
        ]);
        $product = new Product();
        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->inventory = $request->input('quantity');
        $product->category_id = $request->input('category');
        $product->price = $request->input('price') ?? 0;
        $product->discount_id = $request->input('discount');

        $files = $request->file('images');
        foreach ($files as $file) {
            $file_path = Storage::disk('public')->put('photos', $file);
            $file_name = explode('/', $file_path);
            $data[] = $file_name[1];
        }
        $product->images = implode(',', $data);
        $product->save();
        return redirect()->route('products-list')->with('success', 'Product added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $categories = ProductCategory::all();
        $discounts = discount::where('is_active', 1)->get();
        return view('admin/showProduct', ['product' => $product, 'categories' => $categories, 'discounts' => $discounts]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateProductRequest $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);
        $product = Product::find($request->id);
        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->inventory = $request->input('quantity');
        $product->is_active = $request->input('is_active');
        $product->category_id = $request->input('category');
        $product->price = $request->input('price') ?? 0;
        $product->discount_id = $request->input('discount');


        if ($request->file('images')) {
            $files = $request->file('images');
            foreach ($files as $file) {
                $file_path = Storage::disk('public')->put('photos', $file);
                $file_name = explode('/', $file_path);
                $data[] = $file_name[1];
            }
            $product->images = implode(',', $data);
        }

        $product->save();
        return redirect()->route('products-list')->with('success', 'Product added successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::find($id)->delete();
        return response()->json(['success' => 'deleted successfully']);
    }

    public function collections(Request $request)
    {
        $collections = ProductCategory::paginate(25);
        return view('admin/collectionsList', ['collections' => $collections]);
    }
}

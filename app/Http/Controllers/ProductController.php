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
    public function getCategories()
    {
        return ProductCategory::select('id', 'name')->get();
    }

    public function index(Request $request)
    {
        $sort = $request->sort ?? 'updated_at';
        $order = $request->order && in_array($request->order, ['ascending', 'descending']) ? str_replace('ending', '', $request->order) : 'desc';

        $query = Product::with('orders', 'category')->filter($request->only('search', 'status'));
        $query = $query->orderBy($sort, $order);
        return $query->paginate($request->limit);
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
            'price' => 'required'
        ]);
//        try {
        $data = $request->only(['title', 'description', 'price', 'inventory', 'is_active']);
        $request->category_id != "null" ? $data['category_id'] = $request->category_id : '';

        $image = [];
        if ($request->hasFile('images')) {
            foreach ($request->images as $file) {
                $file_path = Storage::disk('public')->put('photos', $file);
                $file_name = explode('/', $file_path);
                $image[] = $file_name[1];
            }
            dd($file_path);
            $data['images'] = implode(',', $image);
        }

        Product::create($data);
//        return response(['message' => "Product has been created successfully!"]);
//        } catch (\Exception $e) {
//            return response(['error' => 'Something went wrong, Try again later!'], 500);
//        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function show($id)
    {
        return $product = Product::with('category')->find($id);
//        if ($product->images) {
//            $file_names = explode(",",$product->images);
//            foreach ($file_names as $file_name){
//                $file[] = Storage::disk('public')->get('/photos/'.$file_name);
//            }
//        }
//        dd($file);
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
            'price' => 'required'
        ]);
        try {
            $data = $request->only(['title', 'description', 'price', 'inventory', 'is_active', 'category_id']);
            $product = Product::find($request->id);
            $product->update($data);
            return response(['message' => "Product has been created successfully!"]);
        } catch (\Exception $e) {
            return response(['error' => 'Something went wrong, Try again later!'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Product::destroy($id);
            return response(['message' => "Product has been deleted successfully!"]);
        } catch (\Exception $e) {
            return response(['error' => 'Something went wrong, Try again later!'], 500);
        }
    }

    public function collections(Request $request)
    {
        $collections = ProductCategory::paginate(25);
        return view('admin/collectionsList', ['collections' => $collections]);
    }
}

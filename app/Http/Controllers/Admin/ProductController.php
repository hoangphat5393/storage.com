<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Backend\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Libraries\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::filter($request)
            ->orderByDesc('sort')
            ->paginate(20)
            ->appends($request->all());

        $total_item = $products->count();

        return view('backend.product.index', compact('products', 'total_item'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.product.single');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->except(['created_at', 'submit', 'category_id']);

        if ($request->slug) {
            $data['slug'] = addslashes($request->slug);
        } else {
            $data['slug'] = Str::slug($data['name']);
        }

        $data['description'] = $data['description'] ? htmlspecialchars($data['description']) : '';
        $data['description_en'] = $data['description'] ? htmlspecialchars($data['description']) : '';
        $data['content'] = $data['content'] ? htmlspecialchars($data['content']) : '';
        $data['content_en'] = $data['content'] ? htmlspecialchars($data['content']) : '';

        $data['seo_title'] = $data['seo_title'] ? $data['seo_title'] : $data['name'];

        //xử lý gallery
        // $galleries = $request->gallery ?? '';
        // if ($galleries != '') {
        //     $galleries = array_filter($galleries);
        //     $data['gallery'] = $galleries ? serialize($galleries) : '';
        // }

        // ADMIN ID
        $data['admin_id'] = Auth::guard('admin')->user()->id;

        // dd($data);
        $product = Product::create($data);
        $insert_id = $product->id;

        // Update sort
        $product->update(['sort' => $insert_id]);

        // SAVE CATEGORY
        $category_id = $request->category_id ?? [];
        $product->categories()->sync($category_id);

        $save = $request->submit ?? 'apply';
        if ($save == 'apply') {
            $msg = "Product has been created successfully";
            $url = route('admin.product.edit', array($insert_id));
            Helpers::msg_move_page($msg, $url);
        } else {
            return redirect(route('admin.product.index'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product, int $id)
    {
        $product = $product::find($id);
        return view('backend.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, int $id)
    {
        $product = $product::findorfail($id);

        // dd($product);

        if ($product) {
            return view('backend.product.single', compact('product'));
        } else {
            return view('404');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->except(['category_id', 'created_at', 'submit', 'admin_id']);

        if ($request->slug) {
            $data['slug'] = addslashes($request->slug);
        } else {
            $data['slug'] = Str::slug($data['name']);
        }

        $product = Product::findOrFail($request->id);
        $product->update($data);

        // SAVE CATEGORY
        $category_id = $request->category_id ?? '';
        if ($category_id != '') {
            $product->categories()->sync($category_id);
        }

        $save = $request->submit ?? 'apply';
        if ($save == 'apply') {
            $msg = "Product has been updated successfully";
            $url = route('admin.product.edit', array($request->id));
            Helpers::msg_move_page($msg, $url);
        } else {
            return redirect(route('admin.product.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, int $id)
    {
        $product->find($id)->destroy();
        return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully.');
    }
}

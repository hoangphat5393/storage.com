<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Backend\Page;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $posts = Page::filter($request)
            ->orderByDesc('sort')->where('type', 'post')
            ->paginate(20)
            ->appends($request->all());

        $total_item = $posts->count();

        return view('backend.post.index', compact('posts', 'total_item'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.post.single');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePageRequest $request)
    {
        $data = $request->except(['created_at', 'submit', 'category_id']);

        if ($request->slug) {
            $data['slug'] = addslashes($request->slug);
        } else {
            $data['slug'] = Str::slug($data['name']);
        }

        // $data['description'] = $data['description'] ? htmlspecialchars($data['description']) : '';
        // $data['description_en'] = $data['description_en'] ? htmlspecialchars($data['description_en']) : '';
        // $data['content'] = $data['content'] ? htmlspecialchars($data['content']) : '';
        // $data['content_en'] = $data['content_en'] ? htmlspecialchars($data['content_en']) : '';

        $data['seo_title'] = $data['seo_title'] ? $data['seo_title'] : $data['name'];

        $data['type'] = 'post';

        //xử lý gallery
        // $galleries = $request->gallery ?? '';
        // if ($galleries != '') {
        //     $galleries = array_filter($galleries);
        //     $data['gallery'] = $galleries ? serialize($galleries) : '';
        // }

        // ADMIN ID
        $data['user_id'] = Auth::guard('admin')->user()->id;

        // dd($data);
        $post = Page::create($data);
        $insert_id = $post->id;

        // Update sort
        $post->update(['sort' => $insert_id]);

        // SAVE CATEGORY
        // $category_id = $request->category_id ?? [];
        // $post->categories()->sync($category_id);

        $save = $request->submit ?? 'apply';
        if ($save == 'apply') {
            $msg = "Post has been created successfully";
            // $url = route('admin.post.edit', array($insert_id));
            // Helpers::msg_move_page($msg, $url);

            // Redirect to detail
            return redirect()->route('admin.post.edit', $insert_id)->with('success', $msg);
        } else {
            return redirect(route('admin.post.index'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $post, int $id)
    {
        $post = $post::find($id);
        return view('backend.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $post, int $id)
    {
        $post = $post::findorfail($id);

        if ($post) {
            return view('backend.post.single', compact('post'));
        } else {
            return view('404');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, Page $post)
    {
        $data = $request->except(['category_id', 'created_at', 'submit', 'admin_id']);

        if ($request->slug) {
            $data['slug'] = addslashes($request->slug);
        } else {
            $data['slug'] = Str::slug($data['name']);
        }

        $data['type'] = 'post';

        $post = Page::findOrFail($request->id);
        $post->update($data);

        // SAVE CATEGORY
        // $category_id = $request->category_id ?? '';
        // if ($category_id != '') {
        //     $post->categories()->sync($category_id);
        // }

        $save = $request->submit ?? 'apply';
        if ($save == 'apply') {
            $msg = "Post has been updated successfully";
            // $url = route('admin.post.edit', array($request->id));
            // Helpers::msg_move_page($msg, $url);

            // Redirect to detail
            return redirect()->route('admin.post.edit', $request->id)->with('success', $msg);
        } else {
            return redirect(route('admin.post.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $post, int $id)
    {
        $post->find($id)->destroy();
        return redirect()->route('admin.post.index')->with('success', 'Post deleted successfully.');
    }
}

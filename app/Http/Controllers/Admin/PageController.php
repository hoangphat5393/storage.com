<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Backend\Page;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

// Export
// use Excel;
use App\Exports\ExportPage;
use Maatwebsite\Excel\Facades\Excel;

class PageController extends Controller
{
    public $data = [];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pages = Page::filter($request)->where(['type' => 'page'])
            ->orderBydesc('id')
            ->orderBydesc('name')
            ->orderBy('sort', 'asc')
            ->paginate(50)
            ->appends($request->all());

        $total_item = $pages->count();

        return view('backend.page.index', compact('pages', 'total_item'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.page.single');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePageRequest $request)
    {

        $data = $request->except(['created_at', 'submit']);

        if ($request->slug) {
            $data['slug'] = addslashes($request->slug);
        } else {
            $data['slug'] = Str::slug($data['name']);
        }
        $data['seo_title'] = $data['seo_title'] ? $data['seo_title'] : $data['name'];

        // ADMIN ID
        $data['user_id'] = Auth::guard('admin')->user()->id;

        // dd($data);
        $response = Page::create($data);
        $insert_id = $response->id;

        // Update sort
        $response->update(['sort' => $insert_id]);

        // dd($response);

        // Tạo file blade
        $fileName = "page-{$insert_id}.blade.php";
        $filePath = resource_path("views/frontend/page/{$fileName}");

        // Kiểm tra nếu file đã tồn tại, nếu chưa có thì tạo file
        if (!File::exists($filePath)) {

            // Nội dung mặc định trong file
            // $fileContent = "@extends('frontend.layouts.master')\n\n@section('content')\n<h1>{$response->name}</h1>\n{!! $response->content !!}\n@endsection";
            $fileContent = "@extends('frontend.layouts.master')\n\n@section('content')\n<h1>{$response->name}</h1>\n{$response->content}\n@endsection";

            // dd($fileName, $filePath, $fileContent);

            // Tạo thư mục nếu chưa tồn tại
            File::ensureDirectoryExists(resource_path('views/frontend/page'));

            // Ghi nội dung vào file
            File::put($filePath, $fileContent);
        }

        $save = $request->submit ?? 'apply';
        if ($save == 'apply') {
            $msg = "Page has been created successfully!";
            // $url = route('admin.page.edit', $insert_id);
            // Helpers::msg_move_page($msg, $url);

            // Redirect to detail
            return redirect()->route('admin.page.edit', $insert_id)->with('success', $msg);
        } else {
            return redirect(route('admin.page.index'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page, $id)
    {
        $page = $page->findorfail($id);
        return view('backend.page.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page, $id)
    {
        $page = $page->findorfail($id);

        if ($page) {
            return view('backend.page.single', compact('page'));
        } else {
            return view('404');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, Page $page)
    {
        $data = request()->except(['created_at', 'submit']);

        if ($request->slug) {
            $data['slug'] = addslashes($request->slug);
        } else {
            $data['slug'] = Str::slug($data['name']);
        }

        $page = Page::findOrFail($request->id);
        $page->update($data);

        if ($request->submit_form == 'apply') {
            $msg = "Page has been updated successfully";
            // $url = route('admin.page.edit', $request->id);
            // Helpers::msg_move_page($msg, $url);

            // Redirect to detail
            return redirect()->route('admin.page.edit', $request->id)->with('success', $msg);
        } else {
            return redirect(route('admin.page.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page, $id)
    {
        $page->find($id)->delete();
        return redirect()->route('admin.page.index')->with('success', 'Page deleted successfully.');
    }

    public function export()
    {
        // $point = [
        //     [1, 2, 3],
        //     [2, 5, 9]
        // ];
        // $data = (object) array(
        //     'points' => $point,
        //     'news' => $point,
        // );
        // $export = new ExportPage([$data]);

        // return Excel::download($export, 'test.xlsx');
        return Excel::download(new ExportPage, 'test.xlsx');
    }
}

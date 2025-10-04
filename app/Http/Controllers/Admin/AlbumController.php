<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;

use App\Models\Backend\Album;
use App\Models\Backend\AlbumItem;

use App\Libraries\Helpers;

class AlbumController extends Controller
{
    public $data = [];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $album = Album::filter($request)
            ->orderByDesc('sort')
            ->paginate(20)
            ->appends($request->all());

        $total_item = $album->count();

        return view('backend.album.index', compact('album', 'total_item'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.album.single', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlbumRequest $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        // ]);

        // $data = request()->except(['_token',  'created_at', 'submit', 'tab_lang', 'slider']);
        $data = $request->except(['created_at', 'submit', 'tab_lang', 'slider']);

        // ADMIN ID
        $data['user_id'] = Auth::guard('admin')->user()->id;

        $respons = Album::create($data);
        $insert_id = $respons->id;

        // Update sort
        $respons->update(['sort' => $insert_id]);

        $save = $request->submit ?? 'apply';
        if ($save == 'apply') {
            $msg = "Album has been created successfully";
            $url = route('admin.album.edit', $insert_id);
            Helpers::msg_move_page($msg, $url);
        } else {
            return redirect(route('admin.album.index'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Album $album)
    {
        $album = Album::findOrFail($album);
        return view('backend.albums.show', compact('album'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album, $id)
    {
        $album = Album::findorfail($id);
        $this->data['album'] = Album::findorfail($id);
        $this->data['album_items'] = $album->items()->orderBy('sort', 'asc')->get();

        if ($this->data['album']) {
            return view('backend.album.single', $this->data);
        } else {
            return view('404');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlbumRequest $request, Album $album)
    {
        $data = $request->except(['created_at', 'submit', 'tab_lang', 'slider', 'admin_id']);

        // dd($data);
        // id post
        $sid = $request->id ?? 0;

        $save = $request->submit ?? 'apply';

        if ($sid > 0) {
            $album = Album::findOrFail($sid);
            $album->update($data);
        }

        if ($save == 'apply') {
            $msg = "Album has been updated successfully";
            $url = route('admin.album.edit', array($sid));
            Helpers::msg_move_page($msg, $url);
        } else {
            return redirect(route('admin.album.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function library(Request $request)
    {
        return view('backend.album.library');
    }
}

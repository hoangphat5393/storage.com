<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Backend\Addtocard, App\Models\Backend\Permission;
use App\Libraries\Helpers;

class PermissionController extends Controller
{
    public $data;
    public $template;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $routes = app()->routes->getRoutes();
        foreach ($routes as $route) {
            if (Str::startsWith($route->uri(), SC_ADMIN_PREFIX)) {
                $prefix = SC_ADMIN_PREFIX ? $route->getPrefix() : ltrim($route->getPrefix(), '/');
                $routeAdmin[$prefix] = [
                    'uri'    => 'ANY::' . $prefix . '/*',
                    'name'   => $prefix . '/*',
                    'method' => 'ANY',
                ];
                foreach ($route->methods as $key => $method) {
                    if ($method != 'HEAD' && !collect($this->without())->first(function ($exp) use ($route) {
                        return Str::startsWith($route->uri, $exp);
                    })) {
                        $routeAdmin[] = [
                            'uri'    => $method . '::' . $route->uri,
                            'name'   => $route->uri,
                            'method' => $method,
                        ];
                    }
                }
            }
        }
        // dd($routeAdmin);
        $this->data['routeAdmin'] = $routeAdmin;
        $this->template = 'admin.permission';
        $this->data['title_head'] = 'Permissions';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permissions = Permission::filter($request)
            ->orderBy('id')
            ->paginate(20)
            ->appends($request->all());
        $total_item = $permissions->count();
        return view('backend.permission.index', compact('permissions', 'total_item'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.permission.single', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        $data = $request->except(['created_at', 'submit']);

        $validator = Validator::make(
            $data,
            [
                'name' => 'required|string|max:50|unique:"' . Permission::class . '",name,' . $request->id . '',
                'slug' => 'required|regex:/(^([0-9A-Za-z\._\-]+)$)/|unique:"' . Permission::class . '",slug,' . $request->id . '|string|max:50|min:3',
            ],
            [
                'slug.regex' => __('admin.permission.slug_validate'),
            ]
        );

        // if ($validator->fails()) {
        //     return redirect()->back()
        //         ->withErrors($validator)
        //         ->withInput();
        // }

        $data['slug'] = Str::slug($data['name']);
        $data['http_uri'] = implode(',', ($data['http_uri'] ?? []));

        // Edit
        $permission = Permission::create($data);
        $insert_id = $permission->id;

        // Update sort
        // $permission->update(['sort' => $insert_id]);

        $save = $request->submit ?? 'apply';
        if ($save == 'apply') {
            $msg = "Permission has been created successfully";
            $url = route('admin.permission.edit', array($insert_id));
            Helpers::msg_move_page($msg, $url);
        } else {
            return redirect(route('admin.permission.index'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission, int $id)
    {
        $permission = $permission::find($id);
        return view('backend.permission.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission, int $id)
    {
        $permission = $permission::findorfail($id);

        $this->data['permission'] = Permission::findorfail($id);

        if ($this->data['permission']) {
            return view('backend.permission.single', $this->data);
        } else {
            return view('404');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $data = request()->all();

        $validator = Validator::make(
            $data,
            [
                'name' => 'required|string|max:50|unique:"' . Permission::class . '",name,' . $request->id . '',
                'slug' => 'required|regex:/(^([0-9A-Za-z\._\-]+)$)/|unique:"' . Permission::class . '",slug,' . $request->id . '|string|max:50|min:3',
            ],
            [
                'slug.regex' => __('admin.permission.slug_validate'),
            ]
        );

        // if ($validator->fails()) {
        //     return redirect()->back()
        //         ->withErrors($validator)
        //         ->withInput();
        // }

        $data['slug'] = Str::slug($data['name']);
        $data['http_uri'] = implode(',', ($data['http_uri'] ?? []));

        $permission = Permission::findorfail($request->id);
        $permission->update($data);

        $save = $request->submit ?? 'apply';

        if ($save == 'apply') {
            $msg = "Permission has been updated successfully";
            $url = route('admin.permission.edit', array($request->id));
            Helpers::msg_move_page($msg, $url);
        } else {
            return redirect(route('admin.permission.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission, int $id)
    {
        $permission->find($id)->destroy();
        return redirect()->route('admin.permission.index')->with('success', 'Permission deleted successfully.');
    }


    public function roleGroup()
    {
        dd('roleGroup');
    }

    public function without()
    {
        $prefix = SC_ADMIN_PREFIX ? SC_ADMIN_PREFIX . '/' : '';
        return [
            $prefix . 'login',
            $prefix . 'logout',
            $prefix . 'forgot',
            $prefix . 'deny',
            $prefix . 'locale',
            $prefix . 'uploads',
        ];
    }
}

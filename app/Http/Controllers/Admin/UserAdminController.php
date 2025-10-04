<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting, App\Models\Backend\Admin, App\Models\Backend\Addtocard;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Libraries\Helpers;
use App\Models\Backend\AdminRole;
use App\Exports\OrderExport;
use App\Exports\ProductExport;
use Maatwebsite\Excel\Facades\Excel;
use App\WebService\WebService;
use Auth, DB, File, Image, Redirect, Cache;

class UserAdminController extends Controller
{
    public $data, $all_roles;

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

        $this->data['routeAdmin'] = $routeAdmin;
        $this->all_roles = AdminRole::pluck('name', 'id')->all();
    }

    public function index()
    {
        $appends = [
            'search_name' => request('search_name'),
        ];
        if (Auth::guard('admin')->user()->admin_level == 99999) {
            $db = Admin::select('*');

            if (request('search_name') != '') {
                $db->where('name', 'like', '%' . request('search_name') . '%');
            }
            $count_item = $db->count();
            $data = $db->orderBy('id')->paginate(20)->appends($appends);
        }
        return view('backend.user-admin.index')->with(['data' => $data, 'total_item' => $count_item]);
    }

    public function create()
    {
        $this->data['all_roles'] = $this->all_roles;
        return view('backend.user-admin.single', $this->data);
    }

    public function edit($id)
    {
        $user = Admin::find($id);

        $this->data = [
            'data_admin'        => $user,
            'all_roles'         => $this->all_roles,
            'user_roles'        => $user->roles->pluck('id')->toArray(),
        ];
        if ($user) {
            return view('backend.user-admin.single', $this->data);
        } else {
            return view('404');
        }
    }

    public function post(Request $request)
    {
        $data = request()->except(['_token',  'gallery', 'roles', 'check_pass', 'password', 'password_confirmation', 'created_at', 'submit', 'tab_lang']);

        //id post
        $sid = $request->id ?? 0;

        // $data = $request->all();

        // dd($data);
        $save = $data['submit'] ?? 'apply';

        if ($sid > 0) {
            $post_id = $sid;

            // NẾU CÓ THAY ĐỔI PASSWORD
            if (isset($request->check_pass)) {
                $data['password']  = bcrypt($request->password);
            }
            $respons = Admin::where("id", $sid)->update($data);
        } else {
            $respons = Admin::create($data);
            $insert_id = $respons->id;
            $post_id = $insert_id;

            // if sort = 0 => update sort
            // Admin::where("id", $post_id)->update(['sort' => $post_id]);

            // $db = ShopProduct::find(1);
            // $db->sort = $post_id;
            // $db->save();
        }

        // SAVE ROLE
        $role_id = $request->roles ?? '';
        // dd($role_id);
        if ($role_id != '') {
            $admin = Admin::find($post_id);
            $admin->roles()->sync($role_id);
        }

        if ($save == 'apply') {
            $msg = "Post has been Updated";
            $url = route('admin.userAdminDetail', array($post_id));
            Helpers::msg_move_page($msg, $url);
        } else {
            return redirect(route('admin.userList'));
        }
    }

    public function deleteUserAdmin($id)
    {
        $user_current = auth()->user();
        if (auth()->check() && $user_current->id != $id) {
            $loadDelete = Admin::find($id)->delete();
            $msg = "Admin account has been Delete";
            $url = route('admin.userList');
            Helpers::msg_move_page($msg, $url);
        }
        $msg = "Không thực hiện được thao tác này";
        $url = route('admin.userList');
        Helpers::msg_move_page($msg, $url);
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

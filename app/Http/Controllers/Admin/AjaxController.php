<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Models\Backend\Menu, App\Models\Backend\MenuItems; // Menu
use App\Models\Backend\Album, App\Models\Backend\AlbumItem; // Album
use App\Models\Backend\Contact, App\Models\Backend\Subscription, App\Models\Backend\Recruitment;
use App\Models\Backend\District, App\Models\Backend\Ward;
use App\Models\Backend\Page, App\Models\Backend\Addtocard, App\Models\Backend\Addtocard_Detail;
use App\Models\Backend\User;
use App\Models\Backend\Role, App\Models\Backend\RoleUser;
use App\Models\Backend\Permission, App\Models\Backend\RolePermission;
use App\Models\Backend\EmailTemplate;
use App\Models\Backend\Shortcode as AdminShortcode;
use App\Models\Backend\Category;
use App\Models\Backend\Post, App\Models\Backend\PostCategory;
use App\Models\Backend\Product, App\Models\Backend\ProductCategory;
use Auth, DB, Carbon\Carbon;

class AjaxController extends Controller
{
    // public $response = [
    //     "success" => '', // True or false
    //     "message" => '',
    //     "data" => [],
    //     "errors" => [
    //         "code" => 404,
    //         "details" => "The user with the given ID does not exist."
    //     ]
    // ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function ajax_delete(Request $request)
    {
        $type = $request->type;
        $check_data = $request->chk_list;
        $arr = array();
        $values = "";
        // dd($check_data);

        for ($i = 0; $i < count($check_data); $i++) {
            $values .= (int)$check_data[$i] . ",";
            $arr[] = (int)$check_data[$i];
        }

        if ($type == 'page' || $type == 'post') {
            $type = 'page';
        }

        switch ($type) {
            case 'user':
                // DELETE DATA FROM PIVOT TABLE
                RoleUser::whereIn('user_id', $arr)->delete();

                // DELETE USER
                User::whereIn('id', $arr)->delete();

                // SET AUTO_INCREMENT TO 1
                $table = (new User)->getTable();
                DB::statement("ALTER TABLE $table AUTO_INCREMENT = 1;");
                return 1;
                break;
            case 'role':

                // DELETE DATA FROM PIVOT TABLE
                RolePermission::whereIn('role_id', $arr)->delete();

                Role::whereIn('id', $arr)->delete();

                // SET AUTO_INCREMENT TO 1
                $table = (new Role)->getTable();
                DB::statement("ALTER TABLE $table AUTO_INCREMENT = 1;");
                return 1;
                break;
            case 'permission':

                // DELETE DATA FROM PIVOT TABLE
                RolePermission::whereIn('permission_id', $arr)->delete();

                Permission::whereIn('id', $arr)->delete();

                // SET AUTO_INCREMENT TO 1
                $table = (new Permission)->getTable();
                DB::statement("ALTER TABLE $table AUTO_INCREMENT = 1;");
                return 1;
                break;
            case 'shortcode':
                AdminShortcode::whereIn('id', $arr)->delete();

                // SET AUTO_INCREMENT TO 1
                $table = (new AdminShortcode)->getTable();
                DB::statement("ALTER TABLE $table AUTO_INCREMENT = 1;");
                return 1;
                break;
            case 'page':
                Page::whereIn('id', $arr)->delete();

                // SET AUTO_INCREMENT TO 1
                $table = (new Page)->getTable();

                DB::statement("ALTER TABLE $table AUTO_INCREMENT = 1;");
                return 1;
                break;
            case 'email-template':
                EmailTemplate::whereIn('id', $arr)->delete();
                return 1;
                break;
            case 'menuwp':
                $menuWp = Menu::whereIn('id', $arr)->get();

                if ($menuWp->count() > 0) {
                    foreach ($menuWp as $item) {
                        // DELETE LIST CHILD
                        if ($item->items->count() > 0) {
                            $item_child_id = $item->items->pluck('id');
                            MenuItems::whereIn('id', $item_child_id)->delete();
                        }
                        // DELETE SLIDER
                        $item->delete();
                    }
                }
                // SET AUTO_INCREMENT TO 1
                $table = (new Menu)->getTable();
                $table2 = (new MenuItems)->getTable();
                DB::statement("ALTER TABLE $table AUTO_INCREMENT = 1;");
                DB::statement("ALTER TABLE $table2 AUTO_INCREMENT = 1;");
                return 1;
                break;
            case 'post':
                Post::whereIn('id', $arr)->delete();

                // DELETE DATA FROM PIVOT TABLE
                PostCategory::whereIn('post_id', $arr)->delete();

                // SET AUTO_INCREMENT TO 1
                $table = (new Post)->getTable();
                DB::statement("ALTER TABLE $table AUTO_INCREMENT = 1;");
                return 1;
                break;
            case 'post-category':
                Category::whereIn('id', $arr)->delete();

                // DELETE DATA FROM PIVOT TABLE
                PostCategory::whereIn('category_id', $arr)->delete();

                // SET AUTO_INCREMENT TO 1
                $table = (new Category)->getTable();
                DB::statement("ALTER TABLE $table AUTO_INCREMENT = 1;");
                return 1;
                break;

            case 'product':
                Product::whereIn('id', $arr)->delete();

                // DELETE DATA FROM PIVOT TABLE
                ProductCategory::whereIn('product_id', $arr)->delete();

                // SET AUTO_INCREMENT TO 1
                $table = (new ProductCategory)->getTable();
                DB::statement("ALTER TABLE $table AUTO_INCREMENT = 1;");
                return 1;
                break;
            case 'post-category':
                Category::whereIn('id', $arr)->delete();

                // DELETE DATA FROM PIVOT TABLE
                PostCategory::whereIn('category_id', $arr)->delete();

                // SET AUTO_INCREMENT TO 1
                $table = (new Category)->getTable();
                DB::statement("ALTER TABLE $table AUTO_INCREMENT = 1;");
                return 1;
                break;
            case 'contact':
                Contact::whereIn('id', $arr)->delete();

                // SET AUTO_INCREMENT TO 1
                $table = (new Contact)->getTable();
                DB::statement("ALTER TABLE $table AUTO_INCREMENT = 1;");
                return 1;
                break;
            case 'recruitment':
                Recruitment::whereIn('id', $arr)->delete();

                // SET AUTO_INCREMENT TO 1
                $table = (new Recruitment)->getTable();
                DB::statement("ALTER TABLE $table AUTO_INCREMENT = 1;");
                return 1;
                break;
            case 'album':

                AlbumItem::whereIn('album_id', $arr)->delete();
                Album::whereIn('id', $arr)->delete();

                // SET AUTO_INCREMENT TO 1
                $table = (new Album)->getTable();
                $table2 = (new AlbumItem)->getTable();
                DB::statement("ALTER TABLE $table AUTO_INCREMENT = 1;");
                DB::statement("ALTER TABLE $table2 AUTO_INCREMENT = 1;");
                return 1;
                break;
            default:
                # code...
                break;
        }
    }

    public function ajax_replicate(Request $rq)
    {
        $type = $rq->type;
        $check_data = $rq->chk_list;
        $arr = array();
        $values = "";

        for ($i = 0; $i < count($check_data); $i++) {
            $values .= (int)$check_data[$i] . ",";
            $arr[] = (int)$check_data[$i];
        }

        if ($type == 'post-categories' || $type == 'product-categories') {
            $type = 'categories';
        }

        if ($type == 'post' || $type == 'campagin') {
            $type = 'post';
        }

        switch ($type) {
            case 'user':
                // Replicate User + Role
                $i = 1;
                $newUser = '';
                foreach ($arr as $id) {
                    $user = User::find($id);

                    // Get categories of current post
                    // $category_id = $user->categories->pluck('id')->toArray();
                    $role_id = $user->roles->pluck('id')->toArray();

                    // Replicate post
                    $newUser = $user->replicate();
                    // $newUser->name = $newUser->name . ' ' . $i;
                    $newUser->name = $newUser->name . ' (Copy ' . time() . ')';
                    $newUser->email = $newUser->email . ' (Copy ' . time() . ')';
                    $newUser->created_at = Carbon::now(); // changing the created_at date
                    $newUser->save(); // saving it to the database

                    // $name = $newUser->name . ' (Copy id: ' . $newUser->id . ')';

                    // Update name
                    // Admin::where("id", $newUser->id)->update(['name' => $name]);

                    // Replicate User Role
                    $newUser = User::find($newUser->id);
                    $newUser->roles()->sync($role_id);
                    $i++;
                }
                return 1;
                break;
            case 'role':
                // Replicate Role + Permission
                $i = 1;
                $newRole = '';
                foreach ($arr as $id) {
                    $role = Role::find($id);

                    // Get categories of current post
                    $permission_id = $role->permissions->pluck('id')->toArray();

                    // Replicate role
                    $newRole = $role->replicate();
                    $newRole->created_at = Carbon::now(); // changing the created_at date
                    $newRole->save(); // saving it to the database

                    $slug = Str::slug($newRole->name . '-' . $newRole->id);

                    // Update slug
                    Role::where("id", $newRole->id)->update(['slug' => $slug]);

                    // Replicate Role Permission
                    $newRole = Role::find($newRole->id);
                    $newRole->permissions()->sync($permission_id);
                    $i++;
                }
                return 1;
                break;
            case 'permission':
                // Replicate Permission
                $i = 1;
                $newPermission = '';
                foreach ($arr as $id) {
                    $permission = Permission::find($id);

                    // Replicate permission
                    $newPermission = $permission->replicate();
                    // $newPermission->slug = Str::slug($newPermission->name);
                    // $newPermission->name = $newPermission->name . ' - Copy ' . time(); // Hoặc sử dụng bất kỳ phương pháp nào để tạo giá trị duy nhất
                    $newPermission->created_at = Carbon::now(); // changing the created_at date
                    $newPermission->save(); // saving it to the database

                    $name = $newPermission->name . '-' . $i;
                    $slug = Str::slug($newPermission->name . '-' . $newPermission->id);

                    // update sort = id
                    Permission::where("id", $newPermission->id)->update(['slug' => $slug, 'name' => $name]);
                    $i++;
                }
                return 1;
                break;
            case 'shortcode':
                // Replicate Post + Category
                $i = 1;
                $newShortcode = '';
                foreach ($arr as $id) {
                    $shortcode = AdminShortcode::find($id);

                    // Replicate video
                    $newShortcode = $shortcode->replicate();
                    $newShortcode->created_at = Carbon::now(); // changing the created_at date
                    $newShortcode->save(); // saving it to the database

                    // update sort = id
                    AdminShortcode::where("id", $newShortcode->id)->update(['sort' => $newShortcode->id]);

                    $i++;
                }
                return 1;
                break;
            case 'page':
                // Replicate Post + Category
                $i = 1;
                $newPage = '';
                foreach ($arr as $id) {
                    $page = Page::find($id);

                    // Replicate post
                    $newPage = $page->replicate();
                    // $newPost->name = $newPost->name . ' ' . $i;
                    // $newPost->slug = Str::slug($newPost->name);
                    $newPage->created_at = Carbon::now(); // changing the created_at date
                    $newPage->save(); // saving it to the database

                    $slug = Str::slug($newPage->name . '-' . $newPage->id);

                    // update sort = id
                    Page::where("id", $newPage->id)->update(['slug' => $slug, 'sort' => $newPage->id]);


                    // Tạo file blade
                    $fileName = "page-{$newPage->id}.blade.php";
                    $filePath = resource_path("views/frontend/landing/{$fileName}");

                    // Kiểm tra nếu file đã tồn tại, nếu chưa có thì tạo file
                    if (!File::exists($filePath)) {

                        // Nội dung mặc định trong file
                        $fileContent = "@extends('frontend.layouts.master')\n\n@section('content')\n<h1>{$newPage->name}</h1>\n@endsection";

                        // Tạo thư mục nếu chưa tồn tại
                        File::ensureDirectoryExists(resource_path('views/frontend/landing'));

                        // Ghi nội dung vào file
                        File::put($filePath, $fileContent);
                    }

                    // Replicate Post Category
                    $newPage = Page::find($newPage->id);
                    $i++;
                }
                return 1;
                break;
            case 'email-template':
                // Replicate Email Template
                $i = 1;
                $newTemplate = '';
                foreach ($arr as $id) {

                    $template = EmailTemplate::find($id);

                    // Replicate post
                    $newTemplate = $template->replicate();
                    $newTemplate->created_at = Carbon::now(); // changing the created_at date
                    $newTemplate->save(); // saving it to the database

                    // update sort = id
                    EmailTemplate::where("id", $newTemplate->id)->update(['sort' => $newTemplate->id]);
                    $i++;
                }
                return 1;
                break;
            case 'menuwp':
                // Replicate Slider + list image
                $i = 1;
                $newMenuWP = '';
                foreach ($arr as $id) {
                    $menuWP = Menu::find($id);

                    // Get menu list items
                    $list_items = $menuWP->items;

                    // Replicate Slider
                    $newMenuWP = $menuWP->replicate();
                    $newMenuWP->created_at = Carbon::now(); // changing the created_at date
                    $newMenuWP->save(); // saving it to the database

                    // update sort = id
                    // Slider::where("id", $newSlider->id)->update(['sort' => $newSlider->id]);

                    // Replicate Slider list image
                    if ($list_items->count() > 0) {
                        foreach ($list_items as $item) {
                            $menuItem = MenuItems::find($item->id);
                            $newMenuItem = $menuItem->replicate();
                            $newMenuItem->menu_id = $newMenuWP->id; // changing the maenu_id
                            $newMenuItem->created_at = Carbon::now(); // changing the created_at date
                            $newMenuItem->save(); // saving it to the database
                        }
                    }
                    $i++;
                }
                return 1;
                break;
            case 'categories':
                // Replicate Category Product
                $i = 1;
                $newCaterory = '';
                foreach ($arr as $id) {
                    $category = Category::find($id);

                    // Get categories of current post
                    // $category_id = $post->categories->pluck('id')->toArray();

                    // Replicate post
                    $newCaterory = $category->replicate();
                    $newCaterory->name = $newCaterory->name . ' ' . $i;
                    $newCaterory->slug = Str::slug($newCaterory->name);
                    $newCaterory->created_at = Carbon::now(); // changing the created_at date
                    $newCaterory->save(); // saving it to the database

                    // update sort = id
                    Category::where("id", $newCaterory->id)->update(['sort' => $newCaterory->id]);

                    // Replicate Post Category
                    // $newPost = Post::find($newCaterory->id);
                    // $newPost->categories()->sync($category_id);
                    $i++;
                }
                return 1;
                break;
            case 'post':
                // Replicate Post + Category
                $i = 1;
                $newPost = '';
                foreach ($arr as $id) {
                    $post = Post::find($id);

                    // Get categories of current post
                    $category_id = $post->categories->pluck('id')->toArray();

                    // Replicate post
                    $newPost = $post->replicate();
                    // $newPost->name = $newPost->name . ' ' . $i;
                    // $newPost->slug = Str::slug($newPost->name);
                    $newPost->created_at = Carbon::now(); // changing the created_at date
                    $newPost->save(); // saving it to the database

                    $slug = Str::slug($newPost->name . '-' . $newPost->id);

                    // update sort = id
                    Post::where("id", $newPost->id)->update(['slug' => $slug, 'sort' => $newPost->id]);

                    // Replicate Post Category
                    $newPost = Post::find($newPost->id);
                    $newPost->categories()->sync($category_id);
                    $i++;
                }
                return 1;
                break;
            case 'album':
                // Replicate Album + list image
                $i = 1;
                $newAlbum = '';
                foreach ($arr as $id) {
                    $album = Album::find($id);

                    // Replicate Album
                    $newAlbum = $album->replicate();
                    $newAlbum->created_at = Carbon::now(); // changing the created_at date
                    $newAlbum->save(); // saving it to the database

                    // update sort = id
                    Album::where("id", $newAlbum->id)->update(['sort' => $newAlbum->id]);

                    // Get album list image
                    $list_image = AlbumItem::where('album_id', $album->id)->orderBy('sort', 'asc')->get();

                    // Replicate Album list image
                    if ($list_image->count() > 0) {
                        foreach ($list_image as $item) {
                            $list_image = AlbumItem::find($item->id);
                            $newImage = $list_image->replicate();
                            $newImage->album_id = $newAlbum->id; // changing the ablum_id
                            $newImage->created_at = Carbon::now(); // changing the created_at date
                            $newImage->save(); // saving it to the database
                        }
                    }
                    $i++;
                }
                return 1;
                break;
            default:
                # code...
                break;
        }
    }

    // Quick change value of data list
    public function ajax_quickchange(Request $request)
    {
        $id = $request->id;
        $column = $request->column;
        $value = $request->value;

        // Call model
        (new $request->model)::where('id', $id)->update([$column => $value]);
    }

    public function update_new_item_status(Request $request)
    {
        if (isset($request['check']) && $request['sid'] != "") :
            $status = $request['check'];
            $postID = (int)$request['sid'];
            if ($postID > 0) :
                // $respons1 = Theme::where("id", "=", $postID)->update(array('item_new' => $status));
                echo "OK";
            else :
                echo "Lỗi";
            endif;
        endif;
    }

    public function checkPassword(Request $request)
    {
        $request->current_password;
        if (!Hash::check($request->current_password, Auth::guard('admin')->user()->password)) {
            echo 'Mật khẩu hiện tại không chính xác';
        }
    }

    public function getPlace(Request $request)
    {
        $data = [
            'label' => 'Chọn Quận / Huyện',
            'options' => '',
            'name' => '',
            'class' => 'place_select',
            'type' => '',
            'child' => '',
            'item' => '',
            'hasDefaultOption' => true,
        ];

        if ($request->type == 'province') {
            $options = District::where('province_id', $request->id)->get();
            $data['label'] = 'Chọn Quận / Huyện';
            $data['options'] = $options;
            $data['name'] = 'district_id';
            $data['type'] = 'district';
            $data['child'] = 'ward';
        } elseif ($request->type == 'district') {
            $options = Ward::where('district_id', $request->id)->get();
            $data['label'] = 'Chọn Phường / Xã';
            $data['options'] = $options;
            $data['name'] = 'ward_id';
            $data['type'] = 'ward';
            $data['child'] = 'street';
        }
        return view('admin.partials.select-label', $data);
    }

    public function ajaxUpdateSort(Request $request)
    {
        $sort = $request->input('sort');
        if ($sort) {
            // Lưu thứ tự mới vào cơ sở dữ liệu
            foreach ($sort as $index => $id) {
                // Cập nhật thứ tự cho từng mục, giả sử bạn có model AlbumItem
                AlbumItem::find($id)->update(['sort' => $index]);
            }
            return response()->json(['Update success' => true]);
        } else {
            return response('404 data Not Found');
        }
    }
}

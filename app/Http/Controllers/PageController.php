<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Frontend\Category;
use App\Models\Frontend\Page;
use App\Models\Frontend\Product;
use Gornymedia\Shortcodes\Facades\Shortcode;
use Carbon\Carbon, Cart, Auth;

class PageController extends Controller
{
    use \App\Traits\LocalizeController;

    public $data = [];

    // $this->templatePath
    public function index()
    {
        $this->localized();
        $page = Page::where('slug', 'home')->first();
        $this->data['page'] = $page;
        // $this->data['news'] = \App\News::with('category')
        //     ->whereHas('category', function ($query) {
        //         return $query->where('id', 1);
        //     })
        //     ->where('status', 1)->orderbyDesc('id')->limit(4)->get();

        // MAIN MENU
        // $categories = Menu::getByName('Menu-main');
        // $this->data['categories'] = Category::where('status', 1)->where('parent', 0)->orderby('sort', 'DESC')->limit(4)->get();

        $this->data['categories'] = Category::where('status', 1)
            ->where('type', 'product')
            ->where('parent', 0)
            ->orderby('sort', 'asc')
            ->get();


        $this->data['products'] = Product::orderbyDesc('id')->limit(5)->get();

        // $this->data['flash_sale'] = (new Product)->FlashSale();

        $this->data['page'] = $page;

        $this->data['seo'] = [
            'seo_title' => $page->seo_title != '' ? $page->seo_title : $page->title,
            'seo_image' => $page->image,
            'seo_description'   => $page->seo_description ?? '',
            'seo_keyword'   => $page->seo_keyword ?? '',
        ];

        return view('frontend.home', $this->data)->compileShortcodes();
    }

    public function page($slug)
    {
        $this->localized();
        if ('home' == $slug || 'trangchu' == $slug) {
            return $this->index();
        }

        // $this->data['listLocation'] = $this->listLocation();

        $page = Page::where('slug', $slug)->first();

        if ($page) {
            // if ($page->template == 'project')
            //     return $this->project($slug);

            // if ($slug == 'about')
            //     return $this->about($slug);

            // if ($slug == 'product')
            //     return $this->product($slug);

            // if ($slug == 'news')
            //     return $this->news($slug);

            $this->data['seo'] = [
                'seo_title' => $page->seo_title != '' ? $page->seo_title : $page->title,
                'seo_image' => $page->image,
                'seo_description'   => $page->seo_description ?? '',
                'seo_keyword'   => $page->seo_keyword ?? '',
            ];

            $this->data['page'] = $page;
            $templateName = 'frontend.page.' . $slug;

            if (View::exists($templateName)) {
                return view($templateName,  $this->data)->compileShortcodes();
            } else {
                return view('frontend.page.index', ['data' => $this->data])->compileShortcodes();
            }
        } else {
            return view('errors.404');
        }
    }

    // public function news($slug)
    // {
    //     return \App::call('App\Http\Controllers\NewsController@index',  [
    //         "slug" => $slug
    //     ]);
    // }

    // public function product($slug)
    // {
    //     return \App::call('App\Http\Controllers\ProductController@index',  [
    //         "slug" => $slug
    //     ]);
    // }

    // public function about($slug)
    // {
    //     return \App::call('App\Http\Controllers\AboutController@index',  [
    //         "slug" => $slug
    //     ]);
    // }

    // public function project($slug)
    // {
    //     return \App::call('App\Http\Controllers\ProjectController@index',  [
    //         "slug" => $slug
    //     ]);
    // }

    public function listLocation()
    {
        $data = array(
            'mienbac'   => 'Miền Bắc',
            'mientrung'   => 'Miền Trung',
            'miennam'   => 'Miền Nam'
        );
        return $data;
    }
}

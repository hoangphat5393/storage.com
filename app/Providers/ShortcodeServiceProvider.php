<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Gornymedia\Shortcodes\Facades\Shortcode;
use Illuminate\Support\Facades\View;

class ShortcodeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Short code

        // Slider
        Shortcode::add('slider', function ($atts, $id, $items = 4) {

            $data = Shortcode::atts([
                'id' => $id,
                'items' => $items
            ], $atts);

            $slider = \App\Models\Frontend\Album::find($data['id']);
            // $image_list = \App\Models\AlbumItem::where('album_id', $data['id'])->limit($data['items'])->get();

            // dd($slider);

            $file = 'shortcode/slider'; // ex: resource/views/partials/ $atts['name'] .blade.php

            if (View::exists($file)) {
                return view($file, compact('data', 'slider'));
            }
        });

        Shortcode::add('image_list', function ($atts, $album_id, $limit = 3, $cols = 3) {

            $data = Shortcode::atts([
                'album_id' => $album_id,
                'limit' => $limit,
                'cols' => $cols,
            ], $atts);

            $maxGridColumns = 12;
            if ($data['cols'] == 1 || $data['cols'] == 2 || $data['cols'] == 3 || $data['cols'] == 4)
                $column = $maxGridColumns / $data['cols'];

            $data['column'] = $column;

            $file = 'shortcode/image_list'; // ex: resource/views/partials/ $atts['name'].blade.php

            if (view()->exists($file)) {
                return view($file, compact('data'));
            }
        });

        // Menu + Slider
        Shortcode::add('menu_slider', function ($atts, $id, $items = 3) {
            $data = Shortcode::atts([
                'id' => $id,
                'items' => $items
            ], $atts);

            $file = 'shortcode/menu_slider'; // ex: resource/views/partials/ $atts['name'] .blade.php

            if (View::exists($file)) {
                return view($file, compact('data'));
            }
        });

        // Menu + Banner
        Shortcode::add('menu_banner', function ($atts, $id, $slug = 'home') {
            $data = Shortcode::atts([
                'id' => $id,
                'slug' => $slug,
            ], $atts);

            // Bỏ giới hạn và chỉ phân trang
            $page = \App\Page::where('slug', $data['slug'])->first();

            $file = 'shortcode/menu_banner'; // ex: resource/views/partials/ $atts['name'] .blade.php

            if (View::exists($file)) {
                return view($file, compact('data', 'page'));
            }
        });

        // Menu
        Shortcode::add('menu_no_banner', function ($atts, $id) {
            $file = 'shortcode/menu_no_banner'; // ex: resource/views/partials/ $atts['name'] .blade.php
            return view($file);
        });

        // Video iframe
        Shortcode::add('video_iframe', function ($atts, $url) {

            $data = Shortcode::atts([
                'url' => $url
            ], $atts);

            $file = 'shortcode/video_iframe'; // ex: resource/views/partials/ $atts['name'] .blade.php
            if (View::exists($file)) {
                return view($file, compact('data'));
            }
        });
    }
}

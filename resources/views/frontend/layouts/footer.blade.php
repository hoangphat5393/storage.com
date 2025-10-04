@php
    $footerMenu = \App\Models\Frontend\Menu::where('name', 'Menu-footer')->first();
@endphp

@push('head-script')
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v20.0&appId=618631720113856" nonce="K6hMdU5v"></script>
@endpush
{{-- <div id="fb-root"></div> --}}

<footer class="footer-area">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="noidung">
                    <h2 class="footer-title">{{ setting_option('webtitle') }}</h2>
                    <p><strong><i>Thời gian hoạt động:</i></strong></p>
                    <p><i>Thứ 2 - Chủ Nhật: 8h - 18h30 (Kể cả các ngày Lễ - Tết)</i></p>
                    <p><u><strong>Địa chỉ:</strong></u> {{ setting_option('address') }}</p>
                    <p><a href="tel:{{ setting_option('phone') }}"><u><i>Hotline (Sỉ và Lẻ):</i></u> <strong>{{ setting_option('phone') }}</strong></a></p>
                    <p><a href="mailto:{{ setting_option('email') }}"><i>Email:</i> {{ setting_option('email') }}</a></p>
                    <p><i>Website:</i> {{ setting_option('website') }}</p>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <h2 class="tieude-footer">Chính sách hỗ trợ</h2>
                <ul class="list-unstyled">
                    @foreach ($footerMenu->items as $item)
                        <li>
                            <a href="{{ $item->link }}" title="{{ $item->label }}">{{ $item->label }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-3 col-sm-6">
                <h2 class="tieude-footer">Fanpage facebook</h2>

                {{-- <div class="fb-page" data-href="https://www.facebook.com/vattunongnghiepso58" data-tabs="timeline" data-width="278px" data-height="250px" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                    <blockquote cite="https://www.facebook.com/vattunongnghiepso58" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/vattunongnghiepso58">Cửa Hàng Vật Tư Nông Nghiệp Số 58</a></blockquote>
                </div> --}}

                <iframe title="{{ setting_option('webtitle') }}" src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fvattunongnghiepso58&tabs=timeline&width=278px&height=250px&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=1364612667725668" width="278px" height="250px" style="border:none;overflow:hidden" scrolling="no"
                    frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>

            </div>
        </div>
        <div id="copyright">Copyright © 2021 <strong>{{ setting_option('webtitle') }}</strong>. All rights reserved. Design by <strong>GetAtZ</strong></div>
    </div>
</footer>

<iframe title="{{ setting_option('webtitle') }}" src="{{ setting_option('google_map') }}" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>


{{-- Footer Start --}}
<footer id="footer" class="site-footer py-3 d-none">
    <div class="container">
        <!--START FOOTER-->
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-lg-3 text-center">
                    <a href="{{ route('page', 'donate') }}" class="btn btn-lg btn-warning text-white border-0 rounded-0" style="background: #ff8114;">
                        @lang('Donate now')
                    </a>
                </div>
            </div>
            <div class="footer__columns row my-4">
                @foreach ($footerMenu->items as $item)
                    <div class="col-md-6 col-lg-3 footer__column-links">
                        <h4 class="js-toggle-collapsed is-collapsed is-toggleable">{{ $item->label }}</h4>
                        <div class="menu-footer-1-tv-container">
                            <ul id="menu-footer" class="list-unstyled">
                                @foreach ($item->child as $item2)
                                    <li id="menu-item-1321" class="">
                                        <a href="{{ $item2->link }}">{{ $item2->label }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach

                <div class="col-md-6 col-lg-3 footer__column-social d-flex align-items-center align-items-lg-start">
                    <img src="{{ get_image(setting_option('logo_footer')) }}" class="img-fluid">
                </div>
            </div>

            <div class="row copyright justify-content-between">
                <div class="col-lg-auto">
                    <p>© 2018 OneHealth Foundation. All rights reserved.</p>
                </div>
                <div class="col-lg-auto">
                    <a href="{{ route('page', 'terms-of-service') }}" target="_blank">
                        @lang('Terms of Service')
                    </a> |
                    <a href="{{ route('page', 'privacy-policy') }}" target="_blank">
                        @lang('Privacy Policy')
                    </a>
                </div>
            </div>
        </div>
        <!--END FOOTER-->
    </div>
</footer>

@extends('frontend.layouts.master')

@section('seo')
    @include('frontend.layouts.seo', $seo ?? [])
@endsection

{{-- @section('body-class', 'page-template-default page page-id-1940') --}}

@php
    $lc = app()->getLocale();
@endphp


@push('head-script')
    <script>
        window.addEventListener("pageshow", () => {
            // update hidden input field
        });
    </script>

    {!! RecaptchaV3::initJs() !!}
@endpush


@section('content')
    <main id="main" class="contact">
        {{-- Menu --}}
        @include('frontend.includes.menu')

        <div class="container mt-4">
            <div class="row">
                <div class="col-lg-3 order-2 order-lg-1">
                    {{-- Category --}}
                    <div class="row main-cat mb-3">
                        @include('frontend.includes.left_sidebar')
                    </div>
                </div>

                <div class="col-lg-9 order-1 order-lg-2 mb-5 main-product contact-form">
                    <div class="row mb-3">

                        <div class="col-12">
                            <h3>LIÊN HỆ</h3>
                        </div>

                        <div class="col-md-7">
                            {!! htmlspecialchars_decode($page->content) !!}
                        </div>

                        <div class="col-md-5">

                            <form id="contact_form" method="post" action="{{ route('contact.submit') }}" novalidate="novalidate">
                                @csrf
                                {!! RecaptchaV3::field('contact') !!}
                                <p class="font-weight-bold">Nhập thông tin của bạn vào Form bên dưới để nhận tin từ chúng tôi!</p>
                                <div class="form-row">
                                    <div class="col-12 mb-3">
                                        <input type="text" class="form-control" name="contact[name]" placeholder="Họ và tên*">
                                    </div>

                                    <div class="col-12 mb-3">
                                        <input type="text" class="form-control" name="contact[address]" placeholder="Địa chỉ">
                                    </div>

                                    <div class="col-6 mb-3">
                                        <input type="text" class="form-control" name="contact[phone]" placeholder="Điện thoại*">
                                    </div>

                                    <div class="col-6 mb-3">
                                        <input type="text" class="form-control" name="contact[email]" placeholder="Email">
                                    </div>

                                    <div class="col-md-12">
                                        <textarea class="form-control" rows="6" name="contact[content]" placeholder="Lời nhắn"></textarea>
                                    </div>
                                </div>
                                <div class="form-row mt-3">
                                    <div class="col-md-12">
                                        <button type="reset" class="btn btn-danger">Nhập lại</button>
                                        <input type="submit" class="btn btn-danger" value="Gửi">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        // CONTACT
        var contact_form = $("#contact_form");
        // var lc = '{{ app()->getLocale() }}';
        var error_messages = {};

        error_messages = {
            "contact[name]": "Vui lòng điền tên!",
            "contact[email]": {
                required: "Vui lòng điền địa chỉ email!",
                email: "Vui lòng nhập địa chỉ email hợp lệ",
            },
            "contact[email_confirm]": {
                email: "Vui lòng nhập địa chỉ email hợp lệ",
                equalTo: "Email không khớp"
            },
            "contact[phone]": {
                required: "Vui lòng số điện thoại hợp lệ",
                number: "Vui lòng cung cấp số điện thoại hợp lệ!!",
                digits: "Vui lòng cung cấp số điện thoại hợp lệ!!",
                minlength: "Vui lòng cung cấp số điện thoại hợp lệ!!",
            },
            "contact[content]": {
                required: "Vui lòng nhập lời nhắn!",
                minlength: "Vui lòng nhập tối thiểu 10 ký tự!!",
            },
        }

        $(document).ready(function($) {
            contact_form.validate({
                onfocusout: false,
                onkeyup: false,
                onclick: false,
                rules: {
                    "contact[name]": "required",
                    "contact[email]": {
                        required: true,
                        email: true,
                    },
                    "contact[phone]": {
                        number: true,
                        digits: true,
                        minlength: 10,
                    },
                    "contact[content]": {
                        required: true,
                        minlength: 10,
                        maxlength: 200,
                    },
                },
                messages: error_messages,
                errorElement: "div",
                errorLabelContainer: ".errorTxt",
                invalidHandler: function(event, validator) {
                    $("html, body").animate({
                        scrollTop: contact_form.offset().top
                    }, 500);
                },
            });

            $('.btn-contact-submit').on('click', function(event) {
                if (contact_form.valid()) {
                    var form = document.getElementById('contact_form');
                    var fdnew = new FormData(form);
                    axios({
                        method: 'POST',
                        url: contact_form.prop("action"),
                        data: fdnew,
                    }).then(res => {
                        if (res.data.status == "success") {
                            console.log('success');
                            window.location.replace(contact_success);
                        } else {
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title: res.data.message,
                                // showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }).catch(e => console.log(e));
                }
            });
        });
    </script>
@endpush

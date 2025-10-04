@push('head-script')
    {!! RecaptchaV3::initJs() !!}
@endpush

<div class="container-fluid">

    <div class="row justify-content-center align-items-center bg-contact py-3">
        <div class="col-lg-5 mb-xl-0 mb-3">
            <div class="row justify-content-center">
                <div class="col-9 text-center">
                    <div id="carouselExampleControls" class="carousel slide text-center" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="{{ asset('images/thiet_ke_tieu_canh.jpg') }}" alt="First slide">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- FORM --}}
        <div class="col-lg-5">
            <fieldset class="reg-form">
                <legend class="text-center"><strong>ĐĂNG KÝ NHẬN TIN</strong></legend>
                {{-- <form method="post" action="{{ route('subscription') }}" id="subscribe_form" class="text-center"> --}}
                <form method="post" action="{{ route('contact.submit') }}" id="subscribe_form" class="text-center">
                    @csrf
                    {!! RecaptchaV3::field('contact') !!}
                    <p class="text-white">Nhập thông tin của bạn vào Form bên dưới để nhận tin từ chúng tôi!</p>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <input type="text" class="form-control" name="contact[name]" placeholder="Họ và tên*">
                                </div>
                                <div class="col-12 mb-3">
                                    <input type="text" class="form-control" name="contact[phone]" placeholder="Điện thoại*">
                                </div>
                                <div class="col-12 mb-3">
                                    <input type="text" class="form-control" name="contact[email]" placeholder="Email*">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <textarea class="form-control" rows="6" name="contact[content]" placeholder="Nội dung*"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning btn-contact">Đăng ký ngay</button>
                </form>
            </fieldset>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        // CONTACT
        var subscribe_form = $("#subscribe_form");
        var error_messages = {};

        error_messages = {
            "contact[name]": "Vui lòng điền tên!",
            "contact[email]": {
                required: "Vui lòng điền địa chỉ email!",
                email: "Vui lòng nhập địa chỉ email hợp lệ",
            },
            // "contact[email_confirm]": {
            //     email: "Vui lòng nhập địa chỉ email hợp lệ",
            //     equalTo: "Email không khớp"
            // },
            "contact[phone]": {
                required: "Vui lòng số điện thoại hợp lệ",
                number: "Vui lòng cung cấp số điện thoại hợp lệ!!",
                digits: "Vui lòng cung cấp số điện thoại hợp lệ!!",
                minlength: "Vui lòng cung cấp số điện thoại hợp lệ!!",
            },
            "contact[content]": "Vui lòng nhập lời nhắn!"
        }

        subscribe_form.validate({
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
                "contact[content]": "required",
            },
            messages: error_messages,
            errorElement: "div",
            errorLabelContainer: ".errorTxt",
            invalidHandler: function(event, validator) {
                $("html, body").animate({
                        scrollTop: subscribe_form.offset().top
                    },
                    500
                );
            },
        });
    </script>
@endpush



@push('scripts')
    <script>
        // CONTACT
        var contact_form = $("#subscription_form");
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
            "contact[subject]": "Vui lòng điền tiêu đề",
            "contact[content]": "Vui lòng nhập lời nhắn!"
        }

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
                // "contact[email_confirm]": {
                //     email: true,
                //     equalTo: "#cf-email"
                // },
                "contact[phone]": {
                    number: true,
                    digits: true,
                    minlength: 10,
                },
                "contact[subject]": "required",
                "contact[content]": "required",
            },
            messages: error_messages,
            errorElement: "div",
            errorLabelContainer: ".errorTxt",
            invalidHandler: function(event, validator) {
                $("html, body").animate({
                        scrollTop: contact_form.offset().top
                    },
                    500
                );
            },
        });
    </script>
@endpush

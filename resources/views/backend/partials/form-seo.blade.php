<div class="card card-success card-outline mb-4">

    {{-- card-header --}}
    <div class="card-header">
        <h3 class="card-title">SEO</h3>
    </div>

    <div class="card-body">

        {{-- SEO Title --}}
        <div class="mb-3">
            <label for="seo_name" class="form-label">SEO Title</label>
            <input type="text" id="seo_title" name="seo_title" class="form-control" value="{{ $seo_title ?? '' }}">
            <div class="form-text text-success pd_lender">
                <span id="char_title" class="text-danger fw-bold"></span> characters, Max <b>70</b> characters
            </div>
        </div>

        {{-- SEO Keyword --}}
        <div class="mb-3">
            <label for="seo_keyword" class="form-label">SEO Keyword</label>
            <input type="text" id="seo_keyword" name="seo_keyword" class="form-control" value="{{ $seo_keyword ?? '' }}">
            <div class="form-text text-success pd_lender">
                <span id="char_keyword" class="text-danger fw-bold"></span> characters
            </div>
        </div>

        {{-- SEO Description --}}
        <div class="mb-3">
            <label for="seo_description" class="form-label">SEO Description</label>
            <textarea id="seo_description" name="seo_description" class="form-control" rows="4">{{ $seo_description ?? '' }}</textarea>
            <div class="form-text text-success pd_lender">
                <span id="char_description" class="text-danger fw-bold"></span> characters, Max <b>150-160</b> characters
            </div>
        </div>

    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $(function() {
            $('#seo_title').bind('input keyup keydown keypress', function() {
                var charCount1 = $(this).val().replace(/\s/g, '').length;
                $("#char_title").text(charCount1);
            });
            $('#seo_keyword').bind('input keyup keydown keypress', function() {
                var charCount2 = $(this).val().replace(/\s/g, '').length;
                $("#char_keyword").text(charCount2);
            });
            $('#seo_description').bind('input keyup keydown keypress', function() {
                var charCount3 = $(this).val().replace(/\s/g, '').length;
                $("#char_description").text(charCount3);
            });
        });
    </script>
@endpush

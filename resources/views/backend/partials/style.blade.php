<div class="card">
    <div class="card-header">Style</div>
    <div class="card-body">
        {{-- Head style --}}
        <div class="form-group">
            <label for="seo_description">Head Style</label>
            <textarea id="head" name="head" class="form-control" rows="5">{{ $head ?? '' }}</textarea>
            {{-- <div class="clear pd_lender" style="font-size:14px;color:#060;">
                <span id="char_description" style="color:#F00; font-weight:bold;"></span> character, Max <b>150-160</b> characters
            </div> --}}
        </div>

        {{-- Body style --}}
        <div class="form-group">
            <label for="seo_description">Body Style</label>
            <textarea id="body" name="body" class="form-control" rows="5">{{ $body ?? '' }}</textarea>
            {{-- <div class="clear pd_lender" style="font-size:14px;color:#060;">
                <span id="char_description" style="color:#F00; font-weight:bold;"></span> character, Max <b>150-160</b> characters
            </div> --}}
        </div>
    </div>
</div>

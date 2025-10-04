<div class="card">
    <div class="card-header">
        <h5>{{ $title ?? 'Video' }}</h5>
    </div>
    <div class="card-body">
        <div class="input-group">
            <div class="input-group">
                <input type="text" class="form-control" name="{{ $name ?? 'image' }}" id="{{ $name ?? 'image' }}" value="{{ $url }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary ckfinder-popup" type="button" id="{{ $id ?? 'img' }}" data-show="{{ $id ?? 'img' }}_view" data="{{ $name ?? 'image' }}">Upload</button>
                </div>
            </div>
        </div>
        <div class="demo-img" style="padding-top: 10px;">
            {{-- <img class="{{ $id ?? 'img' }}_view" src="{{ get_image($image) }}"> --}}

            @if ($url)
                <video controls="control" class="w-100">
                    <source class="{{ $id ?? 'img' }}_view" src="{{ get_image($url) }}" type="video/mp4" />
                </video>
            @endif

        </div>
    </div> <!-- /.card-body -->
</div><!-- /.card -->

<div class="card card-warning card-outline mb-4">

    <div class="card-header">
        <h5 class="card-title">{{ $title ?? 'Image Thumbnail' }}</h5>
    </div>

    <div class="card-body">
        <div class="input-group">
            <input type="text" class="form-control" name="{{ $name ?? 'image' }}" id="{{ $name ?? 'image' }}" value="{{ $image }}">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary ckfinder-popup" type="button" id="{{ $id ?? 'img' }}" data-show="{{ $id ?? 'img' }}_view" data="{{ $name ?? 'image' }}">Upload</button>
            </div>
        </div>
        <div class="demo-img" style="padding-top: 10px;">
            <img class="{{ $id ?? 'img' }}_view img-fluid" src="{{ get_image($image) }}">
        </div>
    </div>
</div>

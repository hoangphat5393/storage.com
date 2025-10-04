<div class="card">

    <div class="card-header">
        <h5>{{ $title ?? 'PDF File' }}</h5>
    </div>

    <div class="card-body">
        <div class="input-group">
            <input type="text" class="form-control" name="{{ $name ?? 'profile' }}" id="{{ $name ?? 'profile' }}" value="{{ $image }}">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary ckfinder-popup" type="button" id="{{ $id ?? 'img' }}" data-show="{{ $id ?? 'img' }}_view" data="{{ $name ?? 'profile' }}">Upload</button>
            </div>
        </div>

        <div class="demo-img" style="padding-top: 10px;">
            <object data="{{ $image }}" type="application/pdf" width="100%" height="500px" class="{{ $id ?? 'img' }}_view">
                <p>
                    Unable to display PDF file.
                    <a href="{{ $image }}">Download</a> instead.
                </p>
            </object>
        </div>
    </div>
</div>

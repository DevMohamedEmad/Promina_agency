@extends('layouts.app')

@section('custom-script')
<script>
    function addInputImage() {
        $('#images_div').append('<input type="file" class="form-control" name="new_images[]">');
    }

    function removeAlbumImg(x) {
        imageId = x.attributes['image-id'].value;
        $('#update_album_form').append(`<input type="hidden" value= ${imageId} name="deleted_images[]">`);
        $(x).closest(".card").remove();
    }

    $(document).ready(function() {});
</script>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <form id="update_album_form" action="{{route('albums.update')}}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <input type="hidden" name="album_id" value="{{$album->id}}">
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" value="{{ $album->name }}" placeholder="{{ $album->name }}">
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">Images</label>
                </div>
                <div class="row">
                    @foreach ($album->images as $image)
                    <div div class="col-sm-4">
                        <div class="card" style="width: 18rem;">
                            <img src="{{ asset(ALBUM_STORAGE_PATH.$image->image_name) }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <button onclick="removeAlbumImg(this); return false;" class="btn btn-light d-flex" image-id="{{$image->id}}">
                                    <i class="fa-2x fa-solid fa-trash"></i>Delete
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">Images</label>
                    <button id="addImageBtn" onclick="addInputImage(); return false;">
                        Add image
                    </button>
                </div>
                <div id="images_div"></div>
                <div>
                    <button class="btn btn-success" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
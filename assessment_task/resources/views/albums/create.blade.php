@extends('layouts.app')

@section('custom-script')
<script>
    function addInputImage() {
        $('#images_div').append('<input type="file" class="form-control" name="images[]">');
    }
    $(document).ready(function() {});
</script>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <form id="new_album_form" action="{{route('albums.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Example input placeholder">
                </div>

                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">Images</label>
                    <button id="addImageBtn" onclick="addInputImage();return false">
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
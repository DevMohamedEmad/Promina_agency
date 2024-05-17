@extends('layouts.app')

@section('custom-script')
<script>
    $(document).ready(function() {});
</script>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" placeholder="{{$album->name}}" readonly>
            </div>

            <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label">Images</label>
            </div>

            <div class="row">
                @foreach ($album->images as $image)
                <div div class="col-sm-4">
                    <div class="card" style="width: 18rem;">
                        <img src="{{ asset(ALBUM_STORAGE_PATH.$image->image_name) }}" class="card-img-top" alt="...">
                    </div>
                </div>
                @endforeach
            </div>

            <div>
                <a href="{{route('home')}}">
                    <button class="btn btn-light">Back</button>
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
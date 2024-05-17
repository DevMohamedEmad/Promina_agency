@extends('layouts.app')
@section('custom-script')

<script>
    function checkIfAlbumNotEmpty(album_images_counter) {
        console.log(album_images_counter)
        if (album_images_counter > 0) {
            $('#CheckIfAlbumImagesDelete').modal('show');
        } else {
            submitDeleteForm();
        }
    }

    function submitDeleteForm() {
        $('#js_delete_album_function').submit();
    }

    function sendNewAlbum(input){
        $('#assign_images_to_another_album_id').val($(input).val());
    }

    function chooseAlbum() {

        console.log($("#selected_album_id").length);

        $.ajax({
            url: '{{ route("getAlbums") }}',
            type: 'Post',
            data: {
                '_token': "{{ csrf_token() }}",
                'expected_album_id': $('#album_id').val(),
            },
            dataType: 'json',
            success: function(data) {
                $.each(data, function(index, option) {
                    $('#selected_album_id').append(new Option(option, index,true ,true));
                    $('#assign_images_to_another_album_id').val(index);
                });
            },
            error: function(xhr, status, error) {}
        });

        $('#choose_album').modal('show')
    }
</script>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                </div>
                <div class="d-flex">
                    <a href="{{route('albums.create')}}">
                        <button type="button" class="ms-6 btn btn-secondary">Create New Album</button>
                    </a>

                </div>
                <div class="table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($userAlbums as $album)

                            <tr>
                                <th scope="row">{{ $album->id }}</th>
                                <td>{{ $album->name }}</td>
                                <td class="d-flex" style="gap: .75rem;">
                                    <div>
                                        <a href='{{route("albums.show" , $album->id )}}'>
                                            <i class="fa-2x fa-solid fa-eye"></i>
                                        </a>
                                    </div>

                                    <div>
                                        <a href='{{route("albums.edit" , $album->id )}}'>
                                            <i class="fa-2x fa-solid fa-pen-to-square"></i>
                                        </a>
                                    </div>

                                    <div>
                                        <form action="{{route('albums.delete')}}" method="post" id="js_delete_album_function">
                                            @csrf
                                            <input type="hidden" name="album_id" id="album_id" value="{{$album->id}}">
                                            <input type="hidden" name="assign_images_to_another_album_id" id="assign_images_to_another_album_id">
                                        </form>
                                        <button type="button" class="btn btn-primary" onclick="checkIfAlbumNotEmpty({{$album->album_images_counter}})">
                                            Delete
                                        </button>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('albums.modal_check_if_album_images_delete');
@include('albums.choose_album');
@endsection
<style>
    body {
        align-items: center;
        /* padding-top: 40px; */
        padding-bottom: 40px;
        background-color: #f5f5f5;
    }

    .form-signin {
        max-width: 700px;
        padding: 15px;
    }

    .baseImage {
        width: 150px;
        height: 150px;
    }



    .remove {
        display: block;
        background: #444;
        border: 1px solid black;
        color: white;
        text-align: center;
        cursor: pointer;
    }

    .remove:hover {
        background: white;
        color: black;
    }

    input[type="file"] {
        display: block;
    }

    .imageThumb {
        max-height: 75px;
        border: 2px solid;
        padding: 1px;
        cursor: pointer;
    }

    .pip {
        display: inline-block;
        margin: 10px 10px 0 0;
    }
</style>
<x-layout>
    <div class="form-signin w-100 m-auto text-center">
        <form method="POST" action="/posts/{{ $post->id }}/put" id="editPostFom" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <img class="mb-4"
                src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/36/Logo.min.svg/2560px-Logo.min.svg.png"
                alt="" height="57">
            <h1 class="h3 mb-3 fw-normal">Please Edit Post</h1>

            <div class="form-floating">
                <input type="text" class="form-control" name="title" id="title" value="{{ $post->title }}">
                <label for="floatingInput">Title</label>

                <div class="errorTxt text-left text-laravel">
                </div>

                {{-- @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror --}}
            </div>

            <div class="form-floating">


                <select name="categories" id="categories" class="form-control" value="Sport">

                    <option value="Science" {{ $post->categories == 'Science' ? 'selected' : null }}>Science</option>
                    <option value="Politics" {{ $post->categories == 'Politics' ? 'selected' : null }}>Politics</option>
                    <option value="Sport" {{ $post->categories == 'Sport' ? 'selected' : null }}>Sport</option>
                </select>
                <label for="categories">Choose a Category:</label>


                {{-- @error('categories')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror --}}
            </div>

            <div class="form-floating mb-4">

                <textarea class="form-control" name="content" id="content">{{ $post->content }}</textarea>
                <label for="content">Post Content</label>

                <div class="errorTxt text-left text-laravel">
                </div>
                {{-- @error('content')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror --}}
            </div>

            <div class="text-left">
                <p>Activate/Deactivate Post:</p>

                <input type="radio" name="status" value="1" {{ $post->status == '1' ? 'checked' : '' }}>
                <label for="status">Activate</label><br>
                <input type="radio" name="status" value="0" {{ $post->status == '0' ? 'checked' : '' }}>
                <label for="status">Deactivate</label><br>
            </div>


            <div class="mb-4 text-left">
                <label for="image[]" class="mb-2">Image</label>
                <input id="files" type="file" class="border border-gray-200 rounded p-2 w-full" name="image[]"
                    accept="image/*" multiple />
                <div id="gallery"></div>


                {{-- @error('image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror --}}
            </div>

            @if ($post->images)

                @foreach (explode('|', $post->images) as $image)
                    <span class="pip">
                        <img class="m-2 baseImage inline" src="{{ asset('storage/images/' . $image) }}"
                            alt="" />
                        <br />
                        <span class="remove">Remove Image</span>
                    </span>
                    {{-- <img class="m-2 baseImage inline" src="{{ asset('storage/images/' . $image) }}" alt="" /> --}}
                @endforeach
            @endif




            <div class="form-floating">
                <input type="text" class="form-control" name="embed" id="embed"
                    value="https://www.youtube.com/watch?v={{ $post->embed }}">
                <label for="floatingInput">Youtube
                    Video</label>

                {{-- @error('embed')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror --}}
            </div>

            <button class="block m-auto mt-2 bg-laravel text-white rounded py-2 px-4 hover:bg-black"
                type="submit">Publish
                Post</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2022</p>
        </form>
    </div>
</x-layout>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
    integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    var array = Array();

    $('#editPostFom').validate({
        rules: {
            title: 'required',
            contents: 'required',

        },
        messages: {
            title: 'This field is required',
            content: 'This field is required',


        },
        errorElement: 'div',
        errorLabelContainer: '.errorTxt',
        submitHandler: function(form) {
            EditPost();
        }
    });

    function EditPost() {
        var fd = new FormData();

        var ins = document.getElementById('files').files.length;
        for (var x = 0; x < ins; x++) {
            fd.append("image[]", document.getElementById('files').files[x]);
        }
        // var totalfiles = document.getElementById('files').files.length;
        // for (var index = 0; index < totalfiles; index++) {
        //     array.push(document.getElementById('files').files[index]);
        // }

        fd.append('deletedImages', array);
        fd.append('title', $('#title').val());
        fd.append('content', $('#content').val());
        fd.append('categories', $('#categories').val());
        // fd.append('files', array);
        fd.append('embed', $('#embed').val());
        fd.append('status', $('input[name="status"]:checked').val());
        fd.append('_method', 'PUT');
        fd.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: "/posts/{{ $post->id }}/put",
            type: "POST",
            processData: false,
            contentType: false,
            data: fd,
            success: function(response) {
                location.href = "{{ url('/') }}";
            },
            error: function(err) {

            }
        });
    }


    $(".remove").on("click", function() {
        $(this).parent('.pip').remove();

        $imgURL = $(this).parent().find('img').attr('src');
        $lastSlash = $imgURL.lastIndexOf("/");
        $imgName = ($imgURL.substring($lastSlash + 1, $imgURL.length));
        array.push($imgName);

    });


    $(document).ready(function() {
        if (window.File && window.FileList && window.FileReader) {
            $("#files").on("change", function(e) {
                $('#gallery').empty();

                var files = Array.from(e.target.files);
                filesLength = files.length;
                for (var i = 0; i < filesLength; i++) {
                    $(this).parent(".pip").remove();

                    var f = files[i]
                    var fileReader = new FileReader();
                    fileReader.onload = (function(e) {
                        var file = e.target;
                        $("<span class=\"pip\">" +
                            "<img class=\"imageThumb\" src=\"" + e
                            .target.result +
                            "\" title=\"" + file.name + "\"/>" +
                            // "<br/><span class=\"remove\">Remove image</span>" +
                            "</span>").appendTo('#gallery');
                        // $(".remove").click(function() {
                        //     $(this).parent(".pip").remove();
                        //     removeFileFromFileList(i, e);

                        // });
                    });
                    fileReader.readAsDataURL(f);
                }
            });
        } else {
            alert("Your browser doesn't support to File API")
        }
    });
</script>

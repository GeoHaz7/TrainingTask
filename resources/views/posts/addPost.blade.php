<x-layout>
    <div class="form-post w-100 m-auto text-center">
        <form id="addPostForm" method="POST" action="/posts/add" enctype="multipart/form-data">
            @csrf

            <img class="mb-4"
                src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/36/Logo.min.svg/2560px-Logo.min.svg.png"
                alt="" height="57">

            <h1 class="h3 mb-3 fw-normal">Please Create A Post</h1>

            <div class="form-floating">
                <input id="title" type="text" class="form-control" name="title" value="">
                <label for="floatingInput">Title</label>

                <div class="errorTxt text-left text-laravel">
                </div>
            </div>

            <div class="form-floating">
                <select id="categories" name="categories" class="form-control" value="Sport">
                    <option value="Science">Science</option>
                    <option value="Politics">Politics</option>
                    <option value="Sport">Sport</option>
                </select>
                <label for="categories">Choose a Category:</label>

            </div>



            <div class="form-floating mb-2">
                {{-- <label for="content">Post Content</label> --}}
                <textarea id="content" class="ckeditor form-control" name="content"></textarea>

                <div class="errorTxt text-left text-laravel">
                </div>
            </div>

            <div class="mb-4 text-left">
                <label for="image[]" class="mb-2">Image</label>
                <input id="files" type="file" class="border border-gray-200 rounded p-2 w-full" name="image[]"
                    accept="image/*" multiple />
                <div id="gallery"></div>
            </div>

            <div class="mb-4 text-left">
                <label for="pdf" class="mb-2">Pdf</label>
                <input id="pdf" type="file" class="border border-gray-200 rounded p-2 w-full" name="pdf"
                    accept="application/pdf" />
            </div>

            <div class="form-floating">
                <input id="embed" type="text" class="form-control" name="embed" value="">
                <label for="floatingInput">Youtube Video</label>

            </div>

            <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black" type="submit">Publish Post</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2022</p>
        </form>
    </div>
</x-layout>



<script>
    $('#addPostForm').validate({
        rules: {
            title: 'required',
            content: 'required',

        },
        messages: {
            required: 'This field is required',


        },
        errorElement: 'div',
        errorPlacement: function(error, element) {
            error.insertAfter(element.parent());
        },
        submitHandler: function(form) {
            AddPost();
        }
    });

    function AddPost() {
        var fd = new FormData();

        var ins = document.getElementById('files').files.length;
        for (var x = 0; x < ins; x++) {
            fd.append("image[]", document.getElementById('files').files[x]);
        }

        fd.append('title', $('#title').val());
        fd.append('content', $('#content').val());
        fd.append('categories', $('#categories').val());
        fd.append('pdf', $('#pdf')[0].files[0]);
        fd.append('embed', $('#embed').val());
        fd.append('status', $('input[name="status"]:checked').val());
        fd.append('_token', '{{ csrf_token() }}');

        console.log($('#embed').val());
        $.ajax({
            url: "/posts/add",
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
                            "<img class=\"imageThumb\" src=\"" + e.target.result +
                            "\" title=\"" + file.name + "\"/>" +
                            "</span>").appendTo('#gallery');

                    });
                    fileReader.readAsDataURL(f);
                }
            });
        } else {
            alert("Your browser doesn't support to File API")
        }
    });
</script>

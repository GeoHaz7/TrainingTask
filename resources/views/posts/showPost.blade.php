<x-layout class="justify-center">
    <div class="p-5">
        <div class=" overflow-hidden bg-gray-50 border border-gray-200 rounded mb-3 p-2">

            <h3 class="text-2xl mb-2 inline">{{ $post->title }}</h3>
            <div class="text-xl font-bold mb-4 inline">By {{ $post->user->name }}
                {!! $post->status ? '<i class="fa-solid fa-toggle-on"></i>' : '<i class="fa-solid fa-toggle-off"></i>' !!}
            </div>
            @auth
                @if (auth()->user()->isAdmin || $post->user->id == auth()->user()->id)
                    <div class="float-right">
                        <a href="/posts/{{ $post->id }}/edit" class="text-blue-400 px-6 py-2 rounded-xl "><i
                                class="fa-solid fa-pen-to-square"></i>
                            Edit</a>

                        <button data-id="{{ $post->id }}" class="text-red-500 deletePost"><i
                                class="fa-solid fa-trash"></i>
                            Delete</button>
                    </div>
                @endif
            @endauth
            <div>
                <p class="text-xl font-bold mb-1 ">{{ $post->categories }}</p>
                <h5 class="mb-3">{{ $post->updated_at ? $post->updated_at : $post->created_at }}</h5>
                <p class="mt-3">{{ $post->content }}</p>

            </div>

            {!! $post->embed
                ? '<iframe class="inline mr-6" width="600" height="400" src="https://www.youtube.com/embed/' .
                    $post->embed .
                    '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
                : '' !!}


            <div class="inline">
                @if ($post->images)
                    @foreach (explode('|', $post->images) as $image)
                        <img class=" m-6  {{ 'postImages' }} inline" src="{{ asset('storage/images/' . $image) }}"
                            alt="" />
                    @endforeach

                @endif

            </div>

            @if ($post->pdf)
                <div class="inline">
                    <<embed src="{{ asset('storage/pdf/' . $post->pdf) }}" width="300" height="300"
                        alt="pdf" />



                </div>
            @endif


            <p class="float-right bottom-0 block">
                @if (Auth::User()?->isAdmin)
                    {{ count($post->comments) }}
                @else
                    {{ $post->comments->where('status', 1)->count() }}
                @endif
                Comments
            </p>
        </div>

        <button class="block ml-auto mb-2 bg-laravel text-white rounded py-2 px-4 hover:bg-black" data-bs-toggle="modal"
            data-bs-target="#exampleModal">Add
            Comment</button>

        <div id="exampleModal" class="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addCommentForm" method="POST" action="/posts/{{ $post->id }}/comment">
                            @csrf
                            {{-- @if (!Auth::check()) --}}
                            <div class="text-left mb-2">
                                <p>Show Name:</p>
                                <input id="showName" type="radio" name="showName" value="1" checked>
                                <label for="showName">Yes</label><br>
                                <input type="radio" name="showName" value="0">
                                <label for="showName">No</label><br>
                            </div>
                            {{-- @endif --}}

                            @if (Auth::user())
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ Auth::user()->name }}" readonly>
                                    <label for="floatingInput">Name</label>
                                </div>
                            @else
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="">
                                    <label for="floatingInput">Name</label>
                                </div>
                            @endif

                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" name="content" id="content" value="">
                                <label for="floatingInput">Comment</label>
                            </div>
                            <button class="  mt-2 bg-laravel text-white rounded py-2 px-4 hover:bg-black inline"
                                data-bs-dismiss="modal">Cancel</button>
                            <button class="mt-2 bg-laravel text-white rounded py-2 px-4 hover:bg-black inline"
                                type="submit">Publish Comment</button>
                        </form>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>


        @foreach ($post->comments as $comment)
            @if (Auth::user()?->isAdmin)
                <div class="bg-gray-50 border border-gray-200 rounded mb-3 p-2">

                    <div class="text-xl font-bold mb-4 inline">By {{ $comment->name }}
                    </div>
                    <h5 class="mb-3">{{ $comment->created_at }}</h5>
                    <p class="mt-3">{{ $comment->content }}</p>
                </div>
            @else
                @if ($comment->status)
                    <div class="bg-gray-50 border border-gray-200 rounded mb-3 p-2">

                        <div class="text-xl font-bold mb-4 inline">By {{ $comment->name }}
                        </div>
                        <h5 class="mb-3">{{ $comment->created_at }}</h5>
                        <p class="mt-3">{{ $comment->content }}</p>
                    </div>
                @endif
            @endif
        @endforeach
    </div>
</x-layout>


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
    integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $("input[name=showName]").change(function() {

        if ($("#showName").is(':checked')) {
            $("#name").show();
        } else {
            $("#name").hide();
        }
    });


    $('.deletePost').on('click', function() {
        id = $(this).data('id');
        // var fd = new FormData();
        // fd.append('_method', 'DELETE');
        // fd.append('_token', '{{ csrf_token() }}');
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure you want to delete this record?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: "/manage/posts/{{ $post->id }}/delete",
                    type: "DELETE",
                    data: {
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(response, textStatus, xhr) {
                        Swal.fire({
                            icon: 'success',
                            title: response,
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'Yes'
                        }).then((result) => {
                            if (response == 'success') {
                                $('.trr' + id).hide();
                            }
                            location.href = "{{ url('/') }}";
                        });
                    }
                });
            }
        })
    });

    $('#addCommentForm').validate({
        rules: {
            content: 'required',
            name: {
                required: '#showName[value="1"]:checked'
            }

        },
        messages: {
            required: 'This field is required',


        },
        errorElement: 'div',
        errorPlacement: function(error, element) {
            error.insertAfter(element.parent());
        },
        submitHandler: function() {
            var fd = new FormData();

            fd.append('showName', $('input[name="showName"]:checked').val());
            fd.append('name', $('#name').val());
            fd.append('content', $('#content').val());
            fd.append('post_id', '{{ $post->id }}');
            fd.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: "/posts/{{ $post->id }}/comment",
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
    });
</script>

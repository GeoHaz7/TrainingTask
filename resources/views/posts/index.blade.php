<x-layout class="justify-center">
    @if (Auth::check())
        <div class="pl-10 pr-10">
            <h1 class="text-2xl">Here are the avalible posts:</h1>
            <a href="/posts/add" class="bg-bluez text-white rounded py-2 px-4 hover:bg-black float-right"><i
                    class="fa-solid fa-pen"></i>
                New Post</a>
        </div>
    @endif
    <div class="p-5">
        @if (!$posts->isEmpty())
            @foreach ($posts as $post)
                <div class=" overflow-hidden bg-gray-50 border border-gray-200 rounded mb-3 p-2 divv{{ $post->id }}">

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
                                        class="fa-solid fa-trash"></i> Delete</button>
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
                            <img class=" mr-6  {{ 'baseImage' }} inline"
                                src="{{ asset('storage/images/' . explode('|', $post->images)[0]) }}" alt="" />
                        @endif

                        @if (count(explode('|', $post->images)) > 1)
                            <div type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                class=" inline text-center items-center align-center border-solid border-4 p-10">
                                + {{ count(explode('|', $post->images)) - 1 }}
                            </div>
                        @endif
                    </div>

                    @if ($post->pdf)
                        <div class="inline">
                            <a href="{{ asset('storage/pdf/' . $post->pdf) }}"><img id="pdfFile" class="block ml-6"
                                    src="https://www.woschool.com/wp-content/uploads/2020/09/png-transparent-pdf-icon-illustration-adobe-acrobat-portable-document-format-computer-icons-adobe-reader-file-pdf-icon-miscellaneous-text-logo.png"
                                    width="150" height="100" alt="pdf" /></a>

                        </div>
                    @endif


                    <button id="like{{ $post->id }}" data-id="{{ $post->id }}"
                        class="likePost float-right ml-3 bottom-0 block">
                        <i class="fa-regular fa-thumbs-up"></i> Like
                    </button>
                    <button id="dislike{{ $post->id }}" data-id="{{ $post->id }}"
                        class="dislikePost float-right ml-3 bottom-0 block">
                        <i class="fa-regular fa-thumbs-down"></i> Dislike
                    </button>


                    <a href="/posts/{{ $post->id }}/show">
                        <p class="float-right bottom-0 block">
                            @if (Auth::User()?->isAdmin)
                                {{ count($post->comments) }}
                            @else
                                {{ $post->comments->where('status', 1)->count() }}
                            @endif
                            Comments
                        </p>
                    </a>



                    <!-- Modal -->
                    <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title text-2xl" id="exampleModalLabel">Post Images:</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">

                                            @foreach (explode('|', $post->images) as $image)
                                                @if ($loop->first)
                                                    <div class="carousel-item active">
                                                        <img class=" carouselItem"
                                                            src="{{ asset('storage/images/' . $image) }}"
                                                            alt="First slide">
                                                    </div>
                                                    @continue
                                                @endif
                                                <div class="carousel-item">
                                                    <img class=" carouselItem"
                                                        src="{{ asset('storage/images/' . $image) }}"
                                                        alt="First slide">
                                                </div>
                                            @endforeach

                                        </div>
                                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                                            data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                                            data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class=" bg-bluez text-white rounded py-2 px-4 hover:bg-black"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <h1 class="text-3xl font-bold mb-4">No Posts Found</h1>

        @endif
    </div>

    <div class="mt-2 p-4">
        {{ $posts->links() }}
    </div>

</x-layout>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "/likes",
            type: "GET",
            data: {
                '_token': '{{ csrf_token() }}'
            },
            success: function(response) {
                response.forEach(post => {
                    $('#' + 'like' + post.id).html(
                        '<i class="fa-solid fa-thumbs-up"></i> Liked')
                });
            },
            error: function(err) {

            }
        });

        $.ajax({
            url: "/dislikes",
            type: "GET",
            data: {
                '_token': '{{ csrf_token() }}'
            },
            success: function(response) {
                response.forEach(post => {
                    $('#' + 'dislike' + post.id).html(
                        '<i class="fa-solid fa-thumbs-down"></i> Disliked')
                });
            },
            error: function(err) {

            }
        });

        $('.likePost').on('click', function() {
            id = $(this).data('id');

            $.ajax({
                url: "/posts/" + id + "/like",
                type: "GET",
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response == 'like') {
                        $('#' + 'like' + id).html(
                            '<i class="fa-solid fa-thumbs-up"></i> Liked')
                        $('#' + 'dislike' + id).html(
                            '<i class="fa-regular fa-thumbs-down"></i> Dislike')
                    } else if (response == 'unlike') {
                        $('#' + 'like' + id).html(
                            '<i class="fa-regular fa-thumbs-up"></i> Like')
                    }

                },
                error: function(err) {

                }
            });
        })
        $('.dislikePost').on('click', function() {
            id = $(this).data('id');

            $.ajax({
                url: "/posts/" + id + "/dislike",
                type: "GET",
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response == 'dislike') {
                        $('#' + 'dislike' + id).html(
                            '<i class="fa-solid fa-thumbs-down"></i> Disliked')
                        $('#' + 'like' + id).html(
                            '<i class="fa-regular fa-thumbs-up"></i> Like')
                    } else if (response == 'undislike') {
                        $('#' + 'dislike' + id).html(
                            '<i class="fa-regular fa-thumbs-down"></i> Dislike')
                    }

                },
                error: function(err) {

                }
            });
        })

        $('.deletePost').on('click', function() {
            id = $(this).data('id');
            $.ajax({
                url: "/manage/posts/" + id + "/delete",
                type: "DELETE",
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response == 'success') {
                        $('.divv' + id).hide();
                    }
                },
                error: function(err) {

                }
            });

        });
    })
</script>

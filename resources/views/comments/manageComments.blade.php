<x-layout>
    <div class="p-4">
        <header>
            <h1 class="text-3xl text-center font-bold my-6 uppercase">
                Manage Comments
            </h1>
        </header>

        <table class="w-full table-auto rounded-sm">
            <tbody>

                @if ($comments->isEmpty())
                    <tr class="border-gray-300">
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            <p class="text-center">No Comments Found</p>
                        </td>
                    </tr>
                @else
                    @foreach ($comments as $comment)
                        <tr class="border-gray-300 trr{{ $comment->id }}">
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <div class="bg-gray-50 border border-gray-200 rounded mb-3 p-2">

                                    <div class="text-xl font-bold mb-4 inline">By {{ $comment->name }} on Post :
                                        {{ $comment->post->title }}
                                    </div>
                                    {{-- <div>
                                        {!! $comment->status ? '<i class="fa-solid fa-toggle-on"></i>' : '<i class="fa-solid fa-toggle-off"></i>' !!}
                                    </div> --}}
                                    <p class="mb-3">
                                        {{ $comment->created_at }}</p>
                                    <p class="mt-3">{{ $comment->content }} </p>
                                </div>

                            </td>

                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">

                                <button id="{{ $comment->id }}" data-id="{{ $comment->id }}"
                                    class="text-red-500 toggleComment">
                                    {!! $comment->status ? '<i class="fa-solid fa-x"></i> Disable' : '<i class="fa-solid fa-check"></i> Enable' !!}
                                </button>

                                {{-- <a data_id="{{ $comment->id }}" href="/manage/comments/{{ $comment->id }}/toggle"
                                    class="no-underline text-blue-400 px-6 py-2 rounded-xl">
                                    {!! $comment->status ? '<i class="fa-solid fa-x"></i> Disable' : '<i class="fa-solid fa-check"></i> Enable' !!}</a> --}}
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">

                                <button data-id="{{ $comment->id }}" class="text-red-500 deleteComment"><i
                                        class="fa-solid fa-trash"></i>
                                    Delete</button>
                            </td>



                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <a href="/posts/{{ $comment->post->id }}/show"
                                    class="text-blue-400 px-6 py-2 rounded-xl"><i class="fa-solid fa-eye"></i>
                                    View Post</a>
                            </td>

                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <div class="mt-2 p-4">
        {{ $comments->links() }}
    </div>
</x-layout>

<script>
    $(document).ready(function() {

        $('.deleteComment').on('click', function() {
            id = $(this).data('id');
            // var fd = new FormData();
            // fd.append('_method', 'DELETE');
            // fd.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: "/manage/comments/" + id + "/delete",
                type: "DELETE",
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response == 'success') {
                        $('.trr' + id).hide();
                    }
                },
                error: function(err) {

                }
            });

        });

        $('.toggleComment').on('click', function() {
            id = $(this).data('id');
            var fd = new FormData();
            fd.append('_method', 'PUT');
            fd.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: "/manage/comments/" + id + "/toggle",
                type: "POST",
                processData: false,
                contentType: false,
                data: fd,
                success: function(response) {

                    if (response == false) {
                        $('#' + id).html('<i class="fa-solid fa-check"></i> Enable')

                    } else {
                        $('#' + id).html('<i class="fa-solid fa-x"></i> Disable')

                    }
                },
                error: function(err) {

                }
            });

        })


    })
</script>

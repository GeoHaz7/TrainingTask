<x-layout class="justify-center">
    <div class="pl-10 pr-10">
        <h1 class="text-2xl">Here are the avalible posts:</h1>
        <a href="/manage/users" class="bg-bluez text-white rounded py-2 px-4 hover:bg-black float-right"><i
                class="fa-solid fa-pen"></i>
            New Post</a>
    </div>

    <div class="p-5">
        @unless($posts->isEmpty())

            @foreach ($posts as $post)
                <div class="bg-gray-50 border border-gray-200 rounded mb-3 p-2">

                    <h3 class="text-2xl mb-2 inline">{{ $post->title }}</h3>

                    <div class="text-xl font-bold mb-4 inline">By {{ $post->user->name }}</div>
                    @auth
                        @if (auth()->user()->isAdmin || $post->user->id == auth()->user()->id)
                            <div class="float-right">
                                <a href="/posts/{{ $post->id }}/edit" class="text-blue-400 px-6 py-2 rounded-xl "><i
                                        class="fa-solid fa-pen-to-square"></i>
                                    Edit</a>
                                <form class="inline" method="POST" action="/manage/posts/{{ $post->id }}/delete">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500"><i class="fa-solid fa-trash"></i> Delete</button>
                                </form>
                            </div>
                        @endif
                    @endauth
                    <div class="text-xl font-bold mb-1 ">{{ $post->categories }}</div>
                    <h5>{{ $post->updated_at ? $post->updated_at : $post->created_at }}</h5>
                    <p class="mt-3">{{ $post->content }}</p>
                </div>
            @endforeach
        @else
            <h1 class="text-3xl font-bold mb-4">No Posts Found</h1>
        @endunless
        <div class="mt-2 p-4">
            {{ $posts->links() }}
        </div>
</x-layout>

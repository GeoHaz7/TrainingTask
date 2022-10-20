<x-layout class="justify-center">
    <div class="pl-10 pr-10">
        <h1 class="text-2xl">Here are the avalible posts:</h1>
    </div>

    <div class="p-5">
        @foreach ($posts as $post)
            <h1>{{ $post->user_id }}</h1>
            <div class="bg-gray-50 border border-gray-200 rounded mb-3 p-2">

                <h3 class="text-2xl mb-2 inline">{{ $post->title }}</h3>
                <div class="text-xl font-bold mb-4 inline">By {{ $post->author }}</div>
                <h5>{{ $post->created_at }}</h5>
                <p class="mt-3">{{ $post->content }}</p>
            </div>
        @endforeach
</x-layout>

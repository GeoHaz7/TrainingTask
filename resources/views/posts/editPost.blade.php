<style>
    body {
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
    }

    .form-signin {
        max-width: 700px;
        padding: 15px;
    }
</style>
<x-layout>
    <div class="form-signin w-100 m-auto text-center">
        <form method="POST" action="/posts/{{ $post->id }}/put">
            @csrf
            @method('PUT')
            <img class="mb-4"
                src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/36/Logo.min.svg/2560px-Logo.min.svg.png"
                alt="" height="57">
            <h1 class="h3 mb-3 fw-normal">Please Edit Post</h1>

            <div class="form-floating">
                <input type="text" class="form-control" name="title" value="{{ $post->title }}">
                <label for="floatingInput">Title</label>

                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-floating">


                <select name="categories" class="form-control" value="Sport">

                    <option value="Science" {{ $post->categories == 'Science' ? 'selected' : null }}>Science</option>
                    <option value="Politics" {{ $post->categories == 'Politics' ? 'selected' : null }}>Politics</option>
                    <option value="Sport" {{ $post->categories == 'Sport' ? 'selected' : null }}>Sport</option>
                </select>
                <label for="categories">Choose a Category:</label>

                @error('categories')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-floating mb-4">

                <textarea class="form-control" name="content">{{ $post->content }}</textarea>
                <label for="content">Post Content</label>

                @error('content')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black" type="submit">Publish Post</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2022</p>
        </form>
    </div>
</x-layout>

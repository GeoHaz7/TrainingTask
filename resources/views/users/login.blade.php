<style>
    body {
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
    }

    .form-signin {
        max-width: 330px;
        padding: 15px;
    }
</style>


<x-layout>
    <div class="form-signin w-100 m-auto text-center">
        <form method="POST" action="/auth">
            @csrf
            <img class="mb-4"
                src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/36/Logo.min.svg/2560px-Logo.min.svg.png"
                alt="" height="57">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="form-floating">
                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                <label for="floatingInput">Email address</label>

                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-floating">
                <input type="password" class="form-control" name="password">
                <label for="floatingPassword">Password</label>

                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-8">
                <p>
                    Dont have an account?
                    <a href="/register" class="text-laravel">Register</a>
                </p>
            </div>
            <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black" type="submit" type="submit">Sign
                in</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2022</p>
        </form>
    </div>
</x-layout>

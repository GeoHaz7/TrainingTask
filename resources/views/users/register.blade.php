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
        <form method="POST" action="/users">
            @csrf
            <img class="mb-4"
                src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/36/Logo.min.svg/2560px-Logo.min.svg.png"
                alt="" height="57">
            <h1 class="h3 mb-3 fw-normal">
                {{ substr(url()->current(), -16) == 'manage/users/add' ? 'Please add a user' : 'Please Sign Up' }}</h1>

            <div class="form-floating">
                <input type="text" class="form-control" name="name">
                <label for="floatingInput">Name</label>

                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-floating">
                <input type="email" class="form-control" name="email">
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

            <div class="form-floating">
                <input type="password" class="form-control" name="password_confirmation">
                <label for="floatingPassword">Confirm Password</label>
            </div>

            <div class="mt-8">
                <p>
                    Have an account?
                    <a href="/login" class="text-laravel">Login</a>
                </p>
            </div>
            <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black" type="submit">Sign up</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2022</p>
        </form>
    </div>
</x-layout>

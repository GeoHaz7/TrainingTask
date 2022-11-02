<x-layout>
    <div class="form-signin w-100 m-auto text-center">
        <form method="POST" action="/manage/users/{{ $user->id }}/update">
            @csrf
            @method('PUT')
            <img class="mb-4"
                src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/36/Logo.min.svg/2560px-Logo.min.svg.png"
                alt="" height="57">
            <h1 class="h3 mb-3 fw-normal">Please Edit</h1>

            <div class="form-floating">
                <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                <label for="floatingInput">Name</label>

                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-floating text-laravel">
                <input type="email" class="form-control" name="email" value="{{ $user->email }}" readonly>
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

            <div class="checkbox mb-3 text-left">
                <label>
                    <input type="checkbox" name="isAdmin" class="switch-input"
                        value="{{ $user->isAdmin == '1' ? '1' : '0' }}" {{ $user->isAdmin == '1' ? 'checked' : '' }} />
                    isAdmin?
                </label>
            </div>

            <div class="text-left">
                <p>Activate/Deactivate User:</p>

                <input type="radio" name="isActive" value="1" {{ $user->isActive == '1' ? 'checked' : '' }}>
                <label for="isActive">Activate</label><br>
                <input type="radio" name="isActive" value="0" {{ $user->isActive == '0' ? 'checked' : '' }}>
                <label for="isActive">Deactivate</label><br>
            </div>

            <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black" type="submit">Update</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2022</p>
        </form>
    </div>
</x-layout>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous">
    </script>

    <script src="//unpkg.com/alpinejs" defer></script>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        laravel: "#ef3b2d",
                        bluez: "#3f51b5"
                    },
                },
            },
        };
    </script>


</head>

<body>
    <x-flash-message />
    <nav class="flex justify-between items-center my-4 mx-4">
        <a href="/"><img class="w-36"
                src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/36/Logo.min.svg/2560px-Logo.min.svg.png"
                alt="" class="logo" /></a>
        <ul class="flex space-x-6 mr-6 text-lg">
            @auth

                <li class="dropdown">
                    <span class="bg-bluez text-white rounded py-2 px-4 hover:bg-black dropdown-toggle"
                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Welcome {{ auth()->user()->name }}
                    </span>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="/manage/users/{{ auth()->user()->id }}/edit">Edit Profile</a>
                        </li>
                        {{-- <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li> --}}
                    </ul>
                </li>

                @if (auth()->user()->isAdmin)
                    <li>
                        <a href="/manage/users" class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"><i
                                class="fa-solid fa-gear"></i>
                            Manage Users</a>
                    </li>
                @endif

                <li>
                    <form class="inline bg-laravel text-white rounded py-2 px-4 hover:bg-black" method="POST"
                        action="/logout">
                        @csrf
                        <button type="submit"><i class="fa-solid fa-door-closed"></i> Logout</button>
                    </form>
                </li>
            @else
                <li>
                    <a href="/register" class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"><i
                            class="fa-solid fa-user-plus"></i> Register</a>
                </li>
                <li>
                    <a href="/login" class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"><i
                            class="fa-solid fa-arrow-right-to-bracket"></i>
                        Login</a>
                </li>
            @endauth
        </ul>
    </nav>

    {{ $slot }}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>


</body>

</html>

<x-layout>
    <div class="p-10">
        <header>
            <h1 class="text-3xl text-center font-bold my-6 uppercase">
                Manage Users
            </h1>
        </header>

        <table class="w-full table-auto rounded-sm">
            <tbody>
                @unless($users->isEmpty())
                    @foreach ($users as $user)
                        <tr class="border-gray-300">
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <p> {{ $user->name }} </p>
                            </td>

                            @unless(auth()->user()->id == $user->id)
                                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                    <a href="/manage/users/{{ $user->id }}/edit" class="text-blue-400 px-6 py-2 rounded-xl"><i
                                            class="fa-solid fa-pen-to-square"></i>
                                        Edit</a>
                                </td>
                                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                    <form method="POST" action="/manage/users/{{ $user->id }}/delete">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-500"><i class="fa-solid fa-trash"></i> Delete</button>
                                    </form>
                                </td>
                            @else
                                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                    <p class="text-center">This is the admin account logged in</p>
                                </td>
                            @endunless

                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <a href="/posts/user/{{ $user->id }}" class="text-blue-400 px-6 py-2 rounded-xl"><i
                                        class="fa-solid fa-eye"></i>
                                    View Posts</a>
                            </td>

                        </tr>
                    @endforeach
                @else
                    <tr class="border-gray-300">
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            <p class="text-center">No Listings Found</p>
                        </td>
                    </tr>
                @endunless

            </tbody>
        </table>
    </div>
</x-layout>

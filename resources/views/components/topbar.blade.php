@props([
    'bg' => 'bg-gray-800',
    'user' => 'Administrator',
])

<header class="{{ $bg }} text-white p-4 flex justify-between items-center">
    <h1 class="text-xl font-semibold"></h1>

    <div class="space-x-4">
        <span>{{ $user }}</span>

        <button class="bg-gray-700 px-3 py-1 rounded hover:bg-gray-600">
            Logout
        </button>
    </div>
</header>

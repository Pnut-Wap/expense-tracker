@props([
    'title' => 'Admin Panel',
    'bg' => 'bg-gray-800',
])

<aside class="w-64 {{ $bg }} text-white hidden md:block">
    <div class="p-6 text-2xl font-semibold">{{ $title }}</div>
    <nav class="mt-6">
        <a href="#" class="block py-2.5 px-4 hover:bg-gray-700">
            <span class="flex items-center space-x-2">
                <x-heroicon-s-home class="w-5 h-5 text-white" />
                <span>Dashboard</span>
            </span>
        </a>

        <a href="#" class="block py-2.5 px-4 hover:bg-gray-700">
            <span class="flex items-center space-x-2">
                <x-heroicon-s-banknotes class="w-5 h-5 text-white" />
                <span>Budget</span>
            </span>
        </a>

        <a href="#" class="block py-2.5 px-4 hover:bg-gray-700">
            <span class="flex items-center space-x-2">
                <x-heroicon-s-currency-dollar class="w-5 h-5 text-white" />
                <span>Expenses</span>
            </span>
        </a>

        <a href="{{ route('category.index') }}"
            class="block py-2.5 px-4 hover:bg-gray-700 {{ Route::is('category.*') ? 'bg-gray-700' : '' }}">
            <span class="flex items-center space-x-2">
                <x-heroicon-s-tag class="w-5 h-5 text-white" />
                <span>Categories</span>
            </span>
        </a>

        <a href="#" class="block py-2.5 px-4 hover:bg-gray-700">
            <span class="flex items-center space-x-2">
                <x-heroicon-s-credit-card class="w-5 h-5 text-white" />
                <span>Payment Method</span>
            </span>
        </a>

        <a href="{{ route('users.index') }}"
            class="block py-2.5 px-4 hover:bg-gray-700 {{ Route::is('user.*') ? 'bg-gray-700' : '' }}">
            <span class="flex items-center space-x-2">
                <x-heroicon-s-user-group class="w-5 h-5 text-white" />
                <span>Users</span>
            </span>
        </a>

        <a href="#" class="block py-2.5 px-4 hover:bg-gray-700">
            <span class="flex items-center space-x-2">
                <x-heroicon-s-wrench-screwdriver class="w-5 h-5 text-white" />
                <span>Settings</span>
            </span>
        </a>
    </nav>
</aside>

<x-layout>
    <x-card>
        <div class="mx-auto max-w-2xl p-6">
            <form id="form" action="{{ route('user.store') }}" method="POST" class="space-y-6" autocomplete="off">
                @csrf

                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                    <input type="text" name="first_name" id="first_name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        required>
                </div>

                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                    <input type="text" name="last_name" id="last_name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input type="text" name="password" id="password"
                            class="w-full px-3 py-2 pr-28 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            required>
                        <button type="button" onclick="generatePassword()"
                            class="absolute right-2 top-1/2 -translate-y-1/2 px-3 py-1 bg-gray-500 text-white text-xs rounded hover:bg-gray-600 transition">
                            <x-heroicon-s-arrow-path-rounded-square class="w-4 h-4 inline-block" />
                        </button>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="px-4 py-2 bg-black text-white font-semibold rounded shadow hover:bg-gray-700 transition">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </x-card>

    <x-notification />
</x-layout>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('form');

        form.addEventListener('submit', e => {
            if (!form.checkValidity()) {
                e.preventDefault();

                new Noty({
                    type: 'error',
                    layout: 'topRight',
                    theme: 'metroui',
                    text: 'Please fill out all required fields.',
                    timeout: 3000
                }).show();
            }
        });

        window.generatePassword = () => {
            const passwordField = document.getElementById('password');
            const length = 8;
            const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+";
            let password = "";

            for (let i = 0, n = charset.length; i < length; ++i) {
                password += charset.charAt(Math.floor(Math.random() * n));
            }

            passwordField.value = password;
        };
    });
</script>

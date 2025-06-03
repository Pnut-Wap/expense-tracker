<x-layout>
    <x-card>
        <div class="mx-auto max-w-2xl p-6">
            <form id="form" action="{{ route('users.store') }}" method="POST" class="space-y-6" autocomplete="off">
                @csrf

                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                    <input type="text" name="first_name" id="first_name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                    <input type="text" name="last_name" id="last_name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input type="text" name="password" id="password"
                            class="w-full px-3 py-2 pr-28 border border-gray-300 rounded-md shadow-sm" required>
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

    {{-- <x-notification /> --}}
</x-layout>

<script>
    $(document).ready(function() {
        const $form = $('#form');
        const $passwordField = $('#password');
        const $submitBtn = $form.find('button[type="submit"]');

        $form.on('submit', function(event) {
            event.preventDefault();

            if (!this.checkValidity()) {
                new Noty({
                    type: 'error',
                    layout: 'topRight',
                    theme: 'metroui',
                    text: 'Please fill out all required fields.',
                    timeout: 3000
                }).show();
                return;
            }

            $submitBtn.prop('disabled', true).addClass('opacity-50 cursor-not-allowed');

            $.ajax({
                url: $form.attr('action'),
                method: $form.attr('method'),
                data: $form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function(response) {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        theme: 'metroui',
                        text: 'User created successfully!',
                        timeout: 3000
                    }).show();
                    $form[0].reset();
                },
                error: function(xhr) {
                    let message = 'An error occurred.';

                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;

                        message = Object.values(errors).flat().join('<br>');
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }

                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        theme: 'metroui',
                        text: message,
                        timeout: 5000
                    }).show();
                },
                complete: function() {
                    $submitBtn.prop('disabled', false).removeClass(
                        'opacity-50 cursor-not-allowed');
                }
            });
        });

        window.generatePassword = function() {
            const length = 8;
            const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+";
            let password = '';
            for (let i = 0; i < length; i++) {
                password += charset.charAt(Math.floor(Math.random() * charset.length));
            }
            $passwordField.val(password);
        };
    });
</script>

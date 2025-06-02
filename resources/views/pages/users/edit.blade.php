<x-layout>
    <x-card>
        <div class="mx-auto max-w-2xl p-6">
            <form id="form" action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6"
                autocomplete="off">
                @csrf
                @method('PUT')

                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                    <input type="text" name="first_name" id="first_name"
                        value="{{ old('first_name', $user->first_name) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        required>
                </div>

                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                    <input type="text" name="last_name" id="last_name"
                        value="{{ old('last_name', $user->last_name) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        required>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="px-4 py-2 bg-black text-white font-semibold rounded shadow hover:bg-gray-700 transition">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </x-card>
</x-layout>

<script>
    $(document).ready(function() {
        const $form = $('#form');
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
                method: 'POST',
                data: $form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function(response) {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        theme: 'metroui',
                        text: 'User updated successfully!',
                        timeout: 3000
                    }).show();
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
    });
</script>

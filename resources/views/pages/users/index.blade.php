<x-layout>
    <x-card>
        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('users.create') }}" class="p-3 bg-black text-white rounded hover:bg-gray-700">
                <x-heroicon-s-document-plus class="w-5 h-5 text-white" />
            </a>
        </div>

        <div class="border-b border-gray-200"></div>

        <div class="overflow-x-auto">
            <table id="table" class="min-w-full divide-y divide-gray-200 text-sm text-left display">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 font-medium text-gray-700">Name</th>
                        <th class="px-4 py-2 font-medium text-gray-700">Email</th>
                        <th class="px-4 py-2 font-medium text-gray-700">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </x-card>
</x-layout>

<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/20">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-auto">
        <div class="flex justify-between items-center p-4 border-b bg-black">
            <h2 class="text-lg font-semibold text-white name"></h2>
            <button class="close text-white hover:text-red-200 text-xl font-bold">&times;</button>
        </div>
        <div class="p-4 text-center text-gray-700">
            <p class="font-semibold">Are you sure you want to delete?</p>
        </div>
        <div class="p-4 border-t flex justify-end space-x-2">
            <button class="confirm-delete bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded" data-url="">
                Delete
            </button>
            <button class="close-modal bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                Cancel
            </button>
        </div>
    </div>
</div>

<script>
    $(function() {
        const table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.index') }}",
            order: [],
            columns: [{
                    data: 'name',
                    name: 'name',
                    title: 'Name'
                },
                {
                    data: 'email',
                    name: 'email',
                    title: 'Email'
                },
                {
                    data: 'action',
                    name: 'action',
                    title: 'Action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        let deleteRow; // cache row for deletion

        // Setup CSRF token for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Handle open modal
        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            const url = $(this).data('url');
            const name = $(this).data('name');

            $('#deleteModal .name').text(`${name}`);
            $('#deleteModal .confirm-delete').data('url', url);
            $('#deleteModal').removeClass('hidden').addClass('flex');
        });

        // Handle close modal
        $('.close, .close-modal').on('click', function() {
            $('#deleteModal').addClass('hidden').removeClass('flex');
        });

        $(document).on('mousedown', function(e) {
            const $modal = $('#deleteModal');
            const $content = $modal.find('> div');
            if ($modal.hasClass('flex') && !$content.is(e.target) && $content.has(e.target).length ===
                0) {
                $modal.addClass('hidden').removeClass('flex');
            }
        });


        // Handle confirm delete
        $('.confirm-delete').on('click', function() {
            const $btn = $(this);
            const url = $(this).data('url');

            // Disable button to prevent multiple requests
            $btn.prop('disabled', true).addClass('opacity-50 cursor-not-allowed');

            $.ajax({
                url: url,
                type: 'DELETE',
                success: function(response) {
                    $('#deleteModal').addClass('hidden').removeClass('flex');

                    new Noty({
                        text: response.message || 'User deleted successfully.',
                        type: 'success',
                        layout: 'topRight',
                        theme: 'metroui',
                        timeout: 3000
                    }).show();

                    table.ajax.reload(null, false);
                },
                error: function(xhr) {
                    const msg = xhr.responseJSON?.message ||
                        'An error occurred while deleting.';

                    new Noty({
                        text: msg,
                        type: 'error',
                        layout: 'topRight',
                        theme: 'metroui',
                        timeout: 3000
                    }).show();
                },
                complete: function() {
                    // Enable button after request completes
                    $btn.prop('disabled', false).removeClass(
                        'opacity-50 cursor-not-allowed');
                }
            });
        });
    });
</script>

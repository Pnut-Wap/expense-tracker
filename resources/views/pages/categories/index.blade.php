<x-layout>
    <x-card>
        <!-- Form -->
        <div class="mb-4">
            <form id="form" action="{{ route('category.store') }}" method="POST" autocomplete="off"
                class="flex items-end space-x-2">
                @csrf

                <div class="flex flex-col">
                    <label for="name" class="mb-1 text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" name="name" id="name"
                        class="px-3 py-2 border border-gray-300 rounded-md shadow-sm" required>
                </div>

                <button type="submit"
                    class="px-3 py-2 bg-black text-white rounded-md hover:bg-gray-700 transition-colors self-end">
                    Submit
                </button>
            </form>
        </div>

        <!-- Divider -->
        <div class="border-b border-gray-200 mb-4"></div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table id="category-table" class="min-w-full divide-y divide-gray-200 text-sm text-left display">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 font-medium text-gray-700">Name</th>
                        <th class="px-4 py-2 font-medium text-gray-700">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </x-card>
</x-layout>

<!-- Delete Modal -->
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

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    $(function() {
        const table = $('#category-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('category.index') }}",
            order: [],
            columnDefs: [{
                orderable: false,
                width: 100
            }],
            columns: [{
                    data: 'name',
                    name: 'name',
                    title: 'Name'
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

        const $form = $('#form');
        const $submitBtn = $form.find('button[type="submit"]');

        let deleteRow; // cache row for deletion

        // Setup CSRF token for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Form submission
        $form.on('submit', function(e) {
            e.preventDefault();

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
                type: 'POST',
                data: $form.serialize(),
                success: function(response) {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        theme: 'metroui',
                        text: response.message,
                        timeout: 3000
                    }).show();

                    $form[0].reset();
                    table.ajax.reload(null, false);
                },
                error: function(xhr) {
                    let message = 'An error occurred.';
                    if (xhr.status === 422 && xhr.responseJSON.errors) {
                        message = Object.values(xhr.responseJSON.errors).flat().join(
                            '<br>');
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

        // Delete modal open
        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            const url = $(this).data('url');
            const name = $(this).data('name');

            deleteRow = $(this).closest('tr');
            $('#deleteModal .name').text(name);
            $('#deleteModal .confirm-delete').data('url', url);
            $('#deleteModal').removeClass('hidden').addClass('flex');
        });

        // Modal close handlers
        $(document).on('click', '.close, .close-modal', function() {
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

        // Confirm delete
        $(document).on('click', '.confirm-delete', function() {
            const $btn = $(this);
            const url = $btn.data('url');

            // Disable button to prevent multiple requests
            $btn.prop('disabled', true).addClass('opacity-50 cursor-not-allowed');

            $.ajax({
                url: url,
                type: 'DELETE',
                success: function(response) {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        theme: 'metroui',
                        text: response.message || 'Deleted successfully.',
                        timeout: 3000
                    }).show();

                    $('#deleteModal').addClass('hidden').removeClass('flex');
                    table.row(deleteRow).remove().draw(false);
                },
                error: function(xhr) {
                    console.error(xhr);
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        theme: 'metroui',
                        text: xhr.responseJSON?.message ||
                            'An error occurred while deleting.',
                        timeout: 5000
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

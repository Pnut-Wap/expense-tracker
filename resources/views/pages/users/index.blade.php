<x-layout>
    <x-card>
        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('users.create') }}" class="p-3 bg-black text-white rounded hover:bg-gray-700">
                <x-heroicon-s-document-plus class="w-5 h-5 text-white" />
            </a>
        </div>

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

<script>
    $(document).ready(function() {
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

        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            const url = $(this).data('url');

            const noty = new Noty({
                text: 'Are you sure you want to delete this user?',
                type: 'warning',
                layout: 'topRight',
                theme: 'metroui',
                buttons: [
                    Noty.button('Yes', 'btn btn-primary cursor-pointer ml-2', function() {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            success: function(data) {
                                new Noty({
                                    text: data.message,
                                    type: 'success',
                                    layout: 'topRight',
                                    theme: 'metroui',
                                    timeout: 3000
                                }).show();
                                table.ajax.reload();
                            },
                            error: function(xhr) {
                                let message = 'An error occurred';
                                if (xhr.responseJSON && xhr.responseJSON
                                    .message) {
                                    message = xhr.responseJSON.message;
                                }
                                new Noty({
                                    text: message,
                                    type: 'error',
                                    layout: 'topRight',
                                    theme: 'metroui',
                                    timeout: 3000
                                }).show();
                            },
                            complete: function() {
                                noty.close();
                            }
                        });
                    }),
                    Noty.button('No', 'btn btn-secondary ml-2 cursor-pointer', function() {
                        noty.close();
                    })
                ]
            }).show();
        });
    });
</script>

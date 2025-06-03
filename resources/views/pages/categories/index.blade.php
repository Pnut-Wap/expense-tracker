<x-layout>
    <x-card>
        <div class="mb-4">
            <form id="form" action="{{ route('category.store') }}" method="POST" autocomplete="off"
                class="flex items-end space-x-2">
                @csrf
                <div class="flex flex-col">
                    <label for="name" class="mb-1 text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" name="name" id="name"
                        class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        required>
                </div>

                <button type="submit"
                    class="px-3 py-2 mb-0 bg-black text-white rounded-md hover:bg-gray-700 transition-colors self-end">
                    Submit
                </button>
            </form>
        </div>

        <div class="border-b border-gray-200"></div>

        <div class="overflow-x-auto">
            <table id="table" class="min-w-full divide-y divide-gray-200 text-sm text-left display">
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

<script>
    $(function() {
        var table = $('#table').DataTable({
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

        var $form = $('#form');
        var $submitBtn = $form.find('button[type="submit"]');

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
                type: $form.attr('method'),
                data: $form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
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
                    var message = 'An error occurred.';

                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
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

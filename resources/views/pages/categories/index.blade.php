<x-layout>
    <x-card>
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
    document.addEventListener('DOMContentLoaded', function() {
        $('#table').DataTable({
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
    });
</script>

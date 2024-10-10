<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Project Management') }}
        </h2>
    </x-slot>

    <div class="py-5 mb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Start Date</th>
                                <th>Deadline</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Actions</th>
                                <th>updated_at</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Start Date</th>
                                <th>Deadline</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Actions</th>
                                <th>updated_at</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            fixedHeader: true,
            mark: true,
            ajax: "{{ route('my-project.index') }}",
            columns: [{
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'start_date',
                    name: 'start_date'
                },
                {
                    data: 'deadline',
                    name: 'deadline'
                },
                {
                    data: 'priority',
                    name: 'priority'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'Actions',
                    name: 'Actions'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
            ],
            order: [
                [7, 'desc']
            ],
            columnDefs: [{
                target: 7,
                visible: false,
            }, ],
            language: {
                processing: '...loading'
            }
        });

    });
</script>

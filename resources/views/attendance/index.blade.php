<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Attendance overview') }}
        </h2>
    </x-slot>

    <div class="py-5 mb-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Employee Id</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>Employee Id</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Check In</th>
                                <th>Check Out</th>
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
            ajax: "{{ route('attendance.index') }}",
            columns: [{
                    data: 'employee_id',
                    name: 'employee_id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'check_in',
                    name: 'check_in'
                },
                {
                    data: 'check_out',
                    name: 'check_out'
                },
            ],
            order: [
                [1, 'desc']
            ],
            columnDefs: [{
                target: 0,
                className: 'dt-body-center',
            }],
            language: {
                processing: '...loading'
            }
        });

    });
</script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Employees') }}
        </h2>
    </x-slot>

    <div class="py-5 mb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-2">
            <a href="{{ route('employees.create') }}"><button class="btn btn-active btn-neutral bg-black text-white">Add new
                    employee</button></a>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Employee_id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Department_name</th>
                                <th>Is_present</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>Employee_id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Department_name</th>
                                <th>Is_present</th>
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
         // Check for session message
         @if(session('created'))
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "{{ session('created') }}", // Ensure the session value is passed
                showConfirmButton: false,
                timer: 1500
            });
        @endif

        $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('employees.index') }}",
            columns: [
                { data: 'employee_id', name: 'Employee_id'},
                { data: 'name', name: 'Name'},
                { data: 'email', name: 'Email' },
                { data: 'phone', name: 'Phone' },
                { data: 'department_name', name: 'Department_name'},
                { data: 'is_present', name: 'Is_present'},
            ]
        });
    });
</script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Department') }}
        </h2>
    </x-slot>

    <div class="py-5 mb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-2">
            <a href="{{ route('departments.create') }}"><button class="btn btn-active btn-neutral bg-black text-white">Add
                    new
                    department</button></a>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Actions</th>
                                <th>updated_at</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>Name</th>
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
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // Check for session message
        @if (session('created'))
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "{{ session('created') }}", // Ensure the session value is passed
                showConfirmButton: false,
                timer: 1500
            });
        @endif

        @if (session('updated'))
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "{{ session('updated') }}", // Ensure the session value is passed
                showConfirmButton: false,
                timer: 1500
            });
        @endif

        $('#example').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            fixedHeader: true,
            mark: true,
            ajax: "{{ route('departments.index') }}",
            columns: [{
                    data: 'title',
                    name: 'title'
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
                [2, 'desc']
            ],
            columnDefs: [{
                target: 2,
                visible: false,
            }, {
                target: 0,
                className: 'dt-body-center',
            }],
            language: {
                processing: '...loading'
            }
        });

        // Delete record
        $('#example').on('click', '#deleteItem', function() {
            var department = $(this).data('id');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "DELETE",
                        url: `departments/${department}`,
                        data: {
                            _token: CSRF_TOKEN,
                        },
                        dataType: 'json',
                        success: function(res) {
                            if (res.success === 1) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload(true)
                                    }
                                });
                            }
                        }
                    });
                }
            });
        });

    });
</script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Employees') }}
        </h2>
    </x-slot>

    <div class="py-5 mb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg mb-[40px]">
                <div class="grid grid-cols-2 gap-4 p-4">
                    <div class="items-center">

                        <div class="max-w-lg flex flex-col mb-3">
                            <label class="block text-lg font-medium text-gray-700" for="name">Name</label>
                            <input id="name" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-blue-500 focus:border-blue-500" />
                        </div>

                        <div class="max-w-lg flex flex-col mb-3">
                            <label class="block text-lg font-medium text-gray-700" for="email">Email</label>
                            <input id="email" type="email" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="max-w-lg flex flex-col mb-3">
                            <label class="block text-lg font-medium text-gray-700" for="phone">phone</label>
                            <input id="phone" type="number" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-blue-500 focus:border-blue-500" />
                        </div>

                        <div class="max-w-lg flex flex-col mb-3">
                            <label class="block text-lg font-medium text-gray-700" for="nrc_number">NRC number</label>
                            <input id="nrc_number" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="max-w-lg flex flex-col mb-3">
                            <label class="block text-lg font-medium text-gray-700" for="dob">Date of Birth</label>
                            <input id="dob" type="date" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="max-w-lg flex flex-col mb-3">
                            <label class="block text-lg font-medium text-gray-700" for="gender">Gender</label>
                            <select id="gender"
                                class="form-select px-4 py-3 rounded  border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Gender</option> <!-- Placeholder option -->
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="">
                        <div class="max-w-lg flex flex-col mb-3">
                            <label class="block text-lg font-medium text-gray-700" for="employee_id">Employee Id</label>
                            <input id="employee_id" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="max-w-lg flex flex-col mb-3">
                            <label class="block text-lg font-medium text-gray-700" for="department_name">Department Name</label>
                            <select id="department_name"
                                class="form-select px-4 py-3 rounded  border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Department</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="max-w-lg flex flex-col mb-3">
                            <label class="block text-lg font-medium text-gray-700" for="dofjoin">Date of Join</label>
                            <input id="dofjoin" type="date" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="max-w-lg flex flex-col mb-3">
                            <label class="block text-lg font-medium text-gray-700" for="is_present">Is present ?</label>
                            <select id="is_present"
                                class="form-select px-4 py-3 rounded  border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select</option> <!-- Placeholder option -->
                                <option value="1">Present</option>
                                <option value="0">Not Present</option>
                            </select>
                        </div>

                        <div class="max-w-lg flex flex-col mb-3">
                            <label class="block text-lg font-medium text-gray-700" for="address">Address</label>
                            <textarea id="address" class="form-textarea px-4 py-3 rounded  border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script type="text/javascript" type="module">

    // Set the max attribute to today's date to disable future dates
    document.getElementById('dob').max = new Date().toISOString().split('T')[0];

    $(document).ready(function() {

    });
</script>

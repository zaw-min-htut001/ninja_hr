<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Employees') }}
        </h2>
    </x-slot>

    <div class="py-5 mb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg mb-[40px]">

                <form id="employees-form" action="{{ route('employees.store') }}" method="post">
                    @csrf
                    <div class="grid grid-cols-2 gap-4 p-4">
                        <div class="">

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="name">Name</label>
                                <input name="name" id="name" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black" />
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="email">Email</label>
                                <input name="email" id="email" type="email" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="phone">phone</label>
                                <input name="phone" id="phone" type="number" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black" />
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="nrc_number">NRC number</label>
                                <input name="nrc_number" id="nrc_number" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="datepicker">Date of Birth</label>
                                <input name="dob" id="datepicker" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="gender">Gender</label>
                                <select id="gender" name="gender"
                                    class="form-select px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="">
                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="employee_id">Employee Id</label>
                                <input name="employee_id" id="employee_id" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="department_name">Department Name</label>
                                <select id="department_name" name="department_id"
                                    class="form-select px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">
                                    <option disabled selected>Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="d-o-join">Date of Join</label>
                                <input name="d-o-join" id="d-o-join" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="is_present">Is present ?</label>
                                <select id="is_present" name="is_present"
                                    class="form-select px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">
                                    <option value="1">Present</option>
                                    <option value="0">Not Present</option>
                                </select>
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="password">Password</label>
                                <input name="password" id="password" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="address">Address</label>
                                <textarea name="address" rows="1" id="address" class="form-textarea px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black"></textarea>
                            </div>

                        </div>

                    </div>

                    <div class="flex justify-center mb-3">
                        <x-primary-button class="btn btn-wide font-medium">Submit</x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

<script type="text/javascript" type="module">
    // <!-- Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    // <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\EmployeesRequest', '#employees-form'); !!}

    flatpickr("#datepicker", {
        dateFormat: "Y-m-d",
        maxDate: new Date(), // Restrict to today or past
        yearSelector: true // Enable the ability to change years
    });

    flatpickr("#d-o-join", {
        dateFormat: "Y-m-d",
        yearSelector: true // Enable the ability to change years
    });

    $(document).ready(function() {

    });
</script>

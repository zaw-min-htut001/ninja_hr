<x-app-layout>
    <div class="bg-gray-100 flex items-center justify-center pt-3">
        <div class="max-w-full md:max-w-lg bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="md:flex leading-8">
                <!-- Profile Image -->
                <div class="md:w-full bg-blue-500">
                    <img src="{{asset($employee->getFirstMediaUrl('images'))}}" alt="Employee photo" class="w-full h-full object-cover">
                </div>

                <!-- Employee Info -->
                <div class="md:w-screen p-4">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $employee->name }}</h2>
                    <p class="text-gray-600">{{ $employee->employee_id }}</p>
                    <p class="text-gray-600">{{ $employee->email }}</p>
                    <div class="mt-4">
                        <p class="text-gray-600"><span class="font-bold">NRC:</span>{{ $employee->nrc_number }}</p>
                        <p class="text-gray-600"><span class="font-bold">Phone:</span> {{ $employee->phone }}</p>
                        <p class="text-gray-600"><span class="font-bold">DOB:</span>{{ $employee->dob }}</p>
                        <p class="text-gray-600"><span class="font-bold">Gender:</span> {{ $employee->gender }}</p>
                        <p class="text-gray-600"><span class="font-bold">Address:</span> {{ $employee->address }}</p>
                        <p class="text-gray-600"><span class="font-bold">Department:</span> {{ $employee->department->title }}</p>
                        <p class="text-gray-600"><span class="font-bold">Date of join:</span> {{ $employee->d_o_join }}</p>
                        <p class="text-gray-600"><span class="font-bold">Is present:</span>
                            @if ($employee->is_present === 1)
                                <span class="p-1 bg-green-500 text-white rounded-lg">
                                    Present
                                </span>
                            @else
                                <span class="p-1 bg-red-500 text-white rounded-lg">
                                    Not Present
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

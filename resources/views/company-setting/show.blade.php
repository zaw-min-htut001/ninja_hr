<x-app-layout>
    <div class="flex items-center justify-center pt-3">
        <div class="max-w-full md:max-w-lg bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="leading-7 max-w-full p-4">
                <!-- company Info -->
                    <h2 class="text-xl font-semibold text-gray-800 text-center">Company Profile</h2>
                    <div class="mt-4">
                        <p class="text-gray-600"><span class="font-bold">Name:</span> {{ $company->company_name }}</p>
                        <p class="text-gray-600"><span class="font-bold">Email:</span>{{ $company->company_email }}</p>
                        <p class="text-gray-600"><span class="font-bold">Phone:</span> {{ $company->company_phone }}</p>
                        <p class="text-gray-600"><span class="font-bold">Address:</span> {{ $company->company_address }}</p>
                        <p class="text-gray-600"><span class="font-bold">Contact person:</span> {{ $company->contact_person }}</p>
                        <p class="text-gray-600"><span class="font-bold">Office start time:</span> {{ $company->office_start_time }}</p>
                        <p class="text-gray-600"><span class="font-bold">Office end time:</span> {{ $company->office_end_time }}</p>
                        <p class="text-gray-600"><span class="font-bold">Break start time:</span> {{ $company->break_start_time }}</p>
                        <p class="text-gray-600"><span class="font-bold">Break start time:</span> {{ $company->break_end_time }}</p>
                    </div>
            </div>
            <div class="flex justify-center items-center mb-3">
                <a href="{{ route('company-setting.edit' , $company->id ) }}">
                    <x-primary-button class="btn btn-wide font-sm">Edit Setting</x-primary-button>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
        @if (session('updated'))
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "{{ session('updated') }}", // Ensure the session value is passed
                showConfirmButton: false,
                timer: 1500
            });
        @endif
</script>

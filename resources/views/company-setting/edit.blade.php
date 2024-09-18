<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Company setting') }}
        </h2>
    </x-slot>

    <div class="py-5 mb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg mb-[40px]">

                <form id="company-setting-form" method="POST" action="{{ route('company-setting.update' , $company->id) }}" >
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-2 gap-4 p-4">
                        <div class="">

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="name">Name</label>
                                <input name="company_name" id="name" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black" value="{{ $company->company_name}}" />
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="email">Email</label>
                                <input name="company_email" id="email" type="email" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black" value="{{ $company->company_email}}"  />
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="phone">phone</label>
                                <input name="company_phone" id="phone" type="number" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black" value="{{ $company->company_phone}}" />
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="nrc_number">Address</label>
                                <input name="company_address" id="nrc_number" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black" value="{{ $company->company_address}}" />
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="nrc_number">Contact Person</label>
                                <input name="contact_person" id="nrc_number" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black" value="{{ $company->contact_person}}" />
                            </div>

                        </div>

                        <div class="">
                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="datepicker">Office start time</label>
                                <input name="office_start_time" id="datepicker" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black" value="{{ $company->office_start_time }}" />
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="datepicker">Office end time</label>
                                <input name="office_end_time" id="datepicker" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black" value="{{ $company->office_end_time }}" />
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="datepicker">Break start time</label>
                                <input name="break_start_time" id="datepicker" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black" value="{{ $company->break_start_time }}" />
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="datepicker">Break end time</label>
                                <input name="break_end_time" id="datepicker" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black" value="{{ $company->break_end_time }}" />
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

     <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\UpdateCompanySetting', '#company-setting-form'); !!}

<script>

    flatpickr("#datepicker", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });

    $(document).ready(function() {

    });
</script>

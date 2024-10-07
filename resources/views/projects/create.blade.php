<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Project') }}
        </h2>
    </x-slot>

    <div class="py-5 mb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg mb-[40px]">

                <form id="project-form" action="{{ route('project.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-2 gap-4 p-4">
                        <div class="">
                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="title">Title</label>
                                <input name="title" id="title" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black" />
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="description">Description</label>
                                <textarea name="description" rows="1" id="description" class="form-textarea px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black"></textarea>
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="priority">Priority</label>
                                <select name="priority" id="priority" class="form-control">
                                    <option value="" disabled selected>-- Select --</option>
                                    <option value="high">High</option>
                                    <option value="middle">Middle</option>
                                    <option value="low">Low</option>
                                </select>
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="leaders">Leaders</label>
                                <select multiple="multiple" name="leaders[]" id="leaders" class="form-control js-example-basic-multiple">
                                    <option value="" disabled selected>-- Select --</option>
                                    @foreach ($employees as $employee)
                                        <option value={{ $employee->id }}>{{ $employee->employee_id }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- fileponds --}}
                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700">Images</label>
                                <input type="file" class="filepond1" name="images[]" multiple accept="image/*"
                                data-allow-reorder="true" data-max-file-size="3MB">
                            </div>
                        </div>

                        <div class="">
                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="datepicker">Start Date</label>
                                <input name="start_date" id="datepicker" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="deadline">Deadline</label>
                                <input name="deadline" id="deadline" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="" disabled selected>-- Select --</option>
                                    <option value="complete">Complete</option>
                                    <option value="pending">Pending</option>
                                    <option value="progess">Progress</option>
                                </select>
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="members">Members</label>
                                <select multiple="multiple" name="members[]" id="members" class="form-control js-example-basic-multiple">
                                    <option value="" disabled selected>-- Select --</option>
                                    @foreach ($employees as $employee)
                                        <option value={{ $employee->id }}>{{ $employee->employee_id }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700">Files</label>
                                <input type="file" class="filepond2" id='fileupload' name="files[]" multiple accept="application/pdf"
                                data-allow-reorder="true" data-max-file-size="3MB">
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
    {!! JsValidator::formRequest('App\Http\Requests\ProjectRequest', '#project-form'); !!}
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2({});
    });

    flatpickr("#datepicker ,#deadline", {
        dateFormat: "Y-m-d",
        yearSelector: true // Enable the ability to change years
    });
</script>

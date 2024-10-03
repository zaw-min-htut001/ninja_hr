<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Salary') }}
        </h2>
    </x-slot>

    <div class="py-5 mb-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg mb-[40px]">

                <form id="departments-form" action="{{ route('salary.update', $salary->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="flex justify-center items-center">
                        <div class="">
                            <div class="w-96 mb-2 mt-3">
                                <select name="user_id" class="year select select-bordered w-full max-w-xs">
                                    <option disabled selected>--- Select Employee ---</option>
                                    @foreach ($employees as $employee)
                                    <option @if($salary->user_id === $employee->id) selected @endif value="{{ $employee->id}}">{{ $employee->employee_id }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-96 mb-2">
                                <select name="month" class="month select select-bordered w-full max-w-xs">
                                    <option disabled selected>--- Select Month ---</option>
                                    <option @if($salary->month === '01') selected @endif value="1">Jan</option>
                                    <option @if($salary->month === '02') selected @endif value="2">Feb</option>
                                    <option @if($salary->month === '03') selected @endif value="3">Mar</option>
                                    <option @if($salary->month === '04') selected @endif value="4">Apr</option>
                                    <option @if($salary->month === '05') selected @endif value="5">May</option>
                                    <option @if($salary->month === '06') selected @endif value="6">Jun</option>
                                    <option @if($salary->month === '07') selected @endif value="7">Jul</option>
                                    <option @if($salary->month === '08') selected @endif value="8">Aug</option>
                                    <option @if($salary->month === '09') selected @endif value="9">Sep</option>
                                    <option @if($salary->month === '10') selected @endif value="10">Oct</option>
                                    <option @if($salary->month === '11') selected @endif value="11">Nov</option>
                                    <option @if($salary->month === '12') selected @endif value="12">Dec</option>
                                </select>
                            </div>
                            <div class="w-96 mb-2">
                                <select name="year" class="year select select-bordered w-full max-w-xs">
                                    <option disabled selected>--- Select Year ---</option>
                                    @for($i = 0; $i < 15; $i++)
                                    <option @if($salary->year == now()->addYears(5)->subYears($i)->format('Y')) selected @endif value="{{ now()->addYears(5)->subYears($i)->format('Y')}}">{{ now()->addYears(5)->subYears($i)->format('Y')}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="w-96">
                                <input value="{{ $salary->amount }}" name="amount" type="number" placeholder="Type amount" class="input input-bordered w-full max-w-xs" />
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center mt-3 mb-3">
                        <x-primary-button class="btn font-medium">Submit</x-primary-button>
                    </div>
                </form>
        </div>
    </div>
</x-app-layout>
     <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\SalaryRequest', '#departments-form'); !!}
<script>

</script>

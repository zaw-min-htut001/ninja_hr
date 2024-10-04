<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <table id="example" class="display border" style="width:100%">
                <thead>
                    <tr>
                        <th class="border border-slate-300 text-center">Employee Id</th>
                        @foreach ($periods as $period)
                        <th @if ($period->format('D') == 'Sat' || $period->format('D') === 'Sun') class='bg-red-300
                            border border-slate-300 text-center' @endif
                            class="border border-slate-300 text-center">{{ $period->format('d') }}
                            {{ $period->format('D') }}</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @foreach ($employees as $employee)
                    <tr class="border border-slate-300 text-center">
                        <td class="border border-slate-300 text-center">{{ $employee->employee_id }}</td>
                        @foreach ($periods as $period)
                        @php
                        $icon = '';
                        $checkouticon = '';
                        $attendance = collect($attendaces)
                        ->where('user_id', $employee->id)
                        ->where('date', $period->format('Y-m-d'))
                        ->first();

                        if ($attendance) {
                        if ($attendance->check_in <= $companySetting->office_start_time && $attendance->check_in !== NULL ) {
                            $icon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6 text-green-700">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            ';
                            } elseif (
                            $attendance->check_in > $companySetting->office_start_time &&
                            $attendance->check_in < $companySetting->break_start_time
                                ) {
                                $icon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6  text-yellow-400">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>';
                                } else {
                                $icon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 text-red-600">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                ';
                                }
                                }

                                if ($attendance) {
                                if ($attendance->check_out >= $companySetting->office_end_time && $attendance->check_out !== NULL) {
                                $checkouticon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 text-green-700">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                ';
                                } elseif (
                                    $attendance->check_out < $companySetting->office_end_time &&
                                    $attendance->check_out > $companySetting->break_end_time
                                ) {
                                    $checkouticon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="size-6  text-yellow-400">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>';
                                    } else {
                                    $checkouticon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="size-6 text-red-600">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    ';
                                    }
                                    }
                                    @endphp
                                    <td @if ($period->format('D') == 'Sat' || $period->format('D') === 'Sun')
                                        class='bg-red-100 border border-slate-300 text-center' @endif
                                        class="border border-slate-300 text-center">
                                        <div>{!! $icon !!}</div>
                                        <div>{!! $checkouticon !!}</div>

                                    </td>
                                    @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

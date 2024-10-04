<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <table id="example" class="display border" style="width:100%">
                <thead>
                    <tr>
                        <th class="border border-slate-300 text-center">Employee Id</th>
                        <th class="border border-slate-300 text-center">Role</th>
                        <th class="border border-slate-300 text-center">Days of month</th>
                        <th class="border border-slate-300 text-center">Working Day</th>
                        <th class="border border-slate-300 text-center">Off Day</th>
                        <th class="border border-slate-300 text-center">Attendance Day</th>
                        <th class="border border-slate-300 text-center">Leave</th>
                        <th class="border border-slate-300 text-center">Per Day (MMK)</th>
                        <th class="border border-slate-300 text-center">Total (MMK)</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($employees as $employee)
                    <tr class="border border-slate-300 text-center">
                        @php
                            $attendances = 0; // Total attendance days for the employee
                            $workingDays = 0;  // Total working days in the month (weekdays only)
                            $offDays = 0;      // Off days (weekends, holidays, etc.)

                            $salary = collect($employee->salaries)
                                        ->where('month', $month)
                                        ->where('year', $year)
                                        ->first();
                            $perSalary =$salary ? ($salary->amount / $workingDaysMonth) : 0 ;

                        @endphp

                        @foreach ($periods as $period)
                            @if ($period->isWeekday())  <!-- Only consider weekdays (Monday to Friday) -->
                                @php
                                    $workingDays++;  // Increment the working days for each weekday
                                    $attendance = collect($attendaces)
                                        ->where('user_id', $employee->id)
                                        ->where('date', $period->format('Y-m-d'))
                                        ->first();

                                        if ($attendance) {
                                        // Morning attendance check (Check-in)
                                        if ($attendance->check_in && $attendance->check_in <= $companySetting->office_start_time) {
                                            $attendances += 0.5;
                                        } elseif ($attendance->check_in > $companySetting->office_start_time && $attendance->check_in < $companySetting->break_start_time) {
                                            $attendances += 0.5;  // Late but present before break time
                                        }

                                        // Evening attendance check (Check-out)
                                        if ($attendance->check_out && $attendance->check_out >= $companySetting->office_end_time) {
                                            $attendances += 0.5;
                                        } elseif ($attendance->check_out < $companySetting->office_end_time && $attendance->check_out > $companySetting->break_end_time) {
                                            $attendances += 0.5;  // Left early but after break
                                        }
                                    }
                                @endphp
                            @else
                                @php
                                    $offDays++; // Increment off days for weekends or holidays
                                @endphp
                            @endif
                        @endforeach

                        @php
                            // Calculate leave days: Working days minus actual attendance
                            $leaveDays = $workingDays - $attendances;
                            $total = $perSalary * $attendances;
                        @endphp

                        <!-- Display results in the table -->
                        <td class="border border-slate-300 text-center">{{ $employee->employee_id }}</td>
                        <td class="border border-slate-300 text-center">{{ implode(',', $employee->roles->pluck('name')->toArray()) }}</td>
                        <td class="border border-slate-300 text-center">{{ $periods->count() }}</td>  <!-- Total days in the month -->
                        <td class="border border-slate-300 text-center">{{ $workingDays }}</td>  <!-- Total working days -->
                        <td class="border border-slate-300 text-center">{{ $offDays }}</td>  <!-- Total off days -->
                        <td class="border border-slate-300 text-center">{{ $attendances }}</td>  <!-- Total attendance days -->
                        <td class="border border-slate-300 text-center">{{ $leaveDays }}</td>  <!-- Total leave days -->
                        <td class="border border-slate-300 text-center">{{ number_format($perSalary) }}</td>
                        <td class="border border-slate-300 text-center">{{ number_format($total) }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

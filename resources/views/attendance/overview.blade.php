<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Attendance overview') }}
        </h2>
    </x-slot>

    <div class="py-5 mb-6">
        <div class="flex items-center justify-center mb-3 max-w-full">
            <div class="w-96">
                <input type="text" id='employee_id' placeholder="Type here employee" class="input input-bordered w-full max-w-xs" />
            </div>
            <div class="w-96">
                <select class="month select select-bordered w-full max-w-xs">
                    <option disabled selected>--- Select Month ---</option>
                    <option value="1">Jan</option>
                    <option value="2">Feb</option>
                    <option value="3">Mar</option>
                    <option value="4">Apr</option>
                    <option value="5">May</option>
                    <option value="6">Jun</option>
                    <option value="7">Jul</option>
                    <option value="8">Aug</option>
                    <option value="9">Sep</option>
                    <option value="10">Oct</option>
                    <option value="11">Nov</option>
                    <option value="12">Dec</option>
                </select>
            </div>
            <div class="w-96">
                <select class="year select select-bordered w-full max-w-xs">
                    <option disabled selected>--- Select Year ---</option>
                    @for($i = 0; $i < 5; $i++)
                    <option value="{{ now()->subYears($i)->format('Y')}}">{{ now()->subYears($i)->format('Y')}}</option>
                    @endfor
                </select>
            </div>
            <div class="">
                <button id='search' class="btn btn-sm btn-primary">search ...</button>
            </div>
        </div>
        <div id="table_overview"></div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        function attendance_overview(employee_id ,month , year){
            $.ajax({
                url : `/attendance-overview-table?employee_id=${employee_id}&month=${month}&year=${year}` ,
                type : 'GET' ,
                success : function(res){
                    $('#table_overview').html(res);
                }
            })
        }
        $('#search').on('click', function(e) {
            e.preventDefault();
            var employee_id = $('#employee_id').val();
            var month = $('.month').val();
            var year = $('.year').val();
            attendance_overview(employee_id ,month , year);
        });

    });
</script>

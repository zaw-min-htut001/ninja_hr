<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My history') }}
        </h2>
    </x-slot>
    <div class="py-3 mb-1">
        <div class="flex items-center justify-center max-w-full mb-2">
            <div class="w-96">
                <select class="month select select-bordered w-full max-w-xs">
                    <option disabled selected>--- Select Month ---</option>
                    <option @if(now()->format('m') == '01') selected @endif value="1">Jan</option>
                    <option @if(now()->format('m') == '02') selected @endif value="2">Feb</option>
                    <option @if(now()->format('m') == '03') selected @endif value="3">Mar</option>
                    <option @if(now()->format('m') == '04') selected @endif value="4">Apr</option>
                    <option @if(now()->format('m') == '05') selected @endif value="5">May</option>
                    <option @if(now()->format('m') == '06') selected @endif value="6">Jun</option>
                    <option @if(now()->format('m') == '07') selected @endif value="7">Jul</option>
                    <option @if(now()->format('m') == '08') selected @endif value="8">Aug</option>
                    <option @if(now()->format('m') == '09') selected @endif value="9">Sep</option>
                    <option @if(now()->format('m') == '10') selected @endif value="10">Oct</option>
                    <option @if(now()->format('m') == '11') selected @endif value="11">Nov</option>
                    <option @if(now()->format('m') == '12') selected @endif value="12">Dec</option>
                </select>
            </div>
            <div class="w-96">
                <select class="year select select-bordered w-full max-w-xs">
                    <option disabled selected>--- Select Year ---</option>
                    @for($i = 0; $i < 5; $i++)
                    <option @if(now()->format('Y') == now()->subYears($i)->format('Y')) selected @endif value="{{ now()->subYears($i)->format('Y')}}">{{ now()->subYears($i)->format('Y')}}</option>
                    @endfor
                </select>
            </div>
            <div class="">
                <button id='search' class="btn btn-sm btn-primary">search ...</button>
            </div>
        </div>
        <div id="table_overview"></div>
    </div>

    <div class="pb-5 mb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Employee Id</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>Employee Id</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            fixedHeader: true,
            mark: true,
            ajax: "{{ route('attendance.attendance-history') }}",
            columns: [{
                    data: 'employee_id',
                    name: 'employee_id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'check_in',
                    name: 'check_in'
                },
                {
                    data: 'check_out',
                    name: 'check_out'
                },
            ],
            order: [
                [1, 'desc']
            ],
            columnDefs: [{
                target: 0,
                className: 'dt-body-center',
            }],
            language: {
                processing: '...loading'
            }
        });
        attendance_overview();

        function attendance_overview(){
            var month = $('.month').val();
            var year = $('.year').val();
            $.ajax({
                url : `/my-attendance-overview-table?month=${month}&year=${year}` ,
                type : 'GET' ,
                success : function(res){
                    $('#table_overview').html(res);
                }
            })

            table.ajax.url(`/attendance-history?month=${month}&year=${year}`).load();
        }

        $('#search').on('click', function(e) {
            e.preventDefault();
            attendance_overview();
        });
    });
</script>

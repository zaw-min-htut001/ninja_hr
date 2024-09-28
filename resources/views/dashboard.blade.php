<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight ">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-5 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-2 border-b-black">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center leading-9">
                    {{ __("You're logged in as ") }}  -  {{ Auth::user()->name}}
                    <div class="border-t my-2 py-3">
                        <h1 class="text-lg text-gray-600 "><span class="font-semibold">Name : </span>{{ Auth::user()->name}}</h1>
                        <h1 class="text-lg text-gray-600 "><span class="font-semibold">Employee id :  </span> {{ Auth::user()->employee_id}}</h1>
                        <h1 class="text-lg text-gray-600 "><span class="font-semibold">Email :   </span>{{ Auth::user()->email}}</h1>
                        <h1 class="text-lg text-gray-600 "><span class="font-semibold">Address :   </span>{{ Auth::user()->address}}</h1>
                        <h1 class="text-lg text-gray-600 "><span class="font-semibold">Department :   </span>{{ Auth::user()->department->title }}</h1>
                        <h1 class="text-lg text-gray-600"><span><span class="font-semibold">Roles:  </span></span>
                            @foreach (Auth::user()->roles as $role)
                                <span class="p-1 bg-green-500 text-center text-sm text-white rounded-lg">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </h1>
                        <div class="flex justify-center gap-2">
                            @can('view_check_in')
                        <div class="mt-3">
                            <a href="{{ route('check-out.index') }}">
                                <button class="btn btn-sm btn-outline text-black btn-warning">Checks in with pin code</button>
                            </a>
                        </div>
                        @endcan
                        <div class="mt-3">
                            <a href="{{ route('dailycheckin.index') }}">
                                <button class="btn btn-sm btn-outline text-black btn-success">Daily Checks in/out</button>
                            </a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

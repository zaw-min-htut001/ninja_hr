<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                {{-- drawer --}}
                <div class="drawer drawer-end">
                    <input id="my-drawer-4" type="checkbox" class="drawer-toggle" />
                    <div class="drawer-content flex items-center">
                        <!-- Page content here -->
                        <label for="my-drawer-4" class="swap swap-rotate">
                            <!-- this hidden checkbox controls the state -->
                            <input type="checkbox" class="hidden" />
                            <!-- hamburger icon -->
                            <svg class="swap-off fill-current w-[30px]" xmlns="http://www.w3.org/2000/svg" width="32"
                                height="32" viewBox="0 0 512 512">
                                <path d="M64,384H448V341.33H64Zm0-106.67H448V234.67H64ZM64,128v42.67H448V128Z" />
                            </svg>
                        </label>
                    </div>
                    <div class="drawer-side z-50">
                        <label for="my-drawer-4" aria-label="close sidebar" class="drawer-overlay"></label>
                        <ul class="menu bg-base-200 text-base-content min-h-full w-80 p-4 me-1">
                            <!-- Sidebar user avatar -->
                            <li>
                                    <!-- Settings Dropdown -->
                                    <div class="hidden sm:flex items-center sm:items-center">
                                        <x-dropdown align="left" width="48">
                                            <x-slot name="trigger">
                                                <h2 class="mb-2">LOGIN AS :</h2>
                                                <button
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                                    <div>{{ Auth::user()->getCapitalNameAttribute() }}</div>

                                                    <div class="ml-1">
                                                        <svg class="fill-current h-4 w-4"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </button>
                                            </x-slot>

                                            <x-slot name="content">
                                                <x-dropdown-link :href="route('profile.edit')">
                                                    {{ __('Profile') }}
                                                </x-dropdown-link>

                                                <!-- Authentication -->
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf

                                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                                        {{ __('Log Out') }}
                                                    </x-dropdown-link>
                                                </form>
                                            </x-slot>
                                        </x-dropdown>
                                    </div>
                                    <!-- Hamburger -->
                                    <div class="-mr-2 flex items-center sm:hidden">
                                        <button @click="open = ! open"
                                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                                <path :class="{'hidden': open, 'inline-flex': ! open }"
                                                    class="inline-flex" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                            </li>
                            <hr>
                            {{-- menu --}}
                            <h1 class="text-lg">Menu</h1>
                            <li><a href="{{ route('dashboard')}}">Home</a></li>
                            @can('view_my_attendance_history')
                            <li><a href="{{ route('attendance.attendance-history')}}">My attendance history</a></li>
                            @endcan
                            @can('view_check_in')
                            <li><a href="{{ route('check-out.index')}}">Check In</a></li>
                            @endcan
                            @can('view_attendance')
                            <li><a href="{{ route('attendance.index')}}">Attendance</a></li>
                            @endcan
                            @can('view_project')
                            <li><a href="{{ route('my-project.index')}}">My Projects</a></li>
                            @endcan
                            @can('view_payroll')
                            <li><a href="{{ route('payroll.index')}}">PayRoll</a></li>
                            @endcan
                            @can('create_salary')
                            <li><a href="{{ route('salary.index')}}">Salary Management</a></li>
                            @endcan
                            @can('create_project')
                            <li><a href="{{ route('project.index')}}">Porject Management</a></li>
                            @endcan
                            @can('view_company')
                                <li><a href="{{ route('company-setting.index')}}">Company Setting</a></li>
                            @endcan
                            @can('create_employee')
                                <li><a href="{{ route('employees.index')}}">Employee Management</a></li>
                            @endcan
                            @can('create_department')
                                <li><a href="{{ route('departments.index')}}">Department Management</a></li>
                            @endcan
                            @can('create_role')
                                <li><a href="{{ route('roles.index')}}">Role Management</a></li>
                            @endcan
                            @can('create_permission')
                                <li><a href="{{ route('permissions.index')}}">Permissions Management</a></li>
                            @endcan

                        </ul>
                    </div>
                </div>


                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img style="height: 50px" src="{{ asset('images/logo.webp')}}" alt="Ninja Hr"
                            class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" srcset="">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <h1 class="shrink-0 flex items-center text-lg">Ninja Hr</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

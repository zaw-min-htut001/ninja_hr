    <!-- Task Card 1 -->
    <div class="bg-yellow-100 shadow-md rounded-lg p-2 border border-gray-200 grid-cols-1">
        <p class="text-center font-medium text-xl mb-1 mt-0">Pending</p>
        @foreach (collect($project->tasks)->where('status', 'pending') as $task)
            <div class="border border-gray-300 rounded-md p-1 bg-white leading-9 mb-2">
                <div class="flex justify-between">
                    <span class="text-lg font-normal">{{ $task->title }}</span>
                    <div>
                        <button id="edit-pending" data-task="{{base64_encode(json_encode($task))}}" data-task-members="{{base64_encode(json_encode(collect($task->members)->pluck('id')->toArray()))}}" class="bg-green-500 text-white p-0 rounded-lg mr-2 hover:bg-green-600"><svg
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </button>
                        <button id="delete-pending" data-id="{{$task->id}}" class="bg-red-500 text-white p-0 rounded-lg hover:bg-red-600"><svg
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex justify-between">
                    <div class="flex items-center">
                        <span class="flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6 font-bold">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </span>
                        <div class="badge badge-success bg-black ms-2">{{ $task->deadline }}</div>
                    </div>
                    {{-- avatar --}}
                    <div class="avatar-group -space-x-6 rtl:space-x-reverse">
                        @foreach ($task->members as $member)
                            <div class="avatar">
                                <div class="w-8">
                                    <img src="{{ asset($member->getFirstMediaUrl('images')) }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    @if ($task->priority == 'high')
                        <span>Priority -<div class="badge badge-success bg-red-600">{{ $task->priority }}
                            </div>
                        </span>
                    @elseif($task->priority == 'low')
                        <span>Priority -<div class="badge badge-success bg-green-600">{{ $task->priority }}
                            </div>
                        </span>
                    @elseif($task->priority == 'middle')
                        <span>Priority -<div class="badge badge-success bg-yellow-600">{{ $task->priority }}
                            </div>
                        </span>
                    @endif
                </div>
            </div>
        @endforeach
        {{-- Add Button --}}
        <div class="flex items-center justify-center ">
            <button id='pending' class="bg-blue-700 text-white p-2 mt-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </button>
        </div>
    </div>

    <div class="bg-cyan-200 shadow-md rounded-lg p-2 border border-gray-200 grid-cols-1">
        <p class="text-center font-medium text-xl mb-1 mt-0">Progress</p>
        @foreach (collect($project->tasks)->where('status', 'progress') as $task)
            <div class="border border-gray-300 rounded-md p-1 bg-white leading-9 mb-2">
                <div class="flex justify-between">
                    <span class="text-lg font-normal">{{ $task->title }}</span>
                    <div>
                        <button id="edit-progress" data-task="{{base64_encode(json_encode($task))}}" data-task-members="{{base64_encode(json_encode(collect($task->members)->pluck('id')->toArray()))}}" class="bg-green-500 text-white p-0 rounded-lg mr-2 hover:bg-green-600"><svg
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </button>
                        <button id="delete-progress" data-id="{{$task->id}}" class="bg-red-500 text-white p-0 rounded-lg hover:bg-red-600"><svg
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex justify-between">
                    <div class="flex items-center">
                        <span class="flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6 font-bold">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </span>
                        <div class="badge badge-success bg-black ms-2">{{ $task->deadline }}</div>
                    </div>
                    {{-- avatar --}}
                    <div class="avatar-group -space-x-6 rtl:space-x-reverse">
                        @foreach ($task->members as $member)
                            <div class="avatar">
                                <div class="w-8">
                                    <img src="{{ asset($member->getFirstMediaUrl('images')) }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    @if ($task->priority == 'high')
                        <span>Priority -<div class="badge badge-success bg-red-600">{{ $task->priority }}
                            </div>
                        </span>
                    @elseif($task->priority == 'low')
                        <span>Priority -<div class="badge badge-success bg-green-600">{{ $task->priority }}
                            </div>
                        </span>
                    @elseif($task->priority == 'middle')
                        <span>Priority -<div class="badge badge-success bg-yellow-600">{{ $task->priority }}
                            </div>
                        </span>
                    @endif
                </div>
            </div>
        @endforeach
        {{-- Add Button --}}
        <div class="flex items-center justify-center ">
            <button id='progress' class="bg-blue-700 text-white p-2 mt-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </button>
        </div>
    </div>

    <div class="bg-green-400 shadow-md rounded-lg p-2 border border-gray-200 grid-cols-1">
        <p class="text-center font-medium text-xl mb-1 mt-0">Complete</p>

        @foreach (collect($project->tasks)->where('status', 'complete') as $task)
            <div class="border border-gray-300 rounded-md p-1 bg-white leading-9 mb-2">
                <div class="flex justify-between">
                    <span class="text-lg font-normal">{{ $task->title }}</span>
                    <div>
                        <button id="edit-complete" data-task="{{base64_encode(json_encode($task))}}" data-task-members="{{base64_encode(json_encode(collect($task->members)->pluck('id')->toArray()))}}" class="bg-green-500 text-white p-0 rounded-lg mr-2 hover:bg-green-600"><svg
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </button>
                        <button id="delete-complete" data-id="{{$task->id}}" class="bg-red-500 text-white p-0 rounded-lg hover:bg-red-600"><svg
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex justify-between">
                    <div class="flex items-center">
                        <span class="flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="size-6 font-bold">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </span>
                        <div class="badge badge-success bg-black ms-2">{{ $task->deadline }}</div>
                    </div>
                    {{-- avatar --}}
                    <div class="avatar-group -space-x-6 rtl:space-x-reverse">
                        @foreach ($task->members as $member)
                            <div class="avatar">
                                <div class="w-8">
                                    <img src="{{ asset($member->getFirstMediaUrl('images')) }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    @if ($task->priority == 'high')
                        <span>Priority -<div class="badge badge-success bg-red-600">{{ $task->priority }}
                            </div>
                        </span>
                    @elseif($task->priority == 'low')
                        <span>Priority -<div class="badge badge-success bg-green-600">{{ $task->priority }}
                            </div>
                        </span>
                    @elseif($task->priority == 'middle')
                        <span>Priority -<div class="badge badge-success bg-yellow-600">{{ $task->priority }}
                            </div>
                        </span>
                    @endif
                </div>
            </div>
        @endforeach
        {{-- Add Button --}}
        <div class="flex items-center justify-center ">
            <button id='complete' class="bg-blue-700 text-white p-2 mt-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </button>
        </div>
    </div>

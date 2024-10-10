<x-app-layout>
    <div class="container mx-auto py-10 max-h-full overflow-y-auto mb-10">
        <div class="grid grid-cols-6 gap-3">
            <div class="col-span-5 leading-5 border p-3 border-gray-600 shadow-md rounded">
                <div>
                    <span class='text-xl font-normal'>Project Title : </span> <span
                        class='text-1xl font-light'>{{ $project->title }}</span>
                </div>
                <div>
                    <span class='text-xl font-normal'>Start Date : </span> <span
                        class='text-1xl font-light'>{{ $project->start_date }}</span>
                </div>
                <div>
                    <span class='text-xl font-normal'>Deadline : </span> <span
                        class='text-1xl font-light'>{{ $project->deadline }}</span>
                </div>
                <div class="mb-2">
                    <span class='text-xl font-normal'>Status : </span> <span class='text-1xl font-light me-2'>
                        @if ($project->status == 'progess')
                            <div class="badge badge-success bg-green-600">{{ $project->status }}</div>
                        @elseif ($project->status == 'pending')
                            <div class="badge badge-warning bg-orange-400">{{ $project->status }}</div>
                        @else
                            <div class="badge badge-error bg-red-600">{{ $project->status }}</div>
                        @endif
                    </span>

                    <span class='text-xl font-normal'>Priority : </span> <span class='text-1xl font-light me-2'>
                        @if ($project->priority == 'high')
                            <div class="badge badge-success bg-green-600">{{ $project->priority }}</div>
                        @elseif ($project->priority == 'middle')
                            <div class="badge badge-warning bg-orange-400">{{ $project->priority }}</div>
                        @else
                            <div class="badge badge-error bg-red-600">{{ $project->priority }}</div>
                        @endif
                    </span>
                </div>
                <hr>
                <div class="mt-3">
                    <p class='text-3xl font-normal mb-2'>Description</p>
                    <p class="text-pretty text-justify">
                        {{ $project->description }}
                    </p>
                </div>
            </div>
            <div class="col-span-1">
                <div class="col-span-5 leading-5 border p-3 border-gray-600 shadow-md rounded">
                    <p class='text-xl font-normal'>Leaders </p>
                    <div id='image1' class="flex flex-wrap justify-around items-center mt-2 gap-1">
                        @foreach ($leaderImages as $images)
                            @foreach ($images as $image)
                                <img class="rounded-full border-gray-600 object-cover"
                                    style="width: 30px; height : 30px" src="{{ $image->getUrl() }}" alt=""
                                    srcset="">
                            @endforeach
                        @endforeach
                    </div>
                </div>

                <div class="col-span-5 leading-5 border p-3 border-gray-600 shadow-md rounded">
                    <p class='text-xl font-normal'>Members </p>
                    <div id='image2' class="flex flex-wrap justify-around items-center  mt-2 gap-1">
                        @foreach ($memberImages as $images)
                            @foreach ($images as $image)
                                <img class="rounded-full border-gray-600 object-cover"
                                    style="width: 30px; height : 30px" src="{{ $image->getUrl() }}" alt=""
                                    srcset="">
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="text-2xl font-medium mt-3 ms-1">Images</div>

        <div id='image3' class="flex justify-items-start space-x-2 mt-2 ms-1">
            @foreach ($project->getMedia('images') as $image)
                <img class="object-cover" style="width: 200px; height : 120px" src="{{ asset($image->getFullUrl()) }}"
                    alt="" srcset="">
            @endforeach
        </div>

        <div class="text-2xl font-medium mt-3 ms-1">Files</div>

        <div class="flex justify-items-start space-x-2 mt-2 ms-1">
            @foreach ($project->getMedia('files') as $file)
                <div class="border p-3 border-gray-600 shadow-md rounded">
                    <a href="{{ $file->getUrl() }}" target="_blank">{{ $file->file_name }}</a>
                </div>
            @endforeach
        </div>

        <!-- Input for adding new tasks -->
        <div id="tasks" class="grid grid-cols-3 gap-2 mt-3"></div>
    </div>

</x-app-layout>

<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var leaders = @json($project->leaders);
    var members = @json($project->members);
    var project_id = {{ $project->id }};

    function getTasks() {
        $.ajax({
            type: "GET",
            url: `/tasks?id=${project_id}`,
            success: function(res) {
                $('#tasks').html(res); // Load the tasks
            }
        });
    }
    getTasks();

    $(document).ready(function() {
        $(document).on('click', '#pending', function(e) {
            e.preventDefault();

            var task_members_options = '';
            leaders.forEach(leader => {
                task_members_options += `<option value='${leader.id}'>${leader.name}</option>`;
            });
            members.forEach(member => {
                task_members_options += `<option value='${member.id}'>${member.name}</option>`;
            });

            Swal.fire({
                title: 'Add Task',
                confirmButtonText: 'Submit',
                html: `
                    <form id="project-pending">
                        <input type='hidden' name='project_id' value='${project_id}' />
                        <input type='hidden' name='status' value='pending' />

                        <div class="">
                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="title">Title</label>
                                <input name="title" id="title" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black" />
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="description">Description</label>
                                <textarea name="description" rows="1" id="description" class="form-textarea px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black"></textarea>
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="datepicker">Start Date</label>
                                <input name="start_date" id="datepicker" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="deadline">Deadline</label>
                                <input name="deadline" id="deadline" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="members">Members</label>
                                <select multiple="multiple" name="members[]" id="members" class="form-control js-example-basic-multiple">
                                    ${task_members_options}
                                </select>
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="priority">Priority</label>
                                <select name="priority" id="priority" class="form-control">
                                    <option value="" disabled selected>-- Select --</option>
                                    <option value="high">High</option>
                                    <option value="middle">Middle</option>
                                    <option value="low">Low</option>
                                </select>
                            </div>
                        </div>
                    </form>
                `,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: `/task`,
                        data: $('#project-pending').serialize(),
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },
                        success: function(res) {
                            getTasks(); // Reload tasks
                        }
                    });
                }
            });
            // Initialize flatpickr and select2
            flatpickr("#deadline , #datepicker", {
                dateFormat: "Y-m-d",
                yearSelector: true
            });

            $('.js-example-basic-multiple').select2({
                placeholder: "-- Select --",
            });
        });

        $(document).on('click', '#progress', function(e) {
            e.preventDefault();

            var task_members_options = '';
            leaders.forEach(leader => {
                task_members_options += `<option value='${leader.id}'>${leader.name}</option>`;
            });
            members.forEach(member => {
                task_members_options += `<option value='${member.id}'>${member.name}</option>`;
            });

            Swal.fire({
                title: 'Add Task',
                confirmButtonText: 'Submit',
                html: `
                    <form id="project-pending">
                        <input type='hidden' name='project_id' value='${project_id}' />
                        <input type='hidden' name='status' value='progress' />

                        <div class="">
                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="title">Title</label>
                                <input name="title" id="title" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black" />
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="description">Description</label>
                                <textarea name="description" rows="1" id="description" class="form-textarea px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black"></textarea>
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="datepicker">Start Date</label>
                                <input name="start_date" id="datepicker" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="deadline">Deadline</label>
                                <input name="deadline" id="deadline" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="members">Members</label>
                                <select multiple="multiple" name="members[]" id="members" class="form-control js-example-basic-multiple">
                                    ${task_members_options}
                                </select>
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="priority">Priority</label>
                                <select name="priority" id="priority" class="form-control">
                                    <option value="" disabled selected>-- Select --</option>
                                    <option value="high">High</option>
                                    <option value="middle">Middle</option>
                                    <option value="low">Low</option>
                                </select>
                            </div>
                        </div>
                    </form>
                `,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: `/task`,
                        data: $('#project-pending').serialize(),
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },
                        success: function(res) {
                            getTasks(); // Reload tasks
                        }
                    });
                }
            });
            // Initialize flatpickr and select2
            flatpickr("#deadline , #datepicker", {
                dateFormat: "Y-m-d",
                yearSelector: true
            });

            $('.js-example-basic-multiple').select2({
                placeholder: "-- Select --",
            });
        });

        $(document).on('click', '#complete', function(e) {
            e.preventDefault();

            var task_members_options = '';
            leaders.forEach(leader => {
                task_members_options += `<option value='${leader.id}'>${leader.name}</option>`;
            });
            members.forEach(member => {
                task_members_options += `<option value='${member.id}'>${member.name}</option>`;
            });

            Swal.fire({
                title: 'Add Task',
                confirmButtonText: 'Submit',
                html: `
                    <form id="project-pending">
                        <input type='hidden' name='project_id' value='${project_id}' />
                        <input type='hidden' name='status' value='complete' />

                        <div class="">
                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="title">Title</label>
                                <input name="title" id="title" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black" />
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="description">Description</label>
                                <textarea name="description" rows="1" id="description" class="form-textarea px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black"></textarea>
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="datepicker">Start Date</label>
                                <input name="start_date" id="datepicker" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="deadline">Deadline</label>
                                <input name="deadline" id="deadline" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="members">Members</label>
                                <select multiple="multiple" name="members[]" id="members" class="form-control js-example-basic-multiple">
                                    ${task_members_options}
                                </select>
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="priority">Priority</label>
                                <select name="priority" id="priority" class="form-control">
                                    <option value="" disabled selected>-- Select --</option>
                                    <option value="high">High</option>
                                    <option value="middle">Middle</option>
                                    <option value="low">Low</option>
                                </select>
                            </div>
                        </div>
                    </form>
                `,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: `/task`,
                        data: $('#project-pending').serialize(),
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },
                        success: function(res) {
                            getTasks(); // Reload tasks
                        }
                    });
                }
            });
            // Initialize flatpickr and select2
            flatpickr("#deadline , #datepicker", {
                dateFormat: "Y-m-d",
                yearSelector: true
            });

            $('.js-example-basic-multiple').select2({
                placeholder: "-- Select --",
            });
        });

        $(document).on('click', '#edit-pending', function(e) {
            e.preventDefault();

            var task = JSON.parse(atob($(this).data('task')));
            var task_members = JSON.parse(atob($(this).data('task-members')));

            var task_members_options = '';
            leaders.forEach(leader => {
                task_members_options +=
                    `<option value='${leader.id}' ${(task_members.includes(leader.id) ? 'selected' : '')}>${leader.name}</option>`;
            });
            members.forEach(member => {
                task_members_options +=
                    `<option value='${member.id}' ${(task_members.includes(member.id) ? 'selected' : '')}>${member.name}</option>`;
            });

            Swal.fire({
                title: 'Edit Task',
                confirmButtonText: 'Submit',
                html: `
                    <form id="edit-pending-task">
                        <input type='hidden' name='project_id' value='${project_id}' />
                        <input type='hidden' name='status' value='pending' />

                        <div class="">
                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="title">Title</label>
                                <input value='${task.title}' name="title" id="title" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black" />
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="description">Description</label>
                                <textarea name="description" rows="1" id="description" class="form-textarea px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">${task.description}</textarea>
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="datepicker">Start Date</label>
                                <input value='${task.start_date}' name="start_date" id="datepicker" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="deadline">Deadline</label>
                                <input  value='${task.deadline}' name="deadline" id="deadline" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="members">Members</label>
                                <select multiple="multiple" name="members[]" id="members" class="form-control js-example-basic-multiple">
                                    ${task_members_options}
                                </select>
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="priority">Priority</label>
                                <select name="priority" id="priority" class="form-control">
                                    <option value="" disabled selected>-- Select --</option>
                                    <option ${(task.priority === 'high' ? 'selected' : '')} value="high">High</option>
                                    <option ${(task.priority === 'middle' ? 'selected' : '')} value="middle">Middle</option>
                                    <option ${(task.priority === 'low' ? 'selected' : '')} value="low">Low</option>
                                </select>
                            </div>
                        </div>
                    </form>
                `,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "PUT",
                        url: `/task/${task.id}`,
                        data: $('#edit-pending-task').serialize(),
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },

                        success: function(res) {
                            console.log(res),

                                getTasks(); // Reload tasks
                        }
                    });
                }
            });
            // Initialize flatpickr and select2
            flatpickr("#deadline , #datepicker", {
                dateFormat: "Y-m-d",
                yearSelector: true
            });

            $('.js-example-basic-multiple').select2({
                placeholder: "-- Select --",
            });
        });

        $(document).on('click', '#edit-progress', function(e) {
            e.preventDefault();

            var task = JSON.parse(atob($(this).data('task')));
            var task_members = JSON.parse(atob($(this).data('task-members')));

            var task_members_options = '';
            leaders.forEach(leader => {
                task_members_options +=
                    `<option value='${leader.id}' ${(task_members.includes(leader.id) ? 'selected' : '')}>${leader.name}</option>`;
            });
            members.forEach(member => {
                task_members_options +=
                    `<option value='${member.id}' ${(task_members.includes(member.id) ? 'selected' : '')}>${member.name}</option>`;
            });

            Swal.fire({
                title: 'Edit Task',
                confirmButtonText: 'Submit',
                html: `
                    <form id="edit-pending-task">
                        <input type='hidden' name='project_id' value='${project_id}' />
                        <input type='hidden' name='status' value='pending' />

                        <div class="">
                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="title">Title</label>
                                <input value='${task.title}' name="title" id="title" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black" />
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="description">Description</label>
                                <textarea name="description" rows="1" id="description" class="form-textarea px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">${task.description}</textarea>
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="datepicker">Start Date</label>
                                <input value='${task.start_date}' name="start_date" id="datepicker" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="deadline">Deadline</label>
                                <input  value='${task.deadline}' name="deadline" id="deadline" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="members">Members</label>
                                <select multiple="multiple" name="members[]" id="members" class="form-control js-example-basic-multiple">
                                    ${task_members_options}
                                </select>
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="priority">Priority</label>
                                <select name="priority" id="priority" class="form-control">
                                    <option value="" disabled selected>-- Select --</option>
                                    <option ${(task.priority === 'high' ? 'selected' : '')} value="high">High</option>
                                    <option ${(task.priority === 'middle' ? 'selected' : '')} value="middle">Middle</option>
                                    <option ${(task.priority === 'low' ? 'selected' : '')} value="low">Low</option>
                                </select>
                            </div>
                        </div>
                    </form>
                `,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "PUT",
                        url: `/task/${task.id}`,
                        data: $('#edit-pending-task').serialize(),
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },

                        success: function(res) {
                            console.log(res),

                                getTasks(); // Reload tasks
                        }
                    });
                }
            });
            // Initialize flatpickr and select2
            flatpickr("#deadline , #datepicker", {
                dateFormat: "Y-m-d",
                yearSelector: true
            });

            $('.js-example-basic-multiple').select2({
                placeholder: "-- Select --",
            });
        });

        $(document).on('click', '#edit-complete', function(e) {
            e.preventDefault();

            var task = JSON.parse(atob($(this).data('task')));
            var task_members = JSON.parse(atob($(this).data('task-members')));

            var task_members_options = '';
            leaders.forEach(leader => {
                task_members_options +=
                    `<option value='${leader.id}' ${(task_members.includes(leader.id) ? 'selected' : '')}>${leader.name}</option>`;
            });
            members.forEach(member => {
                task_members_options +=
                    `<option value='${member.id}' ${(task_members.includes(member.id) ? 'selected' : '')}>${member.name}</option>`;
            });

            Swal.fire({
                title: 'Edit Task',
                confirmButtonText: 'Submit',
                html: `
                    <form id="edit-pending-task">
                        <input type='hidden' name='project_id' value='${project_id}' />
                        <input type='hidden' name='status' value='pending' />

                        <div class="">
                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="title">Title</label>
                                <input value='${task.title}' name="title" id="title" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black" />
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="description">Description</label>
                                <textarea name="description" rows="1" id="description" class="form-textarea px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">${task.description}</textarea>
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="datepicker">Start Date</label>
                                <input value='${task.start_date}' name="start_date" id="datepicker" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="deadline">Deadline</label>
                                <input  value='${task.deadline}' name="deadline" id="deadline" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black">
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="members">Members</label>
                                <select multiple="multiple" name="members[]" id="members" class="form-control js-example-basic-multiple">
                                    ${task_members_options}
                                </select>
                            </div>

                            <div class="max-w-lg flex flex-col mb-3">
                                <label class="block text-lg font-medium text-gray-700 text-start" for="priority">Priority</label>
                                <select name="priority" id="priority" class="form-control">
                                    <option value="" disabled selected>-- Select --</option>
                                    <option ${(task.priority === 'high' ? 'selected' : '')} value="high">High</option>
                                    <option ${(task.priority === 'middle' ? 'selected' : '')} value="middle">Middle</option>
                                    <option ${(task.priority === 'low' ? 'selected' : '')} value="low">Low</option>
                                </select>
                            </div>
                        </div>
                    </form>
                `,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "PUT",
                        url: `/task/${task.id}`,
                        data: $('#edit-pending-task').serialize(),
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },

                        success: function(res) {
                            console.log(res),

                                getTasks(); // Reload tasks
                        }
                    });
                }
            });
            // Initialize flatpickr and select2
            flatpickr("#deadline , #datepicker", {
                dateFormat: "Y-m-d",
                yearSelector: true
            });

            $('.js-example-basic-multiple').select2({
                placeholder: "-- Select --",
            });
        });

        $(document).on('click', '#delete-pending', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "DELETE",
                        url: `/task/${id}`,
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },
                        success: function(res) {
                            if (res.success === 1) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        getTasks();
                                    }
                                });
                            }
                        }
                    });
                }
            });
        });

        $(document).on('click', '#delete-progress', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "DELETE",
                        url: `/task/${id}`,
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },
                        success: function(res) {
                            if (res.success === 1) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        getTasks();
                                    }
                                });
                            }
                        }
                    });
                }
            });

        });

        $(document).on('click', '#delete-complete', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "DELETE",
                        url: `/task/${id}`,
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },
                        success: function(res) {
                            if (res.success === 1) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        getTasks();
                                    }
                                });
                            }
                        }
                    });
                }
            });

        });
    });
</script>

<style>
    .select2-container--open {
        z-index: 99999999999999;
    }
</style>

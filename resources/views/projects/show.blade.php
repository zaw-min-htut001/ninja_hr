<x-app-layout>
    <div class="container mx-auto py-10 max-h-full overflow-y-auto mb-10">
        <div class="grid grid-cols-6 gap-3">
            <div class="col-span-5 leading-5 border p-3 border-gray-600 shadow-md rounded">
                <div>
                    <span class='text-xl font-normal'>Project Title : </span> <span class='text-1xl font-light'>{{ $project->title }}</span>
                </div>
                <div>
                    <span class='text-xl font-normal'>Start Date : </span> <span class='text-1xl font-light'>{{ $project->start_date }}</span>
                </div>
                <div>
                    <span class='text-xl font-normal'>Deadline : </span> <span class='text-1xl font-light'>{{ $project->deadline }}</span>
                </div>
                <div class="mb-2">
                    <span class='text-xl font-normal'>Status : </span> <span class='text-1xl font-light me-2'>
                        @if($project->status == 'progess')
                        <div class="badge badge-success bg-green-600">{{$project->status}}</div>
                        @elseif ($project->status == 'pending')
                        <div class="badge badge-warning bg-orange-400">{{$project->status}}</div>
                        @else
                        <div class="badge badge-error bg-red-600">{{$project->status}}</div>
                        @endif
                    </span>

                    <span class='text-xl font-normal'>Priority : </span> <span class='text-1xl font-light me-2'>
                        @if($project->priority == 'high')
                        <div class="badge badge-success bg-green-600">{{$project->priority}}</div>
                        @elseif ($project->priority == 'middle')
                        <div class="badge badge-warning bg-orange-400">{{$project->priority}}</div>
                        @else
                        <div class="badge badge-error bg-red-600">{{$project->priority}}</div>
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
                    <div class="flex flex-wrap justify-around items-center mt-2 gap-1">
                        @foreach($leaderImages as $images)
                        @foreach($images as $image)
                        <img class="rounded-full border-gray-600 object-cover" style="width: 30px; height : 30px" src="{{ $image->getUrl() }}" alt="" srcset="">
                        @endforeach
                        @endforeach
                    </div>
                </div>

                <div class="col-span-5 leading-5 border p-3 border-gray-600 shadow-md rounded">
                    <p class='text-xl font-normal'>Members </p>
                    <div class="flex flex-wrap justify-around items-center  mt-2 gap-1">
                        @foreach($memberImages as $images)
                        @foreach($images as $image)
                        <img class="rounded-full border-gray-600 object-cover" style="width: 30px; height : 30px" src="{{ $image->getUrl() }}" alt="" srcset="">
                        @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="text-2xl font-medium mt-3 ms-1">Images</div>

        <div  id='image'  class="flex justify-items-start space-x-2 mt-2 ms-1">
            @foreach ($project->getMedia("images") as $image)
            <img class="object-cover" style="width: 200px; height : 120px" src="{{ asset($image->getFullUrl()) }}" alt="" srcset="">
            @endforeach
        </div>

        <div class="text-2xl font-medium mt-3 ms-1">Files</div>

        <div class="flex justify-items-start space-x-2 mt-2 ms-1">
            @foreach ($project->getMedia("files") as $file)
            <div class="border p-3 border-gray-600 shadow-md rounded">
            <a href="{{ $file->getUrl() }}" target="_blank">{{ $file->file_name}}</a>
            </div>
            @endforeach
        </div>
    </div>

</x-app-layout>

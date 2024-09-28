<x-app-layout>
    <div class="flex justify-center items-center max-w-full h-96">
        <div class="rounded-3xl shadow-md bg-gray-100">
            <div class="flex flex-col justify-center items-center">
                <img style="height: 200px" src="{{ asset('images/scan.avif') }}" alt="Ninja Hr"
                    class="border-2 border-black m-4" srcset="">
                <button id='openModalBtn' class="btn btn-sm mb-3 btn-outline btn-success text-white">Scan Qr</button>

                <!-- Modal Container (Hidden by Default) -->
                <div id="myModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900 bg-opacity-50">
                    <div class="flex items-center justify-center min-h-screen px-4">
                        <!-- Modal Content -->
                        <div class="relative bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                            <h2 class="text-xl font-bold text-gray-800">Scan</h2>
                            <div>
                                <video id="qr-video" style="width: 500px; height: auto;"></video>

                            </div>
                            <!-- Close Button -->
                            <button id="closeModalBtn" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                                &times;
                            </button>

                            <!-- Modal Footer -->
                            <div class="mt-6 text-right">
                                <button id="closeModalBtn2"
                                    class="px-4 py-2 mr-2 font-semibold text-gray-600 bg-gray-200 rounded hover:bg-gray-300">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Permission') }}
        </h2>
    </x-slot>

    <div class="py-5 mb-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg mb-[40px]">

                <form id="permission-form" action="{{ route('permissions.update' , $permission->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="flex justify-center items-center">
                        <div class="">
                            <div class="w-7xl mt-3 mb-3">
                                <label class="block text-lg font-medium text-gray-700" for="name">Name</label>
                                <input value="{{ $permission->name }}" name="name" id="name" type="text" class="form-input px-4 py-3 rounded  border-gray-300 focus:ring-black focus:border-black" />
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center mt-5 mb-3">
                        <x-primary-button class="btn font-medium">Submit</x-primary-button>
                    </div>
                </form>
        </div>
    </div>
</x-app-layout>
     <!-- Scripts -->
     <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
     <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
      <!-- Laravel Javascript Validation -->
     <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
     {!! JsValidator::formRequest('App\Http\Requests\UpdatePermission', '#permission-form'); !!}
 <script>

 </script>

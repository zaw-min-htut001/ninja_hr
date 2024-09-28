<x-app-layout>
    <div class="flex justify-center items-center max-w-full h-96">
        <div class="rounded-3xl shadow-md bg-gray-100">
            <div class="artboard artboard-horizontal phone-6">
                <div class="text-center">
                    <div class="flex justify-center m-2">
                        {!! QrCode::size(200)->generate(date('Y-m-d')) !!}
                    </div>
                    <p>Scan me to check-in. or Please enter pin code ! </p>
                </div>
                <div class="flex justify-center items-center border-t mt-2">
                    <div class="p-3 w-auto">
                        <input type="text" name="mycode" id="pincode-input1">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/sf-bootstrap-pincode-input@1.5.0/css/bootstrap-pincode-input.min.css">
<script src="https://cdn.jsdelivr.net/npm/sf-bootstrap-pincode-input@1.5.0/js/bootstrap-pincode-input.min.js"></script>
<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $(document).ready(function() {
        $('#pincode-input1').pincodeInput({
            inputs: 6,
            complete: function(value, e, errorElement) {

                $.ajax({
                    type: "POST",
                    url: '/check-in/check-out',
                    data: {
                        _token: CSRF_TOKEN,
                        pin_code: value
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "success",
                                title: res.message
                            });
                        } else {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "error",
                                title: res.message
                            });
                        }
                    }
                });
            }
        });
    });
</script>

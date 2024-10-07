import "./bootstrap";

import Alpine from "alpinejs";

import "bootstrap";

import * as FilePond from "filepond";
import "filepond/dist/filepond.min.css";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";

const inputElement = document.querySelector('input[type="file"].filepond');
const inputElement1 = document.querySelector('input[type="file"].filepond1');
const inputElement2 = document.querySelector('input[type="file"]#fileupload');


const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

FilePond.registerPlugin(
    FilePondPluginImagePreview,
    FilePondPluginFileValidateType
);

FilePond.create(inputElement).setOptions({
    acceptedFileTypes: ["image/jpeg", "image/png"],
    server: {
        process: "/upload",
        revert: "/destory",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
    },
});

FilePond.create(inputElement1).setOptions({
    acceptedFileTypes: ['image/*'], // Accept only images
    allowMultiple: true,            // Allow multiple file uploads
    maxFileSize: '3MB',             // Limit file size
    maxFiles: 5,
    server: {
        process: "/upload-multi",
        revert: "/destory-images",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
    },
});

FilePond.create(inputElement2).setOptions({
    acceptedFileTypes:  ['application/pdf'],
    allowMultiple: true,            // Allow multiple file uploads
    maxFileSize: '3MB',             // Limit file size
    maxFiles: 5,
    server: {
        process: "/upload-files",
        revert: "/destory-files",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
    },
});
window.Alpine = Alpine;

Alpine.start();

import QrScanner from "qr-scanner"; // Import the Nimiq QR Scanner
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

// DOMContentLoaded ensures that the DOM is fully loaded before executing the script
document.addEventListener("DOMContentLoaded", function () {
    const videoElem = document.getElementById("qr-video"); // Get the video element
    const qrScanner = new QrScanner(videoElem, (result) => {
        $.ajax({
            type: "POST",
            url: "/scan-qr",
            data: {
                _token: CSRF_TOKEN,
                date: result,
            },
            dataType: "json",
            success: function (res) {
                if (res.status === "success") {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        },
                    });
                    Toast.fire({
                        icon: "success",
                        title: res.message,
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
                        },
                    });
                    Toast.fire({
                        icon: "error",
                        title: res.message,
                    });
                }
            },
        });
        console.log(result);
        if (result) {
            modal.classList.add("hidden");
            qrScanner.stop(); // Start scanning
        }
    });
    const openModalBtn = document.getElementById("openModalBtn");
    const closeModalBtn = document.getElementById("closeModalBtn");
    const closeModalBtn2 = document.getElementById("closeModalBtn2");
    const modal = document.getElementById("myModal");
    // Open Modal
    openModalBtn.addEventListener("click", () => {
        modal.classList.remove("hidden");
        qrScanner.start(); // Start scanning
    });
    // Close Modal
    closeModalBtn.addEventListener("click", () => {
        modal.classList.add("hidden");
        qrScanner.stop(); // Start scanning
    });
    closeModalBtn2.addEventListener("click", () => {
        modal.classList.add("hidden");
        qrScanner.stop(); // Start scanning
    });
    // Close modal when clicking outside of modal content
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.classList.add("hidden");
            qrScanner.stop();
        }
    };
});


import Viewer from 'viewerjs';
import 'viewerjs/dist/viewer.css';
// View an image.
// View an image.
const viewer = new Viewer(document.getElementById('image'), {
    viewed() {
      viewer.zoomTo(1);
    },
  });

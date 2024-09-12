import './bootstrap';

import Alpine from 'alpinejs';

import 'bootstrap';

import * as FilePond from 'filepond';
import 'filepond/dist/filepond.min.css';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';

const inputElement = document.querySelector('input[type="file"].filepond');

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

FilePond.registerPlugin(FilePondPluginImagePreview , FilePondPluginFileValidateType);

FilePond.create(inputElement).setOptions({
    acceptedFileTypes: ['image/jpeg' ,'image/png'],
    server: {
        process: '/upload',
        revert: '/destory',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        }
    },
});

window.Alpine = Alpine;

Alpine.start();

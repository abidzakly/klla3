<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/css/app.css')
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Target hanya input number dalam DataTables */
        .dataTables_wrapper input[type="number"]::-webkit-outer-spin-button,
        .dataTables_wrapper input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .dataTables_wrapper {
            color: white !important;
        }

        .dataTables_wrapper input[type="number"] {
            -moz-appearance: textfield;
            /* Firefox */
        }

        /* Hilangkan style background putih default dari DataTables */
        .dataTables_wrapper table.dataTable tbody tr,
        .dataTables_wrapper table.dataTable tbody td {
            background-color: transparent !important;
            /* Gunakan transparent agar warna custom bisa diterapkan */
            /* border: 1px solid #d1d5db; */
            /* Tetap tampilkan border */
            color: white !important;
            /* Set text color to white */
        }

        /* Warna teks "Showing X of Y entries" */
        .dataTables_info {
            color: white !important;
        }

        /* Warna teks dalam pagination */
        .dataTables_paginate .paginate_button {
            color: white !important;
        }

        /* Warna teks pagination yang aktif */
        .dataTables_paginate .paginate_button.current {
            background-color: white !important;
            color: black !important;
        }

        .paginate_button previous:not(.disabled):hover,
        .paginate_button next:not(.disabled):hover {
            background-color: white !important;
            color: black !important;
        }

        .dataTables_wrapper .dataTables_length {
            color: white !important;
            margin-bottom: 1rem;
        }

        .dataTables_filter {
            color: white !important;
        }

        #data-table_wrapper {
            width: 100%;
            max-height: 700px;
            /* Batas maksimal lebar tabel */
            overflow-x: auto;
            /* Scroll horizontal */
        }

        #data-table th,
        #data-table td {
            border: none;
            padding: 8px;
            text-align: center;
        }

        .editable-textarea {
            width: 100%;
            /* height: 100px; */
            border: 1px solid #ccc;
            resize: none;
            color: white;
            background-color: transparent;
        }

        .editable-textarea.edit-mode {
            border: 1px solid #d1d5db;
            /* Border for edit mode */
        }

        .editable-textarea[readonly] {
            border: none;
        }
    </style>
</head>

<body style="background-image: url('{{ asset('image/background.png') }}');"
    class="bg-cover bg-center flex flex-col items-center min-h-screen">
    <nav class="bg-green-900 text-white w-full px-6 py-4 flex items-center shadow-md relative">
        <img src="{{ asset('image/logooo 1.png') }}" alt="Logo" class="absolute left-6">
        <h1 class="text-xl font-bold mx-auto text-center" style="font-size: 36px;">Report Big Event</h1>
    </nav>

    <div class="w-[80%] mt-6">
        <div class="relative w-full flex items-center justify-start px-6 font-bold text-white mt-4 mb-3 z-2">
            <button id="branchDropdownButton" class="text-xl font-bold text-white bg-green-600 px-6 py-2 rounded-lg">
                {{ $branch->branch_name }} ▼
            </button>

            <div id="branchDropdownMenu"
                class="hidden absolute left-0 mt-2 bg-white shadow-lg rounded-lg w-52 max-h-60 overflow-y-auto transition-all duration-300 opacity-0 transform scale-95">
                <input type="hidden" id="branchId" value="{{ $branch->id_branch }}">
                @foreach (App\Models\Branch::all() as $branch)
                    <a href="{{ route('photo.event.type', $photoEventType) }}{{ '?branch=' . $branch->branch_name }}"
                        class="block px-5 py-3 text-black hover:bg-gray-100 transition-all duration-300">
                        {{ $branch->branch_name }}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="relative w-full flex flex-col rounded-lg shadow-md items-center justify-center group p-6">
            <div id="drop-area" class="w-full min-h-[80vh] h-full absolute inset-0 bg-green-800 opacity-70 rounded-lg">
            </div>

            <div class="relative w-full flex items-center px-6 font-bold text-white">
                <a href="{{ route('dashboard') }}" class="text-white">
                    <i class="fa-solid fa-arrow-left text-2xl ml-2"></i>
                </a>

                <div class="absolute left-1/2 -translate-x-1/2 z-3">
                    <button id="dropdownButton" class="text-xl font-bold text-white">
                        Foto Foto {{ $photoEventType->photo_event_type_name }} ▼
                    </button>

                    <div id="dropdownMenu"
                        class="hidden absolute left-[55%] mt-2 bg-white shadow-lg rounded-lg w-52 max-h-60 overflow-y-auto transition-all duration-300 opacity-0 transform scale-95">
                        @foreach (App\Models\PhotoEventType::all() as $item)
                            @if ($item->photo_event_type_name != $photoEventType->photo_event_type_name)
                                <a href="{{ route('photo.event.type', $item) }}"
                                    class="block px-5 py-3 text-black hover:bg-gray-100 transition-all duration-300">
                                    Foto {{ $item->photo_event_type_name }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                <label for="imageUpload"
                    class="cursor-pointer flex items-center gap-2 ml-auto text-white text-lg font-bold">
                    <i class="fa-solid fa-plus"></i>
                    <span>Upload Foto</span>
                    <input type="file" id="imageUpload" class="hidden" accept="image/*" multiple>
                </label>
            </div>

            @if ($photoEvents->isEmpty())
                <div id="child-drop-area"
                    class="text-white text-3xl font-bold relative flex flex-col w-full mt-40 gap-4 justify-center items-center  p-10 cursor-pointer focus:outline-none">
                    <i class="fa-regular fa-file text-white" style="font-size:56px;"></i>
                    <p>Tarik dan Lepaskan File Disini</p>
                    <p>atau</p>
                    <p>gunakan tombol "+"</p>

                    <input type="file" id="file-input" class="hidden" accept="image/*" multiple>
                </div>
            @else
                <div class="overflow-x-auto rounded-lg mt-4 w-full" id="child-drop-area">
                    <table id="data-table" class="w-full text-center text-black" style="border: none">
                        <thead>
                            <tr class="">
                                <th class="border-2 border-none px-2 py-2 w-full"></th>
                            </tr>
                        </thead>
                    </table>
                    <input type="file" id="file-input" class="hidden" accept="image/*" multiple>
                </div>
            @endif
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        const $dropArea = $("#drop-area");
        const $fileInput = $("#file-input");
        const $imageUpload = $("#imageUpload");
        const $childDropArea = $("#child-drop-area");
        const $uploadingMessage = $("#uploading-message");
        let isUploading = false;
        let table = null;

        function handleFiles(files) {
            if (isUploading) {
                Swal.fire({
                    icon: 'info',
                    title: 'Upload sedang berlangsung',
                    text: 'Mohon menunggu...',
                    timer: 1500,
                    showConfirmButton: false
                });
                return;
            }

            if (files.length > 0) {
                isUploading = true;
                $uploadingMessage.removeClass('hidden');
                const formData = new FormData();
                for (let i = 0; i < files.length; i++) {
                    formData.append('files[]', files[i]);
                }
                formData.append('photo_event_type_id', '{{ $photoEventType->id_photo_event_type }}');
                formData.append('branch_id', document.getElementById('branchId').value);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: '{{ route('photo-event.store', $photoEventType) }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (!response.error) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Upload berhasil',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                if (table) {
                                    table.ajax.reload(null, false);
                                } else {
                                    location.reload();
                                }
                                isUploading = false;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error uploading files',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        isUploading = false;
                        $uploadingMessage.addClass('hidden');
                    }
                }).always(() => {
                    $fileInput.val('');
                    $imageUpload.val('');
                });
            }
        }

        $childDropArea.on("dragover", function(e) {
            e.preventDefault();
            $dropArea.removeClass("opacity-70");
        });

        $childDropArea.on("dragleave", function() {
            $dropArea.addClass("opacity-70");
        });

        $childDropArea.on("drop", function(e) {
            e.preventDefault();
            $dropArea.addClass("opacity-70");
            const files = e.originalEvent.dataTransfer.files;
            handleFiles(files);
        });

        $childDropArea.on("click", function(e) {
            if (e.target.id == 'child-drop-area') {
                $fileInput.click();
            }
        });

        $dropArea.on("click", function() {
            $fileInput.click();
        });

        $dropArea.on("dragover", function(e) {
            e.preventDefault();
            $dropArea.removeClass("opacity-70");
        });

        $dropArea.on("dragleave", function() {
            $dropArea.addClass("opacity-70");
        });

        $dropArea.on("drop", function(e) {
            e.preventDefault();
            $dropArea.addClass("opacity-70");
            const files = e.originalEvent.dataTransfer.files;
            handleFiles(files);
        });

        $fileInput.on("change", function(e) {
            const files = e.target.files;
            handleFiles(files);
        });

        $imageUpload.on("change", function(e) {
            const files = e.target.files;
            handleFiles(files);
        });

        @if (!$photoEvents->isEmpty())
            table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('photo.event.data') }}",
                    data: function(d) {
                        d.photo_event_type_id = '{{ $photoEventType->id_photo_event_type }}';
                        d.branch_id = document.getElementById('branchId').value;
                    }
                },
                columns: [{
                    data: 'photos',
                    name: 'photos',
                    orderable: false,
                    searchable: true
                }],
                lengthMenu: [
                    [2, 10, 20, 60],
                    [2, 10, 20, 60]
                ],
                order: [
                    [0, 'desc']
                ],
                drawCallback: function(settings) {
                    $('.file-options-button').off('click').on('click', function() {
                        const menu = $(this).next('.file-options-menu');
                        $('.file-options-menu').not(menu).addClass(
                            'hidden opacity-0 scale-95');
                        menu.toggleClass('hidden opacity-0 scale-95');
                    });

                    $('.rename-button').off('click').on('click', function(e) {
                        e.preventDefault();
                        const id = $(this).data('id');
                        const p = $(this).parent().parent().parent().find('p');
                        const currentValue = p.data('current-value');
                        p.replaceWith(
                            `<input type="text" data-id="${id}" value="${currentValue}" data-current-value="${currentValue}" class="rename-input" style="color: black;">`
                            );
                        $(`input[data-id="${id}"]`).focus();
                    });

                    $('body').off('blur', '.rename-input').on('blur', '.rename-input', function() {
                        const id = $(this).data('id');
                        const newValue = $(this).val();
                        const input = $(this);
                        const current = input.data('current-value');

                        // Jika tidak ada perubahan, langsung replace kembali dengan teks awal
                        if (newValue === current) {
                            input.replaceWith(
                                `<p data-id="${id}" class="text-black truncate rename-trigger" data-current-value="${current}">${current}</p>`
                                );
                            return;
                        }

                        // Lakukan AJAX request untuk rename
                        $.ajax({
                            url: `/photo-event/${id}/rename`,
                            method: 'POST',
                            data: {
                                file_name: newValue,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (!response.error) {
                                    Toast.fire({
                                        icon: "success",
                                        title: response.message,
                                        timer: 1500,
                                    });
                                } else {
                                    Toast.fire({
                                        icon: "error",
                                        title: response.message,
                                        timer: 1500,
                                    });
                                }
                            },
                            error: function(response) {
                                response = response.responseJSON;
                                Toast.fire({
                                    icon: "error",
                                    title: response.message,
                                    timer: 1500,
                                });
                            }
                        }).always(() => {
                            table.ajax.reload(null, false);
                        });
                    });


                    $('.delete-button').off('click').on('click', function(e) {
                        e.preventDefault();
                        const id = $(this).data('id');
                        console.log(id);
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: `/photo-event/${id}`,
                                    method: 'DELETE',
                                    data: {
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(response) {
                                        if (!response.error) {
                                            Toast.fire({
                                                icon: "success",
                                                title: response
                                                    .message,
                                                timer: 1500,
                                            });
                                            table.ajax.reload(null,
                                                false);
                                        } else {
                                            let errorMessage = '';
                                            for (const [key,
                                                value] of Object
                                                .entries(response
                                                    .errors)) {
                                                errorMessage +=
                                                    `${value}\n`;
                                            }
                                            Toast.fire({
                                                icon: "error",
                                                title: errorMessage,
                                                timer: 1500,
                                            });
                                        }
                                    },
                                    error: function(response) {
                                        response = response
                                        .responseJSON;
                                        let errorMessage = '';
                                        for (const [key,
                                            value] of Object.entries(
                                                response.errors)) {
                                            errorMessage +=
                                            `${value}\n`;
                                        }
                                        Toast.fire({
                                            icon: "error",
                                            title: errorMessage,
                                            timer: 1500,
                                        });
                                    }
                                });
                            }
                        });
                    });
                }
            });
        @endif
    });
</script>

<script>
    const dropdownButton = document.getElementById("dropdownButton");
    const dropdownMenu = document.getElementById("dropdownMenu");

    dropdownButton.addEventListener("click", () => {
        dropdownMenu.classList.toggle("hidden");
        dropdownMenu.classList.toggle("opacity-0");
        dropdownMenu.classList.toggle("scale-95");
    });

    document.addEventListener("click", (event) => {
        if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.add("hidden", "opacity-0", "scale-95");
        }
    });

    const branchDropdownButton = document.getElementById("branchDropdownButton");
    const branchDropdownMenu = document.getElementById("branchDropdownMenu");

    branchDropdownButton.addEventListener("click", () => {
        branchDropdownMenu.classList.toggle("hidden");
        branchDropdownMenu.classList.toggle("opacity-0");
        branchDropdownMenu.classList.toggle("scale-95");
    });

    document.addEventListener("click", (event) => {
        if (!branchDropdownButton.contains(event.target) && !branchDropdownMenu.contains(event.target)) {
            branchDropdownMenu.classList.add("hidden", "opacity-0", "scale-95");
        }
    });

    document.querySelectorAll('.rename-button').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const id = button.dataset.id;
            const input = document.querySelector(`input[data-id="${id}"]`);
            input.removeAttribute('readonly');
            input.focus();
        });
    });

    document.querySelectorAll('input[type="text"]').forEach(input => {
        input.addEventListener('blur', () => {
            if (!input.hasAttribute('readonly')) {
                const id = input.dataset.id;
                const fileName = input.value;
                fetch(`/photo-event/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    body: JSON.stringify({
                        file_name: fileName
                    })
                }).then(response => {
                    if (response.ok) {
                        input.setAttribute('readonly', true);
                        location.reload();
                    } else {
                        alert('Error renaming file');
                    }
                });
            }
        });
    });
</script>

</html>

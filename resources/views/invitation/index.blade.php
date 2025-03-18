<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@1.39.1/iconfont/tabler-icons.min.css">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
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
            max-height: 550px;
            /* Batas maksimal lebar tabel */
            overflow-x: auto;
            /* Scroll horizontal */
        }

        #data-table th,
        #data-table td {
            border: 1px solid white;
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

    <div class="flex w-[80%] justify-center mt-6">
        <div class="relative w-full flex flex-col rounded-lg shadow-md items-center justify-center group p-6 mb-4">
            <div class="w-full min-h-[80vh] h-full absolute inset-0 bg-green-800  rounded-lg"></div>

            <div class="relative w-full flex items-center justify-between px-6 font-bold text-white">
                <a href="{{ route('dashboard') }}"><i style="font-size: 30px;" class="fa-solid fa-arrow-left text-2xl ml-2"></i></a>
                <p style="font-size: 30px;" class="text-xl">Data Undangan</p>
                <a href="{{ route('invitation.create') }}" class="inline-block px-4 py-2 mb-4 text-white bg-green-500 rounded hover:bg-green-600">
                    Tambah Data Undangan
                </a>
            </div>

            <div class="p-6 overflow-x-auto bg-green-800 rounded-lg shadow-md">
                <table id="data-table" class="w-full text-center text-black border border-collapse border-gray-300">
                    <thead>
                        <tr style="background-color: #E4E0E1;">
                            <th class="border-2 border-black px-2 py-2 w-24">No</th>
                            <th class="border-2 border-black px-2 py-2 w-64">Nama</th>
                            <th class="border-2 border-black px-2 py-2 w-48">Alamat</th>
                            <th class="border-2 border-black px-2 py-2 w-48">Nomor HP</th>
                            <th class="border-2 border-black px-2 py-2 w-96 ">Sales yang mengundang</th>
                            <th class="border-2 border-black px-2 py-2 w-48">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

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

            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('invitation.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        searchable: true
                    },
                    {
                        data: 'address',
                        name: 'address',
                        searchable: true
                    },
                    {
                        data: 'number_phone',
                        name: 'number_phone',
                        searchable: true
                    },
                    {
                        data: 'sales_invitation',
                        name: 'sales_invitation',
                        searchable: true
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [1, 'desc']
                ], // Order by the 'name' column instead of 'DT_RowIndex'
                drawCallback: function(settings) {
                    $('#data-table .edit').off('click').on('click', function() {
                        var id = $(this).data('id');
                        var row = $(this).closest('tr');

                        $('#data-table .cancel').click();

                        row.find('.editable').each(function() {
                            var value = $(this).text();
                            var name = $(this).attr('name');
                            var tdWidth = $(this).width();
                            console.log(name)
                            if (name === 'address') {
                                $(this).attr('data-current-value', value);
                                $(this).attr('readonly', false);
                            } else {
                                $(this).html('<input type="text" name="' + name +
                                    '" value="' + value +
                                    '" class="border border-gray-300 form-control editable" style="width:' +
                                    tdWidth +
                                    'px; color: white;" data-current-value="' +
                                    value + '">');
                            }
                        });

                        row.find('.edit').hide();
                        row.find('.delete').hide();
                        row.find('.action-buttons').append(
                            '<button class="flex items-center gap-2 px-4 py-2 text-white bg-green-500 rounded-lg save btn btn-custom hover:bg-green-600" data-id="' +
                            id + '">' +
                            '<i class="ti ti-check"></i> Save' +
                            '</button>'
                        );
                        row.find('.action-buttons').append(
                            '<button class="flex items-center gap-2 px-4 py-2 text-white bg-red-500 rounded-lg cancel btn btn-custom hover:bg-red-600" data-id="' +
                            id + '">' +
                            '<i class="ti ti-x"></i> Cancel' +
                            '</button>'
                        );
                    });
                },
            });

            $('#data-table').on('click', '.save', function() {
                $(this).prop('disabled', true);
                $(this).html('<i class="fa fa-spinner fa-spin"></i> Updating...');
                var id = $(this).data('id');
                var row = $(this).closest('tr');
                var data = {};
                row.find('input, textarea').each(function() {
                    var name = $(this).attr('name');
                    data[name] = $(this).val();
                });
                $.ajax({
                    url: '/invitation/' + id,
                    method: 'PUT',
                    data: data,
                    success: function(response) {
                        if (!response.error) {
                            Toast.fire({
                                icon: "success",
                                title: response.message,
                                timer: 1500,
                            });
                            table.ajax.reload(null, false);
                        } else {
                            let errorMessage = '';
                            for (const [key, value] of Object.entries(response.errors)) {
                                errorMessage += `${value}\n`;
                            }
                            Toast.fire({
                                icon: "error",
                                title: errorMessage,
                                timer: 1500,
                            });
                        }
                    },
                    error: function(response) {
                        response = response.responseJSON;
                        if (!response.error) {
                            Toast.fire({
                                icon: "error",
                                title: "An error occurred",
                                timer: 1500,
                            });
                        } else {
                            let errorMessage = '';
                            for (const [key, value] of Object.entries(response.errors)) {
                                errorMessage += `${value}\n`;
                            }
                            Toast.fire({
                                icon: "error",
                                title: errorMessage,
                                timer: 1500,
                            });
                        }
                    }
                }).always(function() {
                    row.find('.save').prop('disabled', false);
                    row.find('.save').html('<i class="ti ti-check"></i> Save');
                });
            });

            $('#data-table').on('click', '.cancel', function() {
                var row = $(this).closest('tr');
                row.find('.editable').each(function() {
                    var name = $(this).attr('name');
                    if (name == 'address') {
                        const value = $(this).data('current-value');
                        $(this).attr('readonly', true);
                        $(this).html(value);
                    } else {
                        const value = $(this).find('input').data('current-value');
                        let html = `<div class="editable" name="${name}">${value}</div>`;
                        $(this).html(html);
                    }
                });
                row.find('.save').remove();
                row.find('.cancel').remove();
                row.find('.edit').show();
                row.find('.delete').show();
            });

            $('#data-table').on('click', '.delete', function() {
                var id = $(this).data('id');
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
                        $(this).prop('disabled', true);
                        $(this).html('<i class="fa fa-spinner fa-spin"></i> Deleting...');
                        $.ajax({
                            url: '/invitation/' + id,
                            method: 'DELETE',
                            success: function(response) {
                                table.ajax.reload(null, false);
                                Toast.fire({
                                    icon: "success",
                                    title: response.message,
                                    timer: 1500,
                                });
                            },
                            error: function(response) {
                                Toast.fire({
                                    icon: "error",
                                    title: "An error occurred",
                                    timer: 1500,
                                });
                            }
                        }).always(function() {
                            $(this).prop('disabled', false);
                            $(this).html('<i class="ti ti-trash"></i> Delete');
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>

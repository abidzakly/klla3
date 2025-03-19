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

        .dataTables_wrapper {
            color: white !important;
        }

        .dataTables_wrapper input[type="number"] {
            -moz-appearance: textfield;
        }

        .dataTables_wrapper table.dataTable tbody tr,
        .dataTables_wrapper table.dataTable tbody td {
            background-color: transparent !important;
            color: white !important;
        }

        .dataTables_info {
            color: white !important;
        }

        .dataTables_paginate .paginate_button {
            color: white !important;
        }

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
            overflow-x: auto;
        }

        #data-table th,
        #data-table td {
            border: 1px solid white;
            padding: 8px;
            text-align: center;
        }

        .editable-textarea {
            width: 100%;
            border: 1px solid #ccc;
            resize: none;
            color: white;
            background-color: transparent;
        }

        .editable-textarea.edit-mode {
            border: 1px solid #d1d5db;
        }

        .editable-textarea[readonly] {
            border: none;
        }

        /* Make the scrollbar thin */
        ::-webkit-scrollbar {
            width: 6px;
            /* Width for vertical scrollbar */
            height: 8px;
            /* Height for horizontal scrollbar */
        }

        /* Handle (the moving part) */
        ::-webkit-scrollbar-thumb {
            background: #888;
            /* Color of the scrollbar handle */
            border-radius: 4px;
            /* Rounded corners */
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
            /* Darker shade when hovered */
        }

        /* Track (the background) */
        ::-webkit-scrollbar-track {
            background: lightgray;
            /* Hides the track */
        }

        input[type="checkbox"] {
            width: 20px;
            height: 20px;
            appearance: none;
            -webkit-appearance: none;
            background-color: #e0e0e0;
            border: 1px solid #ccc;
            border-radius: 3px;
            cursor: pointer;
            position: relative;
        }

        input[type="checkbox"]:checked {
            background-color: #4CAF50;
            border: 1px solid #4CAF50;
        }

        input[type="checkbox"]:checked::after {
            content: "";
            position: absolute;
            left: 5px;
            top: 1px;
            width: 6px;
            max-width: 6px;
            height: 12px;
            border-width: 0 3px 3px 0;
            transform: rotate(45deg);
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
                <a href="{{ route('dashboard') }}"><i style="font-size: 30px;"
                        class="fa-solid fa-arrow-left text-2xl ml-2"></i></a>
                <p style="font-size: 30px;" class="text-xl">Data SPK</p>
                <a href="{{ route('spk.create') }}"
                    class="inline-block px-4 py-2 mb-4 text-white bg-green-500 rounded hover:bg-green-600">
                    Tambah Data SPK
                </a>
            </div>

            <div class="relative flex justify-center items-center flex-col w-full mt-3">
                <div class="w-full overflow-x-auto scrollbar-thin scrollbar-track-transparent scrollbar-thumb-gray-400">
                    <table id="data-table" class="mt-4 min-w-max border-collapse">
                        <thead>
                            <tr style="background-color: #E4E0E1;" class="text-black">
                                <th class="border-2 border-black px-2 py-2 w-24">No</th>
                                <th class="border-2 border-black px-2 py-2 w-64">Nomor SPK</th>
                                <th class="border-2 border-black px-2 py-2 w-64">Customer Name 1</th>
                                <th class="border-2 border-black px-2 py-2 w-64">Customer Name 2</th>
                                <th class="border-2 border-black px-2 py-2 w-64">Payment Method</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Leasing</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Model</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Type</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Color</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Sales</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Branch</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Status</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Total Payment</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Customer Type</th>
                                <th class="border-2 border-black px-2 py-2 w-48">FLEET</th>
                                <th class="border-2 border-black px-2 py-2 w-48">COLOR CODE</th>
                                <th class="border-2 border-black px-2 py-2 w-48">BRANCH ID</th>
                                <th class="border-2 border-black px-2 py-2 w-64">TYPE ID</th>
                                <th class="border-2 border-black px-2 py-2 w-48">VALID</th>
                                <th class="border-2 border-black px-2 py-2 w-48">VALID DATE</th>
                                <th class="border-2 border-black px-2 py-2 w-48">CUSTOM TYPE</th>
                                <th class="border-2 border-black px-2 py-2 w-48">SPK STATUS</th>
                                <th class="border-2 border-black px-2 py-2 w-48">SUPERVISOR</th>
                                <th class="border-2 border-black px-2 py-2 w-64">Date If Credit Agreement</th>
                                <th class="border-2 border-black px-2 py-2 w-48">PO DATE</th>
                                <th class="border-2 border-black px-2 py-2 w-48">PO NUMBER</th>
                                <th class="border-2 border-black px-2 py-2 w-48">BUYER STATUS</th>
                                <th class="border-2 border-black px-2 py-2 w-48">RELIGION</th>
                                <th class="border-2 border-black px-2 py-2 w-48">PROVINCE</th>
                                <th class="border-2 border-black px-2 py-2 w-48">CITY</th>
                                <th class="border-2 border-black px-2 py-2 w-48">DISTRICT</th>
                                <th class="border-2 border-black px-2 py-2 w-48">SUB DISTRICT</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
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
                ajax: "{{ route('spk.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nomor_spk',
                        name: 'nomor_spk',
                        searchable: true
                    },
                    {
                        data: 'customer_name_1',
                        name: 'customer_name_1',
                        searchable: true
                    },
                    {
                        data: 'customer_name_2',
                        name: 'customer_name_2',
                        searchable: true
                    },
                    {
                        data: 'payment_method',
                        name: 'payment_method',
                        searchable: true
                    },
                    {
                        data: 'leasing',
                        name: 'leasing',
                        searchable: true
                    },
                    {
                        data: 'model',
                        name: 'model',
                        searchable: true
                    },
                    {
                        data: 'type',
                        name: 'type',
                        searchable: true
                    },
                    {
                        data: 'color',
                        name: 'color',
                        searchable: true
                    },
                    {
                        data: 'sales',
                        name: 'sales',
                        searchable: true
                    },
                    {
                        data: 'branch',
                        name: 'branch',
                        searchable: true
                    },
                    {
                        data: 'status',
                        name: 'status',
                        searchable: true
                    },
                    {
                        data: 'total_payment',
                        name: 'total_payment',
                        searchable: true
                    },
                    {
                        data: 'customer_type',
                        name: 'customer_type',
                        searchable: true
                    },
                    {
                        data: 'fleet',
                        name: 'fleet',
                        searchable: true
                    },
                    {
                        data: 'color_code',
                        name: 'color_code',
                        searchable: true
                    },
                    {
                        data: 'branch_id',
                        name: 'branch_id',
                        searchable: true
                    },
                    {
                        data: 'type_id',
                        name: 'type_id',
                        searchable: true
                    },
                    {
                        data: 'valid',
                        name: 'valid',
                        searchable: true
                    },
                    {
                        data: 'valid_date',
                        name: 'valid_date',
                        searchable: true
                    },
                    {
                        data: 'custom_type',
                        name: 'custom_type',
                        searchable: true
                    },
                    {
                        data: 'spk_status',
                        name: 'spk_status',
                        searchable: true
                    },
                    {
                        data: 'supervisor',
                        name: 'supervisor',
                        searchable: true
                    },
                    {
                        data: 'date_if_credit_agreement',
                        name: 'date_if_credit_agreement',
                        searchable: true
                    },
                    {
                        data: 'po_date',
                        name: 'po_date',
                        searchable: true
                    },
                    {
                        data: 'po_number',
                        name: 'po_number',
                        searchable: true
                    },
                    {
                        data: 'buyer_status',
                        name: 'buyer_status',
                        searchable: true
                    },
                    {
                        data: 'religion',
                        name: 'religion',
                        searchable: true
                    },
                    {
                        data: 'province',
                        name: 'province',
                        searchable: true
                    },
                    {
                        data: 'city',
                        name: 'city',
                        searchable: true
                    },
                    {
                        data: 'district',
                        name: 'district',
                        searchable: true
                    },
                    {
                        data: 'sub_district',
                        name: 'sub_district',
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
                ],
                drawCallback: function(settings) {
                    $('#data-table .edit').off('click').on('click', function() {
                        var id = $(this).data('id');
                        var row = $(this).closest('tr');

                        $('#data-table .cancel').click();

                        row.find('.editable').each(function() {
                            var value = $(this).text();
                            var name = $(this).attr('name');
                            var tdWidth = $(this).width();
                            if (name === 'valid') {
                                value = $(this).data('current-value');
                                tdWidth = $(this).find('input').width();
                                $(this).html('<input type="checkbox" name="' + name +
                                    '" ' + (value == '1' ? 'checked' : '') +
                                    ' class="border border-gray-300 form-control editable" style="width:' +
                                    tdWidth + 'px;" data-current-value="' + value +
                                    '">');
                            } else if (name === 'address') {
                                $(this).attr('data-current-value', value);
                                $(this).attr('readonly', false);
                            } else if (name === 'valid_date' || name ===
                                'date_if_credit_agreement' || name === 'po_date') {
                                $(this).html('<input type="date" name="' + name +
                                    '" value="' + value +
                                    '" class="border border-gray-300 form-control editable" style="width:' +
                                    tdWidth +
                                    'px; color: white;" data-current-value="' +
                                    value + '">');
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
                var id = $(this).data('id');
                var row = $(this).closest('tr');
                var data = {};
                row.find('input, textarea').each(function() {
                    var name = $(this).attr('name');
                    if (name === 'valid') {
                        data[name] = $(this).is(':checked') ? 1 : 0;
                    } else {
                        data[name] = $(this).val();
                    }
                });
                $.ajax({
                    url: '/spk/' + id,
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
                });
            });

            $('#data-table').on('click', '.cancel', function() {
                var row = $(this).closest('tr');
                row.find('.editable').each(function() {
                    var name = $(this).attr('name');
                    if (name == 'valid') {
                        const value = $(this).data('current-value');
                        $(this).html('<input type="checkbox" class="editable" name="' + name +
                            '" ' + (value == '1' ? 'checked' : '') + ' readonly disabled>');
                    } else if (name == 'address') {
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
                        $.ajax({
                            url: '/spk/' + id,
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
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>

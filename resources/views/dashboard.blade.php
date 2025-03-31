<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@1.39.1/iconfont/tabler-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite('resources/css/app.css')
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
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

        .btn-custom {
            /* Warna abu-abu */
            color: white;
            /* Teks putih */
            padding: 6px 12px;
            /* Padding tombol */
            border-radius: 5px;
            /* Membulatkan sudut */
            border: none;
            /* Hapus border default */
            cursor: pointer;
            /* Ubah kursor saat hover */
            transition: background-color 0.3s ease;
            /* Animasi hover */
        }

        #data-table {
            border-collapse: collapse;
            /* Menggabungkan border */
            width: 100%;
            /* Lebar penuh */
        }

        #data-table th,
        #data-table td {
            border: 1px solid black;
            /* Garis horizontal dan vertikal */
            padding: 8px;
            /* Jarak antar konten */
            text-align: center;
        }
    </style>
</head>

<body class="flex flex-col items-center min-h-screen bg-gray-100">
    <nav class="flex items-center justify-between w-full px-6 py-4 text-white bg-green-900 shadow-md">

        <img src="{{ asset('image/logooo 1.png') }}" alt="Logo">
        <h1 class="mx-auto text-xl font-bold" style="font-size: 36px;">Monitoring Data DO dan SPK</h1>
    </nav>

    <div class="flex flex-col w-full max-w-6xl mt-6 space-y-4">
        <!-- Form Input -->
        <form id="data-form" class="w-full">
            @csrf
            <div class="flex justify-between">
                <div>
                    <a href="{{ route('input.select') }}"
                        class="inline-block px-4 py-2 mb-4 text-white bg-green-500 rounded hover:bg-green-600">
                        Tambahkan Data
                    </a>
                    {{-- lastType --}}
                    @if ($lastType == 'DO')
                        <a href="{{ route('inputDO') }}">
                            <button type="button"
                                class="inline-block px-4 py-2 mb-4 text-white bg-green-500 rounded hover:bg-green-600">
                                Tambahkan Data DO
                            </button>
                        </a>
                    @elseif ($lastType == 'SPK')
                        <a href="{{ route('inputSPK') }}">
                            <button type="button"
                                class="inline-block px-4 py-2 mb-4 text-white bg-green-500 rounded hover:bg-green-600">
                                Tambahkan Data SPK
                            </button>
                        </a>
                    @endif
                </div>

                {{-- filter date start from and end from --}}
                <div>
                    <label for="date_start" class="text-black">Tanggal Awal:</label>
                    <input type="date" id="date_start" name="date_start" value="{{ date('Y-m-d') }}"
                        prev-date="{{ date('Y-m-d') }}" onchange="validDate($(this))"
                        class="px-2 py-1 text-black rounded">
                    <label for="date_end" class="text-black">Tanggal Akhir:</label>
                    <input type="date" id="date_end" name="date_end" value="{{ date('Y-m-d') }}"
                        prev-date="{{ date('Y-m-d') }}" onchange="validDate($(this))"
                        class="px-2 py-1 text-black rounded">
                    <button type="button" id="filter-button" onclick="filterByDate()"
                        class="inline-block px-4 py-2 mb-4 text-white bg-green-500 rounded hover:bg-green-600">
                        Filter
                    </button>
                    <button type="button" id="reset-button" onclick="resetFilter()"
                        class="inline-block px-4 py-2 mb-4 text-white bg-red-500 rounded hover:bg-red-600">
                        Reset
                    </button>
                    {{-- export button --}}
                    {{-- <button type="button"
                        class="inline-block px-4 py-2 mb-4 text-white bg-blue-500 rounded hover:bg-blue-600">
                        Export
                    </button> --}}
                </div>
            </div>

            {{-- <div class="p-6 overflow-x-auto bg-green-800 rounded-lg shadow-md">
                <table class="w-full text-center text-black border border-collapse border-gray-300">
                    <thead>
                        <tr style="background-color: #E4E0E1;">
                            <th class="px-2 py-2 border border-gray-300">Nama Supervisor</th>
                            <th class="px-2 py-2 border border-gray-300">Target DO</th>
                            <th class="px-2 py-2 border border-gray-300">Act DO</th>
                            <th class="px-2 py-2 border border-gray-300">GAP</th>
                            <th class="px-2 py-2 border border-gray-300">Ach (%)</th>
                            <th class="px-2 py-2 border border-gray-300">Target SPK</th>
                            <th class="px-2 py-2 border border-gray-300">ACT SPK</th>
                            <th class="px-2 py-2 border border-gray-300">GAP</th>
                            <th class="px-2 py-2 border border-gray-300">Ach (%)</th>
                            <th class="px-2 py-2 border border-gray-300">Status</th>
                            <th class="px-2 py-2 border border-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-black bg-white">
                            <td class="px-2 py-1 border border-gray-300">
                                <input type="text" name="nama_supervisor" class="w-full p-1 border border-gray-300">
                            </td>
                            <td class="px-2 py-1 border border-gray-300">
                                <input type="number" name="target_do" class="w-full p-1 border border-gray-300"
                                    oninput="calculateGapAndAch($(this))">
                            </td>
                            <td class="px-2 py-1 border border-gray-300">
                                <input type="number" name="act_do" class="w-full p-1 border border-gray-300"
                                    oninput="calculateGapAndAch($(this))">
                            </td>
                            <td class="px-2 py-1 border border-gray-300">
                                <input type="text" name="gap_do" class="w-full p-1 border border-gray-300" readonly>
                            </td>
                            <td class="px-2 py-1 border border-gray-300">
                                <input type="text" name="ach_do" class="w-full p-1 border border-gray-300" readonly>
                            </td>
                            <td class="px-2 py-1 border border-gray-300">
                                <input type="number" name="target_spk" class="w-full p-1 border border-gray-300"
                                    oninput="calculateGapAndAch($(this))">
                            </td>
                            <td class="px-2 py-1 border border-gray-300">
                                <input type="number" name="act_spk" class="w-full p-1 border border-gray-300"
                                    oninput="calculateGapAndAch($(this))">
                            </td>
                            <td class="px-2 py-1 border border-gray-300">
                                <input type="text" name="gap_spk" class="w-full p-1 border border-gray-300" readonly>
                            </td>
                            <td class="px-2 py-1 border border-gray-300">
                                <input type="text" name="ach_spk" class="w-full p-1 border border-gray-300" readonly>
                            </td>
                            <td class="px-2 py-1 border border-gray-300">
                                <input type="text" name="status" class="w-full p-1 border border-gray-300" readonly>
                            </td>
                            <td class="flex justify-center px-2 py-1 space-x-1 border border-gray-300">
                                <button type="button" id="submit-button"
                                    class="px-3 py-1 text-white bg-green-500 rounded hover:bg-green-600">Tambah</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div> --}}
        </form>

        <!-- Data yang sudah tersimpan -->
        <div class="p-6 overflow-x-auto bg-green-800 rounded-lg shadow-md">
            <table id="data-table" class="w-full text-center text-black border border-collapse border-gray-300">
                <thead>
                    <tr style="background-color: #E4E0E1;">
                        <th class="px-2 py-2 border border-2 border-black">Nama Supervisor</th>
                        <th class="px-2 py-2 border border-2 border-black">Target DO</th>
                        <th class="px-2 py-2 border border-2 border-black">Act DO</th>
                        <th class="px-2 py-2 border border-2 border-black">GAP</th>
                        <th class="px-2 py-2 border border-2 border-black">Ach (%)</th>
                        <th class="px-2 py-2 border border-2 border-black">Target SPK</th>
                        <th class="px-2 py-2 border border-2 border-black">ACT SPK</th>
                        <th class="px-2 py-2 border border-2 border-black">GAP</th>
                        <th class="px-2 py-2 border border-2 border-black">Ach (%)</th>
                        <th class="px-2 py-2 text-center border border-2 border-black" style="width: 140px">Status</th>
                        <th class="px-2 py-2 text-center border border-2 border-black">Aksi</th>
                        <th class="px-2 py-2 text-center border border-2 border-black">Update At</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
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

        function calculateGapAndAch(input) {
            var row = input.closest('tr');

            // Ambil nilai yang relevan
            var target_do = parseFloat(row.find('[name="target_do"]').val() || row.find('[data-name="target_do"]')
                .text()) || null;
            var act_do = parseFloat(row.find('[name="act_do"]').val()) || null;
            var target_spk = parseFloat(row.find('[name="target_spk"]').val() || row.find('[data-name="target_spk"]')
                .text()) || null;
            var act_spk = parseFloat(row.find('[name="act_spk"]').val()) || null;

            // Hitung Gap & Achievement DO jika input yang diubah adalah act_do
            var gap_do = act_do - target_do;
            var ach_do = target_do > 0 ? (act_do / target_do) * 100 : 0;
            row.find('[name="gap_do"]').val(Math.round(gap_do));
            row.find('[name="ach_do"]').val(Math.round(ach_do) + '%');

            // Hitung Gap & Achievement SPK jika input yang diubah adalah act_spk
            var gap_spk = act_spk - target_spk;
            var ach_spk = target_spk > 0 ? (act_spk / target_spk) * 100 : 0;
            row.find('[name="gap_spk"]').val(Math.round(gap_spk));
            row.find('[name="ach_spk"]').val(Math.round(ach_spk) + '%');

            var status = ach_do >= 100 ? 'ON THE TRACK' : 'PUSH SPK';
            var colorClass = ach_do >= 100 ? 'bg-green-500' : 'bg-red-500';

            const statusElement = row.find('.status_text');
            statusElement.text(status);
            statusElement.removeClass('bg-green-500 bg-red-500 bg-gray-500').addClass(colorClass);
        }

        let table;

        function validDate(e) {
            const dateStart = document.getElementById("date_start").value;
            const dateEnd = document.getElementById("date_end").value;

            console.log(new Date(dateStart) < new Date(dateEnd))
            if (new Date(dateStart) > new Date(dateEnd)) {                
                Toast.fire({
                    icon: "error",                    
                    title: 'Tanggal awal tidak boleh lebih besar dari tanggal akhir!',
                    timer: 3000,
                });

                document.getElementById("date_start").value = document.getElementById("date_start").getAttribute(
                    'prev-date');
                document.getElementById("date_end").value = document.getElementById("date_end").getAttribute('prev-date');
            } else if (new Date(dateEnd) < new Date(dateStart)) {                
                Toast.fire({
                    icon: "error",
                    title: 'Tanggal akhir tidak boleh lebih kecil dari tanggal awal!',                    
                    timer: 3000,
                });

                document.getElementById("date_start").value = document.getElementById("date_start").getAttribute(
                    'prev-date');
                document.getElementById("date_end").value = document.getElementById("date_end").getAttribute('prev-date');
            } else {
                document.getElementById("date_start").setAttribute('prev-date', dateStart);
                document.getElementById("date_end").setAttribute('prev-date', dateEnd);
            }
        }

        function filterByDate() {
            table.ajax.reload();
        }

        function resetFilter() {
            document.getElementById("date_start").value = "{{ date('Y-m-d') }}";
            document.getElementById("date_end").value = "{{ date('Y-m-d') }}";
            table.ajax.reload();
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('monitoring_do_spk.index') }}",
                    data: function(d) {
                        d.start_date = $('#date_start').val();
                        d.end_date = $('#date_end').val();
                    }
                },
                columns: [{
                        data: 'nama_supervisor',
                        name: 'nama_supervisor',
                        searchable: true
                    },
                    {
                        data: 'target_do',
                        name: 'target_do',
                        searchable: true
                    },
                    {
                        data: 'act_do',
                        name: 'act_do',
                        searchable: true
                    },
                    {
                        data: 'gap_do',
                        name: 'gap_do',
                        searchable: true
                    },
                    {
                        data: 'ach_do',
                        name: 'ach_do',
                        searchable: true
                    },
                    {
                        data: 'target_spk',
                        name: 'target_spk',
                        searchable: true
                    },
                    {
                        data: 'act_spk',
                        name: 'act_spk',
                        searchable: true
                    },
                    {
                        data: 'gap_spk',
                        name: 'gap_spk',
                        searchable: true
                    },
                    {
                        data: 'ach_spk',
                        name: 'ach_spk',
                        searchable: true
                    },
                    {
                        data: 'status',
                        name: 'status',
                        searchable: true
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'updated_at',
                        visible: false
                    },
                ],
                order: [
                    [11, 'desc']
                ],
                drawCallback: function(settings) {
                    // Pastikan semua tombol "edit" memiliki event handler yang benar setelah render ulang
                    $('#data-table .edit').off('click').on('click', function() {
                        var id = $(this).data('id');
                        var row = $(this).closest('tr');

                        // Close other edit modes
                        $('#data-table .cancel').click();

                        row.find('.editable').each(function() {
                            var value = $(this).text();
                            var name = $(this).data('name');
                            var tdWidth = $(this)
                                .width(); // Ambil width td sebelum diubah menjadi input

                            if (name === 'gap_do' || name === 'ach_do' || name ===
                                'gap_spk' || name === 'ach_spk' || name === 'status') {
                                if (name == 'ach_do' || name == 'ach_spk' || name ==
                                    'status' || name == 'gap_do' || name == 'gap_spk') {
                                    // value = value.replace('%', '');
                                    tdWidth = tdWidth + 40;
                                }
                                $(this).html('<input type="text" name="' + name +
                                    '" value="' + value +
                                    '" class="border border-gray-300 form-control editable" style="width:' +
                                    tdWidth + 'px;" readonly data-current-value="' +
                                    value + '">');
                            } else if (name == undefined) {

                            } else {
                                $(this).html('<input type="text" name="' + name +
                                    '" value="' + value +
                                    '" class="border border-gray-300 form-control editable" style="width:' +
                                    tdWidth +
                                    'px;" oninput="calculateGapAndAch($(this))" data-current-value="' +
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
                // columnDefs: [{
                //         width: '150px',
                //         targets: [0]
                //     },
                //     {
                //         width: '60px',
                //         targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                //     }
                // ]
            });

            $('#data-table').on('click', '.save', function() {
                $(this).prop('disabled', true);
                $(this).html('<i class="fa fa-spinner fa-spin"></i> Updating...');
                var id = $(this).data('id');
                var row = $(this).closest('tr');
                var data = {};
                row.find('input').each(function() {
                    var name = $(this).attr('name');
                    data[name] = $(this).val();
                });
                $.ajax({
                    url: '/monitoring_do_spk/' + id,
                    method: 'PUT',
                    data: data,
                    success: function(response) {
                        if (!response?.errors) {
                            Toast.fire({
                                icon: "success",
                                title: response.message,
                                timer: 1500,
                            });
                            table.ajax.reload(null, false);
                        } else {
                            let errorMessage = '';
                            for (const [key, value] of Object.entries(response
                                    .errors)) {
                                errorMessage += `${value}\n`;
                            }
                            Toast.fire({
                                icon: "error",
                                title: errorMessage,
                                timer: 1500,
                            });
                            $(this).prop('disabled', false);
                        }
                    },
                    error: function(response) {
                        response = response.responseJSON;
                        if (response?.message === "CSRF token mismatch.") {
                            Toast.fire({
                                icon: "error",
                                title: "Token tidak valid, mohon refresh page",
                                timer: 3000,
                            });
                        } else if (!response?.errors) {
                            Toast.fire({
                                icon: "error",
                                title: "An error occurred",
                                timer: 1500,
                            });
                        } else {
                            let errorMessage = '';
                            for (const [key, value] of Object.entries(response
                                    .errors)) {
                                errorMessage += `${value}\n`;
                            }
                            Toast.fire({
                                icon: "error",
                                title: errorMessage,
                                timer: 1500,
                            });
                        }
                        $(this).prop('disabled', false);
                    }
                });
            });

            $('#data-table').on('click', '.cancel', function() {
                var row = $(this).closest('tr');
                // attach data-current-value attribute to input
                row.find('.editable').each(function() {
                    var value = $(this).find('input').data('current-value');
                    $(this).html(value);
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
                            url: '/monitoring_do_spk/' + id,
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
                                $(this).prop('disabled', false);
                                $(this).html('Delete <i class="ti ti-trash"></i>');
                            }
                        });
                    }
                });
            });

            document.getElementById("submit-button").addEventListener("click", function() {
                const data = {
                    nama_supervisor: document.querySelector('input[name="nama_supervisor"]').value,
                    target_do: document.querySelector('input[name="target_do"]').value,
                    act_do: document.querySelector('input[name="act_do"]').value,
                    target_spk: document.querySelector('input[name="target_spk"]').value,
                    act_spk: document.querySelector('input[name="act_spk"]').value,
                    type: 'all'
                };

                fetch("{{ route('monitoring_do_spk.store') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.errors) {
                            Toast.fire({
                                icon: "success",
                                title: data.message,
                                timer: 1500,
                            });
                            document.getElementById("data-form").reset();
                            table.ajax.reload(null, false);
                        } else {
                            let errorMessage = '';
                            for (const [key, value] of Object.entries(data.errors)) {
                                errorMessage += `${value}\n`;
                            }
                            Toast.fire({
                                icon: "error",
                                title: errorMessage,
                                timer: 1500,
                            });
                        }
                    })
                    .catch(error => {
                        Toast.fire({
                            icon: "error",
                            title: "An error occurred",
                            timer: 1500,
                        });
                    });
            });
        });
    </script>
</body>

</html>

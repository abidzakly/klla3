<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@1.39.1/iconfont/tabler-icons.min.css">

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

    .paginate_button previous:not(.disabled):hover, .paginate_button next:not(.disabled):hover {
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
    </style>
</head>

<body class="flex flex-col items-center min-h-screen bg-gray-100">
    <nav class="flex items-center justify-between w-full px-6 py-4 text-white bg-green-900 shadow-md">

        <img src="{{ asset('image/logooo 1.png') }}" alt="Logo">
        <h1 class="mx-auto text-xl font-bold" style="font-size: 36px;">Monitoring Data DO dan SPK</h1>
    </nav>

    <div class="flex flex-col w-full max-w-6xl mt-6 space-y-4">
        <!-- Form Input -->
        <form action="{{ route('monitoring_do_spk.store') }}" method="POST" class="w-full">
            @csrf
            <a href="{{ route('input.select') }}"
                class="inline-block px-4 py-2 mb-4 text-white bg-green-500 rounded hover:bg-green-600">
                Tambahkan Data
            </a>

            <div class="p-6 overflow-x-auto bg-green-800 rounded-lg shadow-md">
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
                                <input type="number" name="target_do" class="w-full p-1 border border-gray-300">
                            </td>
                            <td class="px-2 py-1 border border-gray-300">
                                <input type="number" name="act_do" class="w-full p-1 border border-gray-300">
                            </td>
                            <td class="px-2 py-1 border border-gray-300">
                                <input type="number" name="gap" class="w-full p-1 border border-gray-300">
                            </td>
                            <td class="px-2 py-1 border border-gray-300">
                                <input type="number" name="ach" class="w-full p-1 border border-gray-300">
                            </td>
                            <td class="px-2 py-1 border border-gray-300">
                                <input type="number" name="target_spk" class="w-full p-1 border border-gray-300">
                            </td>
                            <td class="px-2 py-1 border border-gray-300">
                                <input type="number" name="act_spk" class="w-full p-1 border border-gray-300">
                            </td>
                            <td class="px-2 py-1 border border-gray-300">
                                <input type="number" name="gap_spk" class="w-full p-1 border border-gray-300">
                            </td>
                            <td class="px-2 py-1 border border-gray-300">
                                <input type="number" name="ach_spk" class="w-full p-1 border border-gray-300">
                            </td>
                            <td class="px-2 py-1 border border-gray-300">
                                <input type="text" name="status" class="w-full p-1 border border-gray-300">
                            </td>
                            <td class="flex justify-center px-2 py-1 space-x-1 border border-gray-300">
                                <button type="submit"
                                    class="px-3 py-1 text-white bg-green-500 rounded hover:bg-green-600"></thead>
                                    Tambah
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
                        <th class="px-2 py-2 border border-2 border-black">Status</th>
                        <th class="px-2 py-2 border border-2 border-black">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('monitoring_do_spk.index') }}",
                columns: [
                    { data: 'nama_supervisor', name: 'nama_supervisor', searchable: true },
                    { data: 'target_do', name: 'target_do', searchable: true },
                    { data: 'act_do', name: 'act_do', searchable: true },
                    { data: 'gap_do', name: 'gap_do', searchable: true },
                    { data: 'ach_do', name: 'ach_do', searchable: true },
                    { data: 'target_spk', name: 'target_spk', searchable: true },
                    { data: 'act_spk', name: 'act_spk', searchable: true },
                    { data: 'gap_spk', name: 'gap_spk', searchable: true },
                    { data: 'ach_spk', name: 'ach_spk', searchable: true },
                    { data: 'status', name: 'status', searchable: true },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                drawCallback: function(settings) {
                    // Pastikan semua tombol "edit" memiliki event handler yang benar setelah render ulang
                    $('#data-table .edit').off('click').on('click', function() {
                        var id = $(this).data('id');
                        var row = $(this).closest('tr');

                        row.find('.editable').each(function() {
                            var value = $(this).text();
                            var name = $(this).data('name');
                            var tdWidth = $(this)
                        .width(); // Ambil width td sebelum diubah menjadi input

                            $(this).html('<input type="text" name="' + name +
                                '" value="' + value +
                                '" class="border border-gray-300 form-control editable" style="width:' +
                                tdWidth + 'px;">');
                        });

                        row.find('.edit').hide();
                        row.find('.delete').hide();
                        row.find('.action-buttons').append(
                            '<button class="save btn btn-primary btn-sm" data-id="' + id +
                            '">Save</button>');
                        row.find('.action-buttons').append(
                            '<button class="cancel btn btn-secondary btn-sm" data-id="' +
                            id + '">Cancel</button>');
                    });
                },
                columnDefs: [{
                        width: '150px',
                        targets: [0]
                    },
                    {
                        width: '60px',
                        targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    }
                ]
            });

            $('#data-table').on('click', '.save', function() {
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
                        table.ajax.reload();
                        alert(response.message);
                    },
                    error: function(response) {
                        alert('An error occurred');
                    }
                });
            });

            $('#data-table').on('click', '.cancel', function() {
                table.ajax.reload();
            });

            $('#data-table').on('click', '.delete', function() {
                var id = $(this).data('id');
                if (confirm('Are you sure you want to delete this record?')) {
                    $.ajax({
                        url: '/monitoring_do_spk/' + id,
                        method: 'DELETE',
                        success: function(response) {
                            table.ajax.reload();
                            alert(response.message);
                        },
                        error: function(response) {
                            alert('An error occurred');
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>

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
    </style>
</head>

<body style="background-image: url('{{ asset('image/background.png') }}');"
    class="bg-cover bg-center flex flex-col items-center min-h-screen">
    <nav class="bg-green-900 text-white w-full px-6 py-4 flex items-center shadow-md relative">
        <img src="{{ asset('image/logooo 1.png') }}" alt="Logo" class="absolute left-6">
        <h1 class="text-xl font-bold mx-auto text-center" style="font-size: 36px;">Report Big Event</h1>
    </nav>

    <div class="w-[80%] justify-center mt-6">
        <div class="relative w-full flex items-center justify-start px-6 font-bold text-white mt-4 mb-3 z-50">
            <div class="relative">
                <button id="branchDropdownButton"
                    class="text-xl font-bold text-white bg-green-600 px-6 py-2 rounded-lg">
                    {{ $branch->branch_name }} ▼
                </button>

                <div id="branchDropdownMenu"
                    class="hidden absolute left-0 top-full mt-2 bg-white shadow-lg rounded-lg w-52 max-h-60 overflow-y-auto transition-all duration-300 opacity-0 transform scale-95 z-50">
                    <input type="hidden" id="branchId" value="{{ $branch->id_branch }}">
                    @foreach (App\Models\Branch::all() as $branchItem)
                        <button onclick="changeBranch('{{ $branchItem->id_branch }}', '{{ $branchItem->branch_name }}')"
                            class="block px-5 py-3 text-black hover:bg-gray-100 transition-all duration-300 w-full text-left">
                            {{ $branchItem->branch_name }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-4 ml-auto px-4 py-3 rounded bg-green-600">
                <label for="date_start" class="">Tanggal Awal:</label>
                <input type="date" id="date_start" name="date_start" value="{{ date('Y-m-d') }}"
                    prev-date="{{ date('Y-m-d') }}" onchange="validDate($(this))" class="px-2 py-1 text-black rounded">
                <label for="date_end" class="">Tanggal Akhir:</label>
                <input type="date" id="date_end" name="date_end" value="{{ date('Y-m-d') }}"
                    prev-date="{{ date('Y-m-d') }}" onchange="validDate($(this))" class="px-2 py-1 text-black rounded">
                <div class="flex items-center gap-2">
                    <button type="button" id="filter-button" onclick="filterByDate($(this))"
                        class="px-4 py-2 text-white bg-green-500 rounded hover:bg-green-800">
                        Filter
                    </button>
                    <button type="button" id="reset-button" onclick="resetFilter()"
                        class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600">
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <div class="relative w-full flex flex-col rounded-lg shadow-md items-center justify-center group p-6 mb-4">
            <div class="w-full min-h-[80vh] h-full absolute inset-0 bg-green-800 rounded-lg"></div>

            <div class="relative w-full flex items-center justify-between px-6 font-bold text-white">
                <a href="{{ route('dashboard') }}"><i style="font-size: 30px;"
                        class="fa-solid fa-arrow-left text-2xl ml-2"></i></a>
                <p style="font-size: 30px;" class="text-xl">Data SPK</p>
                <a href="{{ route('spk.create', ['branch' => $branch->branch_name]) }}" id="createButton"
                    class="inline-block px-4 py-2 mb-4 text-white bg-green-500 rounded hover:bg-green-600">
                    Tambah Data SPK
                </a>
            </div>

            <div class="relative flex justify-center items-center flex-col w-full mt-3">
                <div class="w-full overflow-x-auto scrollbar-thin scrollbar-track-transparent scrollbar-thumb-gray-400">
                    <table id="data-table" class="mt-4 min-w-max border-collapse display" style="width:100%">
                        <thead>
                            <tr style="background-color: #E4E0E1;" class="text-black">
                                <th class="border-2 border-black px-2 py-2 w-24">No</th>
                                <th class="border-2 border-black px-2 py-2 w-64">Nomor SPK</th>
                                <th class="border-2 border-black px-2 py-2 w-64">Customer Name 1</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Model</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Payment Method</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Total Payment</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Status</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Date SPK</th>
                                <th class="border-2 border-black px-2 py-2 w-64">Aksi</th>
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
        let dataTable;

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

            // Initialize DataTable
            dataTable = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('spk.index') }}",
                    data: function(d) {
                        d.branch_id = document.getElementById('branchId').value;
                        d.start_date = $('#date_start').val();
                        d.end_date = $('#date_end').val();
                    },
                    error: function(xhr, error, code) {
                        console.log('DataTables Error:', xhr.responseText);
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'nomor_spk', name: 'nomor_spk', searchable: true},
                    {data: 'customer_name_1', name: 'customer_name_1', searchable: true},
                    {data: 'model', name: 'model', searchable: true},
                    {data: 'payment_method', name: 'payment_method', searchable: true},
                    {data: 'total_payment', name: 'total_payment', searchable: true},
                    {data: 'status', name: 'status', searchable: true},
                    {data: 'date_spk', name: 'date_spk', searchable: true},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                order: [[1, 'desc']],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            });

            // Delete handler
            $('#data-table').on('click', '.delete', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/spk/' + id,
                            method: 'DELETE',
                            success: function(response) {
                                dataTable.ajax.reload(null, false);
                                Toast.fire({
                                    icon: "success",
                                    title: response.message,
                                    timer: 1500,
                                });
                            },
                            error: function(response) {
                                Toast.fire({
                                    icon: "error",
                                    title: "Terjadi kesalahan saat menghapus data",
                                    timer: 1500,
                                });
                            }
                        });
                    }
                });
            });
        });

        function validDate(e) {
            const dateStart = document.getElementById("date_start").value;
            const dateEnd = document.getElementById("date_end").value;

            if (new Date(dateStart) > new Date(dateEnd)) {
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
                Toast.fire({
                    icon: "error",
                    title: 'Tanggal awal tidak boleh lebih besar dari tanggal akhir!',
                    timer: 3000,
                });

                document.getElementById("date_start").value = document.getElementById("date_start").getAttribute('prev-date');
                document.getElementById("date_end").value = document.getElementById("date_end").getAttribute('prev-date');
            } else {
                document.getElementById("date_start").setAttribute('prev-date', dateStart);
                document.getElementById("date_end").setAttribute('prev-date', dateEnd);
            }
        }

        function filterByDate(e) {
            $(e).prop('disabled', true);
            $(e).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
            
            dataTable.ajax.reload();
            
            $('#filter-button').prop('disabled', false);
            $('#filter-button').html('Filter');
        }

        function resetFilter() {
            document.getElementById("date_start").value = "{{ date('Y-m-d') }}";
            document.getElementById("date_end").value = "{{ date('Y-m-d') }}";
            
            dataTable.ajax.reload();
        }

        function changeBranch(branchId, branchName) {
            document.getElementById('branchId').value = branchId;
            document.getElementById('branchDropdownButton').innerHTML = branchName + ' ▼';
            document.getElementById('branchDropdownMenu').classList.add('hidden', 'opacity-0', 'scale-95');

            const createButton = document.getElementById('createButton');
            if (createButton) {
                createButton.href = "{{ route('spk.create') }}" + '?branch=' + encodeURIComponent(branchName);
            }

            dataTable.ajax.reload(null, false);
        }

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
    </script>
</body>

</html>
                                    <th class="border-2 border-black px-2 py-2 w-48">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
        let tables = {};
        let currentSection = 'customer';

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

            // Initialize all tables
            initializeTables();
        });

        function initializeTables() {
            // Customer Table
            tables.customer = $('#customer-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('spk.index') }}",
                    data: function(d) {
                        d.branch_id = document.getElementById('branchId').value;
                        d.start_date = $('#date_start').val();
                        d.end_date = $('#date_end').val();
                        d.section = 'customer';
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'customer_name_1', name: 'customer_name_1', searchable: true},
                    {data: 'customer_name_2', name: 'customer_name_2', searchable: true},
                    {data: 'buyer_status', name: 'buyer_status', searchable: true},
                    {data: 'religion', name: 'religion', searchable: true},
                    {data: 'province', name: 'province', searchable: true},
                    {data: 'city', name: 'city', searchable: true},
                    {data: 'district', name: 'district', searchable: true},
                    {data: 'sub_district', name: 'sub_district', searchable: true},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                order: [[1, 'desc']],
                drawCallback: function(settings) {
                    bindEditActions();
                },
            });

            // Vehicle Table
            tables.vehicle = $('#vehicle-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('spk.index') }}",
                    data: function(d) {
                        d.branch_id = document.getElementById('branchId').value;
                        d.start_date = $('#date_start').val();
                        d.end_date = $('#date_end').val();
                        d.section = 'vehicle';
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'model', name: 'model', searchable: true},
                    {data: 'type', name: 'type', searchable: true},
                    {data: 'color', name: 'color', searchable: true},
                    {data: 'color_code', name: 'color_code', searchable: true},
                    {data: 'fleet', name: 'fleet', searchable: true},
                    {data: 'customer_type', name: 'customer_type', searchable: true},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                order: [[1, 'desc']],
                drawCallback: function(settings) {
                    bindEditActions();
                },
            });

            // Transaction Table
            tables.transaction = $('#transaction-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('spk.index') }}",
                    data: function(d) {
                        d.branch_id = document.getElementById('branchId').value;
                        d.start_date = $('#date_start').val();
                        d.end_date = $('#date_end').val();
                        d.section = 'transaction';
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'nomor_spk', name: 'nomor_spk', searchable: true},
                    {data: 'spk_status', name: 'spk_status', searchable: true},
                    {data: 'leasing', name: 'leasing', searchable: true},
                    {data: 'status', name: 'status', searchable: true},
                    {data: 'payment_method', name: 'payment_method', searchable: true},
                    {data: 'total_payment', name: 'total_payment', searchable: true},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                order: [[1, 'desc']],
                drawCallback: function(settings) {
                    bindEditActions();
                },
            });

            // Internal Table
            tables.internal = $('#internal-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('spk.index') }}",
                    data: function(d) {
                        d.branch_id = document.getElementById('branchId').value;
                        d.start_date = $('#date_start').val();
                        d.end_date = $('#date_end').val();
                        d.section = 'internal';
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'branch_id_text', name: 'branch_id_text', searchable: true},
                    {data: 'branch', name: 'branch', searchable: true},
                    {data: 'sales', name: 'sales', searchable: true},
                    {data: 'supervisor', name: 'supervisor', searchable: true},
                    {data: 'type_id', name: 'type_id', searchable: true},
                    {data: 'custom_type', name: 'custom_type', searchable: true},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                order: [[1, 'desc']],
                drawCallback: function(settings) {
                    bindEditActions();
                },
            });

            // Process Table
            tables.process = $('#process-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('spk.index') }}",
                    data: function(d) {
                        d.branch_id = document.getElementById('branchId').value;
                        d.start_date = $('#date_start').val();
                        d.end_date = $('#date_end').val();
                        d.section = 'process';
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'valid_date', name: 'valid_date', searchable: true},
                    {data: 'valid', name: 'valid', searchable: true},
                    {data: 'po_number', name: 'po_number', searchable: true},
                    {data: 'po_date', name: 'po_date', searchable: true},
                    {data: 'date_if_credit_agreement', name: 'date_if_credit_agreement', searchable: true},
                    {data: 'date_spk', name: 'date_spk', searchable: true},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                order: [[1, 'desc']],
                drawCallback: function(settings) {
                    bindEditActions();
                },
            });
        }

        function showSection(section) {
            // Hide all sections
            document.querySelectorAll('.section-content').forEach(el => {
                el.style.display = 'none';
            });

            // Show selected section
            document.getElementById(`section-${section}`).style.display = 'block';

            // Update tab styles
            document.querySelectorAll('[id^="tab-"]').forEach(tab => {
                tab.classList.remove('bg-blue-600');
                tab.classList.add('bg-blue-400');
            });
            document.getElementById(`tab-${section}`).classList.remove('bg-blue-400');
            document.getElementById(`tab-${section}`).classList.add('bg-blue-600');

            currentSection = section;

            // Trigger table resize
            if (tables[section]) {
                tables[section].columns.adjust().draw();
            }
        }

        function bindEditActions() {
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
                        'date_if_credit_agreement' || name === 'po_date' ||
                        name === 'date_spk') {
                        // Format date properly for input
                        let dateValue = value;
                        if (value && value !== '') {
                            // Convert to YYYY-MM-DD format if needed
                            const date = new Date(value);
                            if (!isNaN(date.getTime())) {
                                dateValue = date.toISOString().split('T')[0];
                            }
                        }
                        $(this).html('<input type="date" name="' + name +
                            '" value="' + dateValue +
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
        }

        $('#data-table').on('click', '.save', function() {
            $(this).prop('disabled', true);
            $(this).html('<i class="fa fa-spinner fa-spin"></i> Updating...');
            var id = $(this).data('id');
            var row = $(this).closest('tr');
            var data = {};
            row.find('input, textarea').each(function() {
                var name = $(this).attr('name');
                if (name === 'valid') {
                    data[name] = $(this).is(':checked') ? 1 : 0;
                } else {
                    var value = $(this).val();
                    // Handle empty values for required fields
                    if (value === '' || value === null) {
                        if (name === 'leasing' || name === 'custom_type' || name ===
                            'supervisor' ||
                            name === 'date_if_credit_agreement' || name === 'po_date' ||
                            name === 'po_number' || name === 'buyer_status' || name ===
                            'religion' ||
                            name === 'province' || name === 'city' || name === 'district' ||
                            name === 'sub_district') {
                            data[name] = null;
                        } else {
                            data[name] = '';
                        }
                    } else {
                        data[name] = value;
                    }
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
                    tables[currentSection].ajax.reload(null, false);
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
                $(this).prop('disabled', false);
                $(this).html('<i class="ti ti-check"></i> Save');
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
                    $(this).prop('disabled', true);
                    $(this).html('<i class="fa fa-spinner fa-spin"></i> Deleting...');
                    $.ajax({
                        url: '/spk/' + id,
                        method: 'DELETE',
                        success: function(response) {
                            tables[currentSection].ajax.reload(null, false);
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

        function validDate(e) {
            const dateStart = document.getElementById("date_start").value;
            const dateEnd = document.getElementById("date_end").value;

            if (new Date(dateStart) > new Date(dateEnd)) {
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
                Toast.fire({
                    icon: "error",
                    title: 'Tanggal awal tidak boleh lebih besar dari tanggal akhir!',
                    timer: 3000,
                });

                document.getElementById("date_start").value = document.getElementById("date_start").getAttribute(
                    'prev-date');
                document.getElementById("date_end").value = document.getElementById("date_end").getAttribute('prev-date');
            } else if (new Date(dateEnd) < new Date(dateStart)) {
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

        function filterByDate(e) {
            $(e).prop('disabled', true);
            $(e).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
            
            // Reload all tables
            Object.values(tables).forEach(table => {
                table.ajax.reload();
            });
            
            $('#filter-button').prop('disabled', false);
            $('#filter-button').html('Filter');
        }

        function resetFilter() {
            document.getElementById("date_start").value = "{{ date('Y-m-d') }}";
            document.getElementById("date_end").value = "{{ date('Y-m-d') }}";
            
            // Reload all tables
            Object.values(tables).forEach(table => {
                table.ajax.reload();
            });
        }

        function changeBranch(branchId, branchName) {
            document.getElementById('branchId').value = branchId;
            document.getElementById('branchDropdownButton').innerHTML = branchName + ' ▼';
            document.getElementById('branchDropdownMenu').classList.add('hidden', 'opacity-0', 'scale-95');

            const createButton = document.getElementById('createButton');
            if (createButton) {
                createButton.href = "{{ route('spk.create') }}" + '?branch=' + encodeURIComponent(branchName);
            }

            // Reload all tables
            Object.values(tables).forEach(table => {
                table.ajax.reload(null, false);
            });
        }

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
    </script>
</body>

</html>

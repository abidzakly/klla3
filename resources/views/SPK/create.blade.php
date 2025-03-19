<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/css/app.css')
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .dataTables_wrapper input[type="number"]::-webkit-outer-spin-button,
        .dataTables_wrapper input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .dataTables_wrapper input[type="number"] {
            -moz-appearance: textfield;
        }

        .dataTables_wrapper table.dataTable tbody tr,
        .dataTables_wrapper table.dataTable tbody td {
            background-color: transparent !important;
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

            <div class="relative mt-3 w-full flex items-center px-6 font-bold text-white">
                <a href="{{ route('spk.index') }}"><i style="font-size: 30px;"
                        class="fa-solid fa-arrow-left text-2xl ml-2"></i></a>
                <p style="font-size: 30px;" class="absolute left-1/2 -translate-x-1/2 text-xl">Data SPK</p>
            </div>

            <div class="relative flex justify-center items-center flex-col w-full">
                <!-- Scrollable Wrapper -->
                <div class="w-full overflow-x-auto scrollbar-thin scrollbar-track-transparent scrollbar-thumb-gray-400">
                    <table class="mt-4 min-w-max border-collapse">
                        <thead>
                            <tr style="background-color: #E4E0E1;">
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
                                <th class="border-2 border-black px-2 py-2 w-48">Fleet</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Color Code</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Branch ID</th>
                                <th class="border-2 border-black px-2 py-2 w-64">Type ID</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Valid</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Valid Date</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Custom Type</th>
                                <th class="border-2 border-black px-2 py-2 w-48">SPK Status</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Supervisor</th>
                                <th class="border-2 border-black px-2 py-2 w-64">Date If Credit Agreement</th>
                                <th class="border-2 border-black px-2 py-2 w-48">PO Date</th>
                                <th class="border-2 border-black px-2 py-2 w-48">PO Number</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Buyer Status</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Religion</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Province</th>
                                <th class="border-2 border-black px-2 py-2 w-48">City</th>
                                <th class="border-2 border-black px-2 py-2 w-48">District</th>
                                <th class="border-2 border-black px-2 py-2 w-48">Sub District</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="data-row">
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="no"
                                            class=" w-full bg-transparent paste-input px-1 text-center" value="1"
                                            readonly>
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="nomor_spk"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="customer_name_1"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="customer_name_2"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="payment_method"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="leasing"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="model"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="type"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="color"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="sales"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="branch"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="status"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="number" step="0.01" name="total_payment"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="customer_type"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="fleet"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="color_code"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="branch_id"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="type_id"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="checkbox" name="valid"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="date" name="valid_date"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="custom_type"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="spk_status"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="supervisor"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="date" name="date_if_credit_agreement"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="date" name="po_date"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="po_number"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="buyer_status"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="religion"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="province"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="city"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="district"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                                <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                    <div class="m-2 bg-transparent text-white rounded-md">
                                        <input type="text" name="sub_district"
                                            class=" w-full bg-transparent paste-input px-1 text-center">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button id="submit-button"
                class="mt-4 bg-[#E4E0E1] text-black w-[50%] py-2 rounded-lg hover:bg-gray-100 transition-all duration-300 text-2xl font-bold">
                Submit
                </button>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".paste-input").forEach(input => {
            input.addEventListener("paste", function(event) {
                event.preventDefault(); // Prevent default paste behavior

                let clipboardData = event.clipboardData || window.clipboardData;
                let pastedData = clipboardData.getData("text"); // Get pasted content

                let rows = pastedData.trim().split("\n").map(row => row.split(
                "\t")); // Split into rows & columns
                let tableBody = this.closest("table").querySelector(
                "tbody"); // Find the correct table body
                let startColumnIndex = Array.from(this.closest("tr").children).indexOf(this
                    .closest("td")); // Get starting column index
                let existingRows = tableBody.querySelectorAll(
                ".data-row:not(:first-child)"); // Get existing rows

                rows.forEach((data, rowIndex) => {
                    let targetRow = existingRows[rowIndex] || document.createElement(
                        "tr"); // Use existing row or create new
                    targetRow.classList.add("data-row");

                    // Ensure targetRow has enough cells
                    while (targetRow.children.length < this.closest("tr").children
                        .length) {
                        let newCell = document.createElement("td");
                        newCell.className = this.closest("td").className;
                        let div = document.createElement("div");
                        div.className = "m-2 bg-transparent text-white rounded-md";
                        let input = document.createElement("input");
                        input.className = "w-full bg-transparent px-1 text-center";
                        const nameColumn = ['no', 'nomor_spk', 'customer_name_1',
                            'customer_name_2', 'payment_method', 'leasing', 'model',
                            'type', 'color', 'sales', 'branch', 'status',
                            'total_payment', 'customer_type', 'fleet', 'color_code',
                            'branch_id', 'type_id', 'valid', 'valid_date',
                            'custom_type', 'spk_status', 'supervisor',
                            'date_if_credit_agreement', 'po_date', 'po_number',
                            'buyer_status', 'religion', 'province', 'city',
                            'district', 'sub_district'
                        ];
                        input.type = "text";
                        input.name = nameColumn[targetRow.children.length];
                        if (targetRow.children.length === 0) {
                            input.value = existingRows.length + rowIndex + 2;
                            input.readOnly = true;
                        }
                        div.appendChild(input);
                        newCell.appendChild(div);
                        targetRow.appendChild(newCell);
                    }

                    if (data.every(cellData => cellData.trim() === "")) {
                        return;
                    }

                    // Paste multiple columns
                    data.forEach((cellData, colIndex) => {
                        let targetColumnIndex = startColumnIndex + colIndex;
                        if (targetColumnIndex < targetRow.children.length) {
                            let targetCell = targetRow.children[
                                targetColumnIndex];
                            const nameColumn = ['no', 'nomor_spk',
                                'customer_name_1', 'customer_name_2',
                                'payment_method', 'leasing', 'model',
                                'type', 'color', 'sales', 'branch',
                                'status', 'total_payment', 'customer_type',
                                'fleet', 'color_code', 'branch_id',
                                'type_id', 'valid', 'valid_date',
                                'custom_type', 'spk_status', 'supervisor',
                                'date_if_credit_agreement', 'po_date',
                                'po_number', 'buyer_status', 'religion',
                                'province', 'city', 'district',
                                'sub_district'
                            ];
                            targetCell.querySelector("input").name = nameColumn[
                                targetColumnIndex];
                            const $inputElement = $(targetCell).find("input");
                            if (targetColumnIndex === 0) {
                                $inputElement.val(existingRows.length +
                                    rowIndex + 1);
                            } else {
                                $inputElement.val(cellData.trim());
                            }
                        }
                    });

                    if (!existingRows[rowIndex]) {
                        tableBody.appendChild(targetRow);
                    }
                });
            });
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

        document.getElementById("submit-button").addEventListener("click", function() {
            $(this).prop('disabled', true);
            $(this).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
            const data = [];
            document.querySelectorAll(".data-row").forEach((row) => {
                const dataRow = {
                    nomor_spk: row.querySelector('input[name="nomor_spk"]')?.value || '',
                    customer_name_1: row.querySelector('input[name="customer_name_1"]')
                        ?.value || '',
                    customer_name_2: row.querySelector('input[name="customer_name_2"]')
                        ?.value || '',
                    payment_method: row.querySelector('input[name="payment_method"]')
                        ?.value || '',
                    leasing: row.querySelector('input[name="leasing"]')?.value || '',
                    model: row.querySelector('input[name="model"]')?.value || '',
                    type: row.querySelector('input[name="type"]')?.value || '',
                    color: row.querySelector('input[name="color"]')?.value || '',
                    sales: row.querySelector('input[name="sales"]')?.value || '',
                    branch: row.querySelector('input[name="branch"]')?.value || '',
                    status: row.querySelector('input[name="status"]')?.value || '',
                    total_payment: row.querySelector('input[name="total_payment"]')
                        ?.value || '',
                    customer_type: row.querySelector('input[name="customer_type"]')
                        ?.value || '',
                    fleet: row.querySelector('input[name="fleet"]')?.value || '',
                    color_code: row.querySelector('input[name="color_code"]')?.value || '',
                    branch_id: row.querySelector('input[name="branch_id"]')?.value || '',
                    type_id: row.querySelector('input[name="type_id"]')?.value || '',
                    valid: row.querySelector('input[name="valid"]')?.checked || false,
                    valid_date: row.querySelector('input[name="valid_date"]')?.value || '',
                    custom_type: row.querySelector('input[name="custom_type"]')?.value ||
                        '',
                    spk_status: row.querySelector('input[name="spk_status"]')?.value || '',
                    supervisor: row.querySelector('input[name="supervisor"]')?.value || '',
                    date_if_credit_agreement: row.querySelector(
                        'input[name="date_if_credit_agreement"]')?.value || '',
                    po_date: row.querySelector('input[name="po_date"]')?.value || '',
                    po_number: row.querySelector('input[name="po_number"]')?.value || '',
                    buyer_status: row.querySelector('input[name="buyer_status"]')?.value ||
                        '',
                    religion: row.querySelector('input[name="religion"]')?.value || '',
                    province: row.querySelector('input[name="province"]')?.value || '',
                    city: row.querySelector('input[name="city"]')?.value || '',
                    district: row.querySelector('input[name="district"]')?.value || '',
                    sub_district: row.querySelector('input[name="sub_district"]')?.value ||
                        '',
                };

                data.push(dataRow);
            })

            const requestBody = {
                data: data,
                type: 'spk'
            }
            fetch("{{ route('spk.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(requestBody)
                })
                .then(response => {
                    return response.json().then(data => {
                        if (!response.ok) {
                            if (data.errors) {
                                throw new Error(Object.values(data.errors).flat().join(
                                    '\n'));
                            }
                            throw new Error(data.message ||
                                'Terjadi kesalahan pada server.');
                        }
                        return data;
                    });
                })
                .then(data => {
                    if (data.errors) {
                        let errorMessage = Object.values(data.errors).flat().join('\n');

                        Toast.fire({
                            icon: "error",
                            title: errorMessage,
                            timer: 3000,
                        });
                    } else {
                        Toast.fire({
                            icon: "success",
                            title: 'Data SPK created successfully.',
                            timer: 1500,
                        }).then(() => {
                            window.location.href = "{{ route('spk.index') }}";
                        });
                    }
                })
                .catch(error => {
                    console.error('Fetch Error:', error);

                    Toast.fire({
                        icon: "error",
                        title: error.message || 'Terjadi kesalahan yang tidak diketahui.',
                        timer: 3000,
                    });
                }).finally(() => {
                    $(this).prop('disabled', false);
                    $(this).html('Submit');
                });
        });
    });
</script>

</html>

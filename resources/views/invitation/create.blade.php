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

        /* Target hanya input number dalam DataTables */
        .dataTables_wrapper input[type="number"]::-webkit-outer-spin-button,
        .dataTables_wrapper input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
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

            <div class="relative mt-3 w-full flex items-center px-6 font-bold text-white z-20">
                <a href="{{ route('invitation.index', ['branch' => $branch->branch_name]) }}">
                    <i style="font-size: 30px;" class="fa-solid fa-arrow-left text-2xl ml-2"></i>
                </a>

                <div class="absolute left-1/2 -translate-x-1/2 text-xl flex items-center gap-4">
                    <p style="font-size: 30px;">Data Undangan -</p>
                    <div class="relative">
                        <button id="branchDropdownButton" class="text-xl font-bold text-white bg-green-600 px-4 py-2 rounded-lg hover:bg-green-700">
                            {{ $branch->branch_name }} ▼
                        </button>
                        <div id="branchDropdownMenu"
                            class="hidden absolute left-0 top-full mt-2 bg-white shadow-lg rounded-lg w-52 max-h-60 overflow-y-auto transition-all duration-300 opacity-0 transform scale-95 z-[999]">
                            @foreach (App\Models\Branch::all() as $branchItem)
                                <button onclick="changeBranch('{{ $branchItem->id_branch }}', '{{ $branchItem->branch_name }}')"
                                    class="block px-5 py-3 text-black hover:bg-gray-100 transition-all duration-300 w-full text-left {{ $branchItem->id_branch == $branch->id_branch ? 'bg-green-100 font-semibold' : '' }}">
                                    {{ $branchItem->branch_name }}
                                    @if($branchItem->id_branch == $branch->id_branch)
                                        <i class="fas fa-check text-green-600 float-right mt-1"></i>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative flex justify-center items-center flex-col">
                <!-- Branch Selection (hidden input, shown for info only) -->
                <input type="hidden" id="branch_id" value="{{ $branch->id_branch }}">

                <table class="mt-4">
                    <thead>
                        <tr style="background-color: #E4E0E1;">
                            <th class="border-2 border-black px-2 py-2 w-24">No</th>
                            <th class="border-2 border-black px-2 py-2 w-64">Nama</th>
                            <th class="border-2 border-black px-2 py-2  w-48">Alamat</th>
                            <th class="border-2 border-black px-2 py-2  w-48">Nomor HP</th>
                            <th class="border-2 border-black px-2 py-2  w-96 ">Sales yang mengundang</th>
                            <th class="border-2 border-black px-2 py-2  w-48">Tanggal Undangan</th>
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
                            <td class="text-white text-xl ml-4  border-2 border-black w-20">
                                <div class="m-2 bg-transparent text-white rounded-md">
                                    <input type="text" name="name"
                                        class=" w-full bg-transparent paste-input px-1 text-center">
                                </div>
                            </td>
                            <td class="text-white text-xl ml-4  border-2 border-black w-20">
                                <div class="m-2 bg-transparent text-white rounded-md">
                                    <input type="text" name="address"
                                        class=" w-full bg-transparent paste-input px-1 text-center">
                                </div>
                            </td>
                            <td class="text-white text-xl ml-4  border-2 border-black w-20">
                                <div class="m-2 bg-transparent text-white rounded-md">
                                    <input type="text" name="number_phone"
                                        class=" w-full bg-transparent paste-input px-1 text-center">
                                </div>
                            </td>
                            <td class="text-white text-xl ml-4  border-2 border-black w-20">
                                <div class="m-2 bg-transparent text-white rounded-md">
                                    <input type="text" name="sales_invitation"
                                        class=" w-full bg-transparent paste-input px-1 text-center">
                                </div>
                            </td>
                            <td class="text-white text-xl ml-4  border-2 border-black w-20">
                                <div class="m-2 bg-transparent text-white rounded-md">
                                    <input type="date" name="invitation_date"
                                        class=" w-full bg-transparent paste-input px-1 text-center" value="{{ date('Y-m-d') }}">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button id="submit-button"
                    class="mt-4 bg-[#E4E0E1] text-black w-[50%]  py-2 rounded-l hover:bg-gray-100 focus:outline-none transition-all duration-300 ease-in-out text-2xl font-bold">
                    Submit
                </button>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Branch dropdown functionality
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
                            const nameColumn = ['no', 'name', 'address', 'number_phone',
                                'sales_invitation', 'invitation_date'
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
                                const nameColumn = ['no', 'name', 'address',
                                    'number_phone', 'sales_invitation', 'invitation_date'
                                ];
                                targetCell.querySelector("input").name = nameColumn[
                                    targetColumnIndex];
                                const $inputElement = $(targetCell).find(
                                    "input");
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
                        name: row.querySelector('input[name="name"]')?.value || '',
                        address: row.querySelector('input[name="address"]')?.value || '',
                        number_phone: row.querySelector('input[name="number_phone"]')?.value || '',
                        sales_invitation: row.querySelector('input[name="sales_invitation"]')?.value || '',
                        invitation_date: row.querySelector('input[name="invitation_date"]')?.value || '',
                    };

                    data.push(dataRow);
                })

                const requestBody = {
                    data: data,
                    branch_id: document.getElementById('branch_id').value,
                    type: 'invitation'
                }

                fetch("{{ route('invitation.store') }}", {
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
                                    throw new Error(Object.values(data.errors)[0][0]);
                                }
                                throw new Error(data.message || 'Terjadi kesalahan pada server.');
                            }
                            return data;
                        });
                    })
                    .then(data => {
                        if (data.errors) {
                            let errorMessage = Object.values(data.errors)[0][0];

                            Toast.fire({
                                icon: "error",
                                title: errorMessage,
                                timer: 3000,
                            });
                        } else {
                            Toast.fire({
                                icon: "success",
                                title: 'Data Undangan created successfully.',
                                timer: 1500,
                            }).then(() => {
                                document.querySelectorAll(".data-row").forEach((row) => {
                                    row.querySelectorAll('input').forEach((input, index) => {
                                        if (index !== 0) {
                                            input.value = '';
                                        }
                                    });
                                });
                                // Use selected branch for redirect
                                const branchName = window.selectedBranchName || '{{ $branch->branch_name }}';
                                window.location.href = "{{ route('invitation.index') }}" + '?branch=' + encodeURIComponent(branchName);
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
                        $('#submit-button').prop('disabled', false);
                        $('#submit-button').html('Submit');
                        document.querySelectorAll(".data-row").forEach((row) => {
                            row.querySelector('input[name="name"]').value = '';
                            row.querySelector('input[name="address"]').value = '';
                            row.querySelector('input[name="number_phone"]').value = '';
                            row.querySelector('input[name="sales_invitation"]').value = '';
                            row.querySelector('input[name="invitation_date"]').value = '{{ date("Y-m-d") }}';
                        });
                    });
            });
        });

        function changeBranch(branchId, branchName) {
            // Update hidden input and button text
            document.getElementById('branch_id').value = branchId;
            document.getElementById('branchDropdownButton').innerHTML = branchName + ' ▼';

            // Hide dropdown
            document.getElementById('branchDropdownMenu').classList.add('hidden', 'opacity-0', 'scale-95');

            // Update back button href with selected branch
            const backButton = document.querySelector('a[href*="invitation.index"]');
            if (backButton) {
                const baseUrl = backButton.href.split('?')[0];
                backButton.href = baseUrl + '?branch=' + encodeURIComponent(branchName);
            }

            // Update success redirect URL for form submission
            window.selectedBranchName = branchName;
        }
    </script>
</body>

</html>

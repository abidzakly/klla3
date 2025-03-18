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

            <div class="relative mt-3 w-full flex items-center px-6 font-bold text-white">

                <a href="{{ route('invitation.index') }}"><i style="font-size: 30px;"
                        class="fa-solid fa-arrow-left text-2xl ml-2"></i>
                </a>

                <p style="font-size: 30px;" class="absolute left-1/2 -translate-x-1/2 text-xl">
                    Data Undangan
                </p>


            </div>

            <div class="relative flex justify-center items-center flex-col">

                <table class="mt-4">
                    <thead>
                        <tr style="background-color: #E4E0E1;">
                            <th class="border-2 border-black px-2 py-2 w-24">No</th>
                            <th class="border-2 border-black px-2 py-2 w-64">Nama</th>
                            <th class="border-2 border-black px-2 py-2  w-48">Alamat</th>
                            <th class="border-2 border-black px-2 py-2  w-48">Nomor HP</th>
                            <th class="border-2 border-black px-2 py-2  w-96 ">Sales yang mengundang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="data-row">
                            <td class="text-white text-xl ml-4 border-2 border-black w-20">
                                <div class="m-2 bg-transparent text-white rounded-md">
                                    <input type="text" name="no" class=" w-full bg-transparent paste-input px-1 text-center" value="1" readonly>
                                </div>
                            </td>
                            <td class="text-white text-xl ml-4  border-2 border-black w-20">
                                <div class="m-2 bg-transparent text-white rounded-md">
                                    <input type="text" name="name" class=" w-full bg-transparent paste-input px-1 text-center">
                                </div>
                            </td>
                            <td class="text-white text-xl ml-4  border-2 border-black w-20">
                                <div class="m-2 bg-transparent text-white rounded-md">
                                    <input type="text" name="address" class=" w-full bg-transparent paste-input px-1 text-center">
                                </div>
                            </td>
                            <td class="text-white text-xl ml-4  border-2 border-black w-20">
                                <div class="m-2 bg-transparent text-white rounded-md">
                                    <input type="text" name="number_phone" class=" w-full bg-transparent paste-input px-1 text-center">
                                </div>
                            </td>
                            <td class="text-white text-xl ml-4  border-2 border-black w-20">
                                <div class="m-2 bg-transparent text-white rounded-md">
                                    <input type="text" name="sales_invitation" class=" w-full bg-transparent paste-input px-1 text-center">
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
                        let targetRow = existingRows[rowIndex] || document.createElement("tr"); // Use existing row or create new
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
                            const nameColumn = ['no', 'name', 'address', 'number_phone', 'sales_invitation'];
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
                                const nameColumn = ['no', 'name', 'address', 'number_phone', 'sales_invitation'];
                                targetCell.querySelector("input").name = nameColumn[
                                    targetColumnIndex];
                                const $inputElement = $(targetCell).find(
                                    "input");
                                if (targetColumnIndex === 0) {
                                    $inputElement.val(existingRows.length + rowIndex + 1);
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
                        // no: row.querySelector('input[name="no"]')?.value || '',
                        name: row.querySelector('input[name="name"]')?.value || '',
                        address: row.querySelector('input[name="address"]')?.value || '',
                        number_phone: row.querySelector('input[name="number_phone"]')?.value || '',
                        sales_invitation: row.querySelector('input[name="sales_invitation"]')?.value || '',
                    };

                    data.push(dataRow);
                })

                const requestBody = {
                    data: data,
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
                                if(data.errors) {
                                    throw new Error(Object.values(data.errors).flat().join('\n'));
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
                                title: 'Data Undangan created successfully.',
                                timer: 1500,
                            }).then(() => {
                                window.location.href = "{{ route('invitation.index') }}";
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
</body>
</html>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite('resources/css/app.css')
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="flex flex-col items-center min-h-screen bg-gray-100">
    <nav class="flex items-center justify-between w-full px-6 py-4 text-white bg-green-900 shadow-md">
        <a href="{{ url('/') }}">
            <img src="{{ asset('image/logooo 1.png') }}" alt="Logo">
        </a>
        <h1 class="mx-auto text-xl font-bold" style="font-size: 36px;">Monitoring Data DO dan SPK</h1>
    </nav>

    <div class="flex flex-col w-full max-w-6xl mt-6 space-y-4">

        <div class="flex justify-between">
            <a href="{{ route('input.select') }}"
                class="px-4 py-2 mb-2 text-white bg-green-500 rounded hover:bg-green-600">
                Tambahkan Data
            </a>
             {{-- select date --}}
             <div class="flex items-center gap-3">
                <label for="date" class="mr-2 text-lg font-bold text-gray-700">Pilih Tanggal:</label>
                <input type="date" id="date" name="date" value="{{ date('Y-m-d') }}"
                    class="px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-green-500">
            </div>
        </div>

        <div class="flex flex-col items-center justify-center p-6 bg-green-800 rounded-lg shadow-md">
            <h1 class="text-3xl font-bold text-white">Input Data SPK</h1>
            <table class="mt-4">
                <thead>
                    <tr style="background-color: #E4E0E1;">
                        <th class="px-2 py-2 border-2 border-black w-96">Nama Supervisor</th>
                        <th class="w-48 px-2 py-2 border-2 border-black">Target SPK</th>
                        <th class="w-48 px-2 py-2 border-2 border-black">Act SPK</th>
                        <th class="w-48 px-2 py-2 border-2 border-black">GAP</th>
                        <th class="w-48 px-2 py-2 border-2 border-black ">Ach (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="data-row">
                        <td class="w-20 ml-4 text-xl text-white border-2 border-black">
                            <div class="m-2 text-white bg-transparent rounded-md">
                                <input type="text" name="nama_supervisor"
                                    class="w-full px-1 text-center bg-transparent paste-input">
                            </div>
                        </td>
                        <td class="w-20 ml-4 text-xl text-white border-2 border-black">
                            <div class="m-2 text-white bg-transparent rounded-md">
                                <input type="number" name="target_spk"
                                    class="w-full px-1 text-center bg-transparent paste-input"
                                    oninput="(calculateGapAndAch(this))">
                            </div>
                        </td>
                        <td class="w-20 ml-4 text-xl text-white border-2 border-black">
                            <div class="m-2 text-white bg-transparent rounded-md">
                                <input type="number" name="act_spk"
                                    class="w-full px-1 text-center bg-transparent paste-input"
                                    oninput="(calculateGapAndAch(this))">
                            </div>
                        </td>
                        <td class="w-20 ml-4 text-xl text-white border-2 border-black">
                            <div class="m-2 text-white bg-transparent rounded-md">
                                <input type="text" name="gap_spk"
                                    class="w-full px-1 text-center bg-transparent paste-input" readonly>
                            </div>
                        </td>
                        <td class="w-20 ml-4 text-xl text-white border-2 border-black">
                            <div class="m-2 text-white bg-transparent rounded-md">
                                <input type="text" name="ach_spk"
                                    class="w-full px-1 text-center bg-transparent paste-input" readonly>
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
</body>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    function calculateGapAndAch(e) {
        // find tr parent
        const tr = e.closest('tr');
        const targetDo = parseFloat(tr.querySelector('input[name="target_spk"]')?.value) || null;
        const actDo = parseFloat(tr.querySelector('input[name="act_spk"]')?.value) || null;
        const gapDo = actDo - targetDo;
        const achDo = (targetDo > 0) ? (actDo / targetDo) * 100 : 0;
        tr.querySelector('input[name="gap_spk"]').value = Math.round(gapDo);
        tr.querySelector('input[name="ach_spk"]').value = Math.round(achDo) + "%";
        if (targetDo == null && actDo == null) {
            tr.querySelector('input[name="gap_spk"]').value = "";
            tr.querySelector('input[name="ach_spk"]').value = "";
        }
    };

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

                const nameColumn = ['nama_supervisor', 'target_spk', 'act_spk', 'gap_spk',
                    'ach_spk'
                ];
                rows.forEach((data, rowIndex) => {
                    let targetRow = document.createElement(
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
                        input.name = nameColumn[targetRow.children.length];
                        input.type = "text";
                        if (targetRow.children.length === 1 || targetRow.children
                            .length === 2) {
                            input.setAttribute('oninput', 'calculateGapAndAch(this)');
                            input.type = "number";
                        }
                        if (targetRow.children.length === 3 || targetRow.children
                            .length === 4) {
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
                            if (targetColumnIndex === 1 || targetColumnIndex ===
                                2 || targetColumnIndex == 0) {
                                const $inputElement = $(targetCell).find(
                                    "input");
                                $inputElement.val(cellData.trim())
                            }
                        }
                    });

                    // Add the row if it's new
                    // if (!existingRows[rowIndex]) {
                    // tableBody.appendChild(targetRow);
                    // }
                    tableBody.appendChild(targetRow);

                    targetRow.querySelectorAll('input').forEach(input => {
                        calculateGapAndAch(input);
                    });
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
            $(this).prop("disabled", true);
            $(this).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

            const data = [];
            document.querySelectorAll(".data-row").forEach((row) => {
                const dataRow = {
                    nama_supervisor: row.querySelector('input[name="nama_supervisor"]')
                        ?.value || '',
                    target_spk: row.querySelector('input[name="target_spk"]')?.value ||
                        null,
                    act_spk: row.querySelector('input[name="act_spk"]')?.value || null,
                    // gap_spk: row.querySelector('input[name="gap_spk"]')?.value || null,
                    // ach_spk: row.querySelector('input[name="ach_spk"]')?.value || null,
                };

                data.push(dataRow);
            })

            const requestBody = {
                data: data,
                type: 'SPK',
                date: document.getElementById('date').value,
            }
            fetch("{{ route('monitoring_do_spk.store') }}", {
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
                            this.disabled = false;
                            this.innerText = "Submit";
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
                            window.location.href = "{{ route('dashboard') }}";
                        });
                        this.innerText = "Submit";
                    }
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                    this.disabled = false;
                    this.innerText = "Submit";
                    Toast.fire({
                        icon: "error",
                        title: error.message || 'Terjadi kesalahan yang tidak diketahui.',
                        timer: 3000,
                    });
                })
        });
    });
</script>

</html>

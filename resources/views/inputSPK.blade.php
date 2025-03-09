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
        <img src="{{ asset('image/logooo 1.png') }}" alt="Logo">
        <h1 class="mx-auto text-xl font-bold" style="font-size: 36px;">Monitoring Data DO dan SPK</h1>
    </nav>

    <div class="flex flex-col w-full max-w-6xl mt-6 space-y-4">

        <div class="flex justify-start">
            <a href="{{ route('input.select') }}"
                class="px-4 py-2 mb-2 text-white bg-green-500 rounded hover:bg-green-600">
                Tambahkan Data
            </a>
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
                                <input type="text" name="nama_supervisor" class="w-full px-1 text-center bg-transparent paste-input">
                            </div>
                        </td>
                        <td class="w-20 ml-4 text-xl text-white border-2 border-black">
                            <div class="m-2 text-white bg-transparent rounded-md">
                                <input type="number" name="target_spk" class="w-full px-1 text-center bg-transparent paste-input">
                            </div>
                        </td>
                        <td class="w-20 ml-4 text-xl text-white border-2 border-black">
                            <div class="m-2 text-white bg-transparent rounded-md">
                                <input type="number" name="act_spk" class="w-full px-1 text-center bg-transparent paste-input">
                            </div>
                        </td>
                        <td class="w-20 ml-4 text-xl text-white border-2 border-black">
                            <div class="m-2 text-white bg-transparent rounded-md">
                                <input type="number" name="gap_spk" class="w-full px-1 text-center bg-transparent paste-input" readonly>
                            </div>
                        </td>
                        <td class="w-20 ml-4 text-xl text-white border-2 border-black">
                            <div class="m-2 text-white bg-transparent rounded-md">
                                <input type="number" name="ach_spk" class="w-full px-1 text-center bg-transparent paste-input" readonly>
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

</html>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".paste-input").forEach(input => {
            input.addEventListener("paste", function (event) {
                event.preventDefault(); // Prevent default paste behavior

                let clipboardData = event.clipboardData || window.clipboardData;
                let pastedData = clipboardData.getData("text"); // Get pasted content

                let rows = pastedData.trim().split("\n").map(row => row.split("\t")); // Split into rows & columns
                let tableBody = this.closest("table").querySelector("tbody"); // Find the correct table body
                let startColumnIndex = Array.from(this.closest("tr").children).indexOf(this.closest("td")); // Get starting column index
                let existingRows = tableBody.querySelectorAll(".data-row:not(:first-child)"); // Get existing rows

                rows.forEach((data, rowIndex) => {
                    let targetRow = existingRows[rowIndex] || document.createElement("tr"); // Use existing row or create new
                    targetRow.classList.add("data-row");

                    // Ensure targetRow has enough cells
                    while (targetRow.children.length < this.closest("tr").children.length) {
                        let newCell = document.createElement("td");
                        newCell.className = this.closest("td").className;
                        let div = document.createElement("div");
                        div.className = "m-2 bg-transparent text-white rounded-md";
                        let p = document.createElement("p");
                        p.className = "editable w-full bg-transparent px-1 text-center";
                        p.textContent = ""; // Empty cell initially
                        div.appendChild(p);
                        newCell.appendChild(div);
                        targetRow.appendChild(newCell);
                    }

                    // Paste multiple columns
                    data.forEach((cellData, colIndex) => {
                        let targetColumnIndex = startColumnIndex + colIndex;
                        if (targetColumnIndex < targetRow.children.length) {
                            let targetCell = targetRow.children[targetColumnIndex];
                            targetCell.querySelector("p").textContent = cellData.trim();
                        }
                    });

                    // Add the row if it's new
                    if (!existingRows[rowIndex]) {
                        tableBody.appendChild(targetRow);
                    }
                });
            });
        });

        const calculateGapAndAch = () => {
            const targetSpk = parseFloat(document.querySelector('input[name="target_spk"]').value) || 0;
            const actSpk = parseFloat(document.querySelector('input[name="act_spk"]').value) || 0;
            const gapSpk = actSpk - targetSpk;
            const achSpk = (targetSpk > 0) ? (actSpk / targetSpk) * 100 : 0;
            document.querySelector('input[name="gap_spk"]').value = gapSpk.toFixed(2);
            document.querySelector('input[name="ach_spk"]').value = achSpk.toFixed(2);
        };

        document.querySelector('input[name="target_spk"]').addEventListener('input', calculateGapAndAch);
        document.querySelector('input[name="act_spk"]').addEventListener('input', calculateGapAndAch);

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
            const data = {
                nama_supervisor: document.querySelector('input[name="nama_supervisor"]')?.value || '',
                target_spk: document.querySelector('input[name="target_spk"]')?.value || null,
                act_spk: document.querySelector('input[name="act_spk"]')?.value || null,
                gap_spk: document.querySelector('input[name="gap_spk"]')?.value || null,
                ach_spk: document.querySelector('input[name="ach_spk"]')?.value || null,
                status: 'SPK',
                type: 'SPK'
            };

            fetch("{{ route('monitoring_do_spk.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.errors) {
                    let errorMessage = '';
                    for (const [key, value] of Object.entries(data.errors)) {
                        errorMessage += `${value}\n`;
                    }
                    Toast.fire({
                        icon: "error",
                        title: errorMessage,
                        timer: 3000,
                    });
                } else {
                    Toast.fire({
                        icon: "success",
                        title: 'Data SPK updated successfully.',
                        timer: 1500,
                    }).then(() => {
                        location.reload();
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

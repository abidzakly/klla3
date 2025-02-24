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
</head>

<body class="bg-gray-100 flex flex-col items-center min-h-screen">
    <nav class="bg-green-900 text-white w-full px-6 py-4 flex justify-between items-center shadow-md">
        <img src="{{ asset('image/logooo 1.png') }}" alt="Logo">
        <h1 class="text-xl font-bold mx-auto" style="font-size: 36px;">Monitoring Data DO dan SPK</h1>
    </nav>

    <div class="w-full max-w-6xl flex flex-col space-y-4 mt-6">

        <div class="flex justify-start">
            <a href="{{ route('input.select') }}"
                class="bg-green-500  text-white px-4 py-2 rounded hover:bg-green-600 mb-2">
                Tambahkan Data
            </a>
        </div>

        <div class="bg-green-800 p-6 rounded-lg shadow-md flex flex-col items-center justify-center">
            <h1 class="text-white text-3xl font-bold">Input Data DO</h1>
            <table class="mt-4">
                <thead>
                    <tr style="background-color: #E4E0E1;">
                        <th class="border-2 border-black px-2 py-2 w-96">Nama Supervisor</th>
                        <th class="border-2 border-black px-2 py-2 w-48">Target DO</th>
                        <th class="border-2 border-black px-2 py-2  w-48">Act DO</th>
                        <th class="border-2 border-black px-2 py-2  w-48">GAP</th>
                        <th class="border-2 border-black px-2 py-2  w-48 ">Ach (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="data-row">
                        <td class="text-white text-xl ml-4 border-2 border-black w-20">
                            <div class="m-2 bg-transparent text-white rounded-md">
                                <input type="text" class=" w-full bg-transparent paste-input px-1 text-center">
                            </div>
                        </td>
                        <td class="text-white text-xl ml-4  border-2 border-black w-20">
                            <div class="m-2 bg-transparent text-white rounded-md">
                                <input type="number" class=" w-full bg-transparent paste-input px-1 text-center">
                            </div>
                        </td>
                        <td class="text-white text-xl ml-4  border-2 border-black w-20">
                            <div class="m-2 bg-transparent text-white rounded-md">
                                <input type="number" class=" w-full bg-transparent paste-input px-1 text-center">
                            </div>
                        </td>
                        <td class="text-white text-xl ml-4  border-2 border-black w-20">
                            <div class="m-2 bg-transparent text-white rounded-md">
                                <input type="number" class=" w-full bg-transparent paste-input px-1 text-center">
                            </div>
                        </td>
                        <td class="text-white text-xl ml-4  border-2 border-black w-20">
                            <div class="m-2 bg-transparent text-white rounded-md">
                                <input type="number" class=" w-full bg-transparent paste-input px-1 text-center">
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
    });
</script>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @vite('resources/css/app.css')
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
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

            <div class="relative w-full flex items-center px-6 font-bold text-white">

                <a href="{{ route('dashboard') }}"><i style="font-size: 30px;"
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
    </div>

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









</body>




</html>
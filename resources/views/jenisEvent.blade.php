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
        <div class="relative w-full flex flex-col rounded-lg shadow-md items-center justify-center group p-6">
            <div class="w-full min-h-[80vh] h-full absolute inset-0 bg-green-800 opacity-70 rounded-lg"></div>



            <div class="relative w-full flex items-center px-6 font-bold text-white">

                <a href="{{ route('dashboard') }}" class="text-white">
                    <i class="fa-solid fa-arrow-left text-2xl ml-2"></i>
                </a>

                <div class="absolute left-1/2 -translate-x-1/2">
                    <button id="dropdownButton" class="text-xl font-bold text-white">
                        Foto Foto Jenis Event ▼
                    </button>

                    <div id="dropdownMenu"
                        class="hidden absolute left-[55%] mt-2 bg-white shadow-lg rounded-lg w-52 overflow-hidden transition-all duration-300 opacity-0 transform scale-95">

                        <a href="{{ route('kwitansi') }}"
                            class="block px-5 py-3 text-black hover:bg-gray-100 transition-all duration-300">Foto
                            Kwitansi</a>
                        <a href="{{ route('detail.biaya') }}"
                            class="block px-5 py-3 text-black hover:bg-gray-100 transition-all duration-300">Foto
                            Detail Biaya</a>

                        <a href="{{ route('evaluasi') }}"
                            class="block px-5 py-3 text-black hover:bg-gray-100 transition-all duration-300">Foto
                            Foto Evaluasi</a>
                    </div>
                </div>

                <label for="imageUpload"
                    class="cursor-pointer flex items-center gap-2 ml-auto text-white text-lg font-bold">
                    <i class="fa-solid fa-plus"></i>
                    <span>Upload Foto</span>
                    <input type="file" id="imageUpload" class="hidden" accept="image/*">
                </label>
            </div>


            <!-- KALO MAU TES FOTO FILE -->
            <!-- <div
                class="relative grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8 m-8 justify-center w-full">
                <div class="flex flex-col items-center justify-center">
                    <div class="bg-[#d9d9d9] flex flex-col w-60 h-50">
                        <div class="flex justify-between mx-2">
                            <p class="text-black font-bold text-lg ">Nama File</p>
                            <i style="font-size: 20px;" class="mt-1 fa-solid fa-ellipsis-vertical"></i>
                        </div>
                        <hr class="border-black w-full">
                        <div class="w-full h-full overflow-hidden  flex items-center justify-center">
                            <img class="w-full h-full object-cover" src="{{ asset('image/tes.jpg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div> -->



            <!-- KALO MAU TES DRAG AND DROP -->
            <div id="drop-area"
                class="text-white text-3xl font-bold relative flex flex-col w-full mt-40 gap-4 justify-center items-center  p-10 cursor-pointer focus:outline-none">
                <i class="fa-regular fa-file text-white" style="font-size:56px;"></i>
                <p>Tarik dan Lepaskan File Disini</p>
                <p>atau</p>
                <p>gunakan tombol "+"</p>

                <input type="file" id="file-input" class="hidden" accept="image/*" multiple>
            </div>
        </div>
    </div>









</body>



<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dropArea = document.getElementById("drop-area");
        const fileInput = document.getElementById("file-input");

        dropArea.addEventListener("click", () => fileInput.click());

        dropArea.addEventListener("dragover", (e) => {
            e.preventDefault();
            dropArea.classList.add("bg-green-700");
        });

        dropArea.addEventListener("dragleave", () => {
            dropArea.classList.remove("bg-green-700");
        });

        dropArea.addEventListener("drop", (e) => {
            e.preventDefault();
            dropArea.classList.remove("bg-green-700");
            const files = e.dataTransfer.files;
            handleFiles(files);
        });

        fileInput.addEventListener("change", (e) => {
            const files = e.target.files;
            handleFiles(files);
        });

        function handleFiles(files) {
            if (files.length > 0) {
                alert(`${files.length} file(s) selected.`);
                // You can process the files here (e.g., upload them)
            }
        }
    });
</script>

<script>
    const dropdownButton = document.getElementById("dropdownButton");
    const dropdownMenu = document.getElementById("dropdownMenu");

    dropdownButton.addEventListener("click", () => {
        dropdownMenu.classList.toggle("hidden");
        dropdownMenu.classList.toggle("opacity-0");
        dropdownMenu.classList.toggle("scale-95");
    });

    document.addEventListener("click", (event) => {
        if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.add("hidden", "opacity-0", "scale-95");
        }
    });
</script>

</html>

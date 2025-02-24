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
            <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mb-2">
                Input Data SPK
            </button>
        </div>

        <div class="bg-green-800 p-6 rounded-lg shadow-md overflow-x-auto">
            <div class="bg-gray-100 m-20 rounded-lg w-30 h-40 flex flex-col items-center justify-center gap-4">
                <p class="text-l font-bold mx-auto"> Pilih jenis data yang akan ditambahkan</p>
                <div class="flex flex-row gap-4">

                    <a href="{{ route('inputDO') }}"
                        class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                        Input Data DO
                    </a>
                    <a href="{{ route('inputSPK') }}"
                        class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                        Input Data SPK
                    </a>
                </div>

            </div>
        </div>


    </div>
</body>

</html>
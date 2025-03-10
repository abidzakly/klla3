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

<body class="flex flex-col items-center min-h-screen bg-gray-100">
    <nav class="flex items-center justify-between w-full px-6 py-4 text-white bg-green-900 shadow-md">
        <a href="{{ url('/') }}">
            <img src="{{ asset('image/logooo 1.png') }}" alt="Logo">
        </a>
        <h1 class="mx-auto text-xl font-bold" style="font-size: 36px;">Monitoring Data DO dan SPK</h1>
    </nav>

    <div class="flex flex-col w-full max-w-6xl mt-6 space-y-4">

        <div class="flex justify-start">
            <a href="{{ url('/') }}">
                <button class="px-4 py-2 mb-2 text-white bg-green-500 rounded hover:bg-green-600">
                    Kembali
                </button>
            </a>            
        </div>

        <div class="p-6 overflow-x-auto bg-green-800 rounded-lg shadow-md">
            <div class="flex flex-col items-center justify-center h-40 gap-4 m-20 bg-gray-100 rounded-lg w-30">
                <p class="mx-auto font-bold text-l"> Pilih jenis data yang akan ditambahkan</p>
                <div class="flex flex-row gap-4">

                    <a href="{{ route('inputDO') }}"
                        class="px-3 py-1 text-white bg-green-500 rounded hover:bg-green-600">
                        Input Data DO
                    </a>
                    <a href="{{ route('inputSPK') }}"
                        class="px-3 py-1 text-white bg-green-500 rounded hover:bg-green-600">
                        Input Data SPK
                    </a>
                </div>

            </div>
        </div>


    </div>
</body>

</html>

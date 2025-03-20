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

    <div class="w-full flex flex-col  items-center justify-center mt-6">
        <div class="flex justify-center">
            <div class="relative w-full flex flex-col rounded-lg shadow-md flex items-center justify-center group">
                <div class="absolute inset-0 bg-green-800 opacity-70 rounded-lg"></div>

                <div class="relative flex gap-16 m-8 justify-center w-full">
                    <a href="{{ route('photo.event.type', ['photoEventType' => $photoEventTypes->firstWhere('photo_event_type_name', $photoEventTypeEnum::JENIS_EVENT)] ) }}" class="flex flex-col items-center justify-center mx-4 ">
                        <p class="text-white text-xl font-bold mb-2">Jenis Event</p>
                        <div class="bg-[#e4e6d9] flex flex-col w-80 h-50 items-center justify-center">
                            <i style="font-size:36px;" class="fa-solid fa-plus"></i>
                            <P class="text-xl text-black font-bold">Upload Foto</P>
                        </div>
                    </a>

                    <a href="{{ route('photo.event.type', ['photoEventType' => $photoEventTypes->firstWhere('photo_event_type_name', $photoEventTypeEnum::KWITANSI)] ) }}" class="flex flex-col items-center justify-center mx-4 ">
                        <p class="text-white text-xl font-bold mb-2">Kwitansi</p>
                        <div class="bg-[#e4e6d9] flex flex-col w-80 h-50 items-center justify-center">
                            <i style="font-size:36px;" class="fa-solid fa-plus"></i>
                            <P class="text-xl text-black font-bold">Upload Foto</P>
                        </div>
                    </a>

                    <a href="{{ route('data.undangan') }}" class="flex flex-col items-center justify-center mx-4">
                        <p class="text-white text-xl font-bold mb-2">Data Undangan</p>
                        <div class="bg-[#e4e6d9] flex flex-col w-80 h-50 items-center justify-center">

                        </div>
                    </a>
                </div>

                <div class="relative flex gap-16 m-8 justify-center w-full">
                    <a href="{{ route('data.spk') }}" class="flex flex-col items-center justify-center mx-4 ">
                        <p class="text-white text-xl font-bold mb-2">Data SPK</p>
                        <div class="bg-[#e4e6d9] flex flex-col w-80 h-50 items-center justify-center">

                        </div>
                    </a>

                    <a href="{{ route('photo.event.type', ['photoEventType' => $photoEventTypes->firstWhere('photo_event_type_name', $photoEventTypeEnum::DETAIL_BIAYA)] ) }}" class="flex flex-col items-center justify-center mx-4 ">
                        <p class="text-white text-xl font-bold mb-2">Detail Biaya</p>
                        <div class="bg-[#e4e6d9] flex flex-col w-80 h-50 items-center justify-center">
                            <i style="font-size:36px;" class="fa-solid fa-plus"></i>
                            <P class="text-xl text-black font-bold">Upload Foto</P>
                        </div>
                    </a>

                    <a href="{{ route('photo.event.type', ['photoEventType' => $photoEventTypes->firstWhere('photo_event_type_name', $photoEventTypeEnum::EVALUASI)] ) }}" class="flex flex-col items-center justify-center mx-4 ">
                        <p class="text-white text-xl font-bold mb-2">Evaluasi</p>
                        <div class="bg-[#e4e6d9] flex flex-col w-80 h-50 items-center justify-center">
                            <i style="font-size:36px;" class="fa-solid fa-plus"></i>
                            <P class="text-xl text-black font-bold">Upload Foto</P>
                        </div>
                    </a>
                </div>
            </div>


        </div>






</body>

</html>

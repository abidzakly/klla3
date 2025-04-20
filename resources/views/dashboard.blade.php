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

                @php
                    $jenisEvent = optional(
                        $photoEvents[
                            $photoEventTypes->firstWhere('photo_event_type_name', $photoEventTypeEnum::JENIS_EVENT)
                                ?->id_photo_event_type
                        ] ?? null,
                    );
                @endphp
                <div class="relative grid grid-cols-3 gap-16 mx-8 mb-2 mt-3 w-full justify-items-center">
                    <a href="{{ route('photo.event.type', ['photoEventType' => $photoEventTypes->firstWhere('photo_event_type_name', $photoEventTypeEnum::JENIS_EVENT)]) }}"
                        class="flex flex-col items-center {{ $jenisEvent == null ? 'justify-center' : '' }} mx-4 ">
                        <p class="text-white text-xl font-bold mb-2">Jenis Event</p>
                        <div
                            class="bg-[#e4e6d9] flex flex-col w-80 h-50 items-center {{ $jenisEvent ? 'justify-center' : '' }}">
                            <i style="font-size:36px;" class="fa-solid fa-plus"></i>
                            <P class="text-xl text-black font-bold">Upload Foto</P>
                        </div>
                        <div class="grid grid-cols-2 gap-4 w-90 px-4 mt-4">
                            @if ($jenisEvent->photo_event_location)
                                <div class="flex items-center gap-2 min-w-0">
                                    <i class="fa-solid fa-location-dot text-2xl mt-2 text-white flex-shrink-0"></i>
                                    <span class="truncate text-white block min-w-0 ml-2"
                                        style="white-space: nowrap;">{{ $jenisEvent->photo_event_location }}</span>
                                </div>
                            @endif
                            @if ($jenisEvent->photo_event_date)
                                <div class="flex items-center gap-2 min-w-0">
                                    <i class="fa-solid fa-calendar-days text-2xl text-white flex-shrink-0"></i>
                                    <span class="truncate text-white text-center block ml-2"
                                        style="white-space: nowrap;">{{ $jenisEvent->photo_event_date }}</span>
                                </div>
                            @endif
                            @if ($jenisEvent->photo_event_caption)
                                <div class="col-span-2 flex items-center gap-2 min-w-0">
                                    <i class="fa-solid fa-comment text-2xl mt-2 text-white flex-shrink-0"></i>
                                    <span class="truncate text-white block min-w-0 ml-2"
                                        style="white-space: nowrap;">{{ $jenisEvent->photo_event_caption }}</span>
                                </div>
                            @endif
                        </div>
                    </a>

                    @php
                        $kwitansi = optional(
                            $photoEvents[
                                $photoEventTypes->firstWhere('photo_event_type_name', $photoEventTypeEnum::KWITANSI)
                                    ?->id_photo_event_type
                            ] ?? null,
                        );
                    @endphp
                    <a href="{{ route('photo.event.type', ['photoEventType' => $photoEventTypes->firstWhere('photo_event_type_name', $photoEventTypeEnum::KWITANSI)]) }}"
                        class="flex flex-col items-center {{ $kwitansi == null ? 'justify-center' : '' }} mx-4 ">
                        <p class="text-white text-xl font-bold mb-2">Kwitansi</p>
                        <div class="bg-[#e4e6d9] flex flex-col w-80 h-50 items-center justify-center">
                            <i style="font-size:36px;" class="fa-solid fa-plus"></i>
                            <P class="text-xl text-black font-bold">Upload Foto</P>
                        </div>
                        <div class="grid grid-cols-2 gap-4 w-90 px-4 mt-4">
                            @if ($kwitansi->photo_event_location)
                                <div class="flex items-center gap-2 min-w-0">
                                    <i class="fa-solid fa-location-dot text-2xl mt-2 text-white flex-shrink-0"></i>
                                    <span class="truncate text-white block min-w-0 ml-2"
                                        style="white-space: nowrap;">{{ $kwitansi->photo_event_location }}</span>
                                </div>
                            @endif
                            @if ($kwitansi->photo_event_date)
                                <div class="flex items-center gap-2 min-w-0">
                                    <i class="fa-solid fa-calendar-days text-2xl text-white flex-shrink-0"></i>
                                    <span class="truncate text-white block min-w-0 ml-2"
                                        style="white-space: nowrap;">{{ $kwitansi->photo_event_date }}</span>
                                </div>
                            @endif
                            @if ($kwitansi->photo_event_caption)
                                <div class="col-span-2 flex items-center gap-2 min-w-0">
                                    <i class="fa-solid fa-comment text-2xl mt-2 text-white flex-shrink-0"></i>
                                    <span class="truncate text-white block min-w-0 ml-2"
                                        style="white-space: nowrap;">{{ $kwitansi->photo_event_caption }}</span>
                                </div>
                            @endif
                        </div>
                    </a>

                    <a href="{{ route('data.undangan') }}" class="flex flex-col items-center  mx-4">
                        <p class="text-white text-xl font-bold mb-2">Data Undangan</p>
                        <div class="bg-[#e4e6d9] flex flex-col w-80 h-50 items-center justify-center">

                        </div>
                    </a>
                </div>

                <div class="relative grid grid-cols-3 gap-16 mx-8 mb-5 mt-3 w-full justify-items-center">
                    <a href="{{ route('data.spk') }}" class="flex flex-col items-center mx-4 ">
                        <p class="text-white text-xl font-bold mb-2">Data SPK</p>
                        <div class="bg-[#e4e6d9] flex flex-col w-80 h-50 items-center justify-center">

                        </div>
                    </a>

                    @php
                        $detailBiaya = optional(
                            $photoEvents[
                                $photoEventTypes->firstWhere('photo_event_type_name', $photoEventTypeEnum::DETAIL_BIAYA)
                                    ?->id_photo_event_type
                            ] ?? null,
                        );
                    @endphp
                    <a href="{{ route('photo.event.type', ['photoEventType' => $photoEventTypes->firstWhere('photo_event_type_name', $photoEventTypeEnum::DETAIL_BIAYA)]) }}"
                        class="flex flex-col items-center {{ $detailBiaya == null ? 'justify-center' : '' }} mx-4 ">
                        <p class="text-white text-xl font-bold mb-2">Detail Biaya</p>
                        <div class="bg-[#e4e6d9] flex flex-col w-80 h-50 items-center justify-center">
                            <i style="font-size:36px;" class="fa-solid fa-plus"></i>
                            <P class="text-xl text-black font-bold">Upload Foto</P>
                        </div>
                        <div class="grid grid-cols-2 gap-4 w-90 px-4 mt-4">
                            @if ($detailBiaya->photo_event_location)
                                <div class="flex items-center gap-2 min-w-0">
                                    <i class="fa-solid fa-location-dot text-2xl mt-2 text-white flex-shrink-0"></i>
                                    <span class="truncate text-white block min-w-0 ml-2"
                                        style="white-space: nowrap;">{{ $detailBiaya->photo_event_location }}</span>
                                </div>
                            @endif
                            @if ($detailBiaya->photo_event_date)
                                <div class="flex items-center gap-2 min-w-0">
                                    <i class="fa-solid fa-calendar-days text-2xl text-white flex-shrink-0"></i>
                                    <span class="truncate text-white block min-w-0 ml-2"
                                        style="white-space: nowrap;">{{ $detailBiaya->photo_event_date }}</span>
                                </div>
                            @endif
                            @if ($detailBiaya->photo_event_caption)
                                <div class="col-span-2 flex items-center gap-2 min-w-0">
                                    <i class="fa-solid fa-comment text-2xl mt-2 text-white flex-shrink-0"></i>
                                    <span class="truncate text-white block min-w-0 ml-2"
                                        style="white-space: nowrap;">{{ $detailBiaya->photo_event_caption }}</span>
                                </div>
                            @endif
                        </div>
                    </a>

                    @php
                        $evaluasi = optional(
                            $photoEvents[
                                $photoEventTypes->firstWhere('photo_event_type_name', $photoEventTypeEnum::EVALUASI)
                                    ?->id_photo_event_type
                            ] ?? null,
                        );
                    @endphp
                    <a href="{{ route('photo.event.type', ['photoEventType' => $photoEventTypes->firstWhere('photo_event_type_name', $photoEventTypeEnum::EVALUASI)]) }}"
                        class="flex flex-col items-center {{ $evaluasi == null ? 'justify-center' : '' }} mx-4 ">
                        <p class="text-white text-xl font-bold mb-2">Evaluasi</p>
                        <div class="bg-[#e4e6d9] flex flex-col w-80 h-50 items-center justify-center">
                            <i style="font-size:36px;" class="fa-solid fa-plus"></i>
                            <P class="text-xl text-black font-bold">Upload Foto</P>
                        </div>
                        <div class="grid grid-cols-2 gap-4 w-90 px-4 mt-4">
                            @if ($evaluasi->photo_event_location)
                                <div class="flex items-center gap-2 min-w-0">
                                    <i class="fa-solid fa-location-dot text-2xl mt-2 text-white flex-shrink-0"></i>
                                    <span class="truncate text-white block min-w-0 ml-2"
                                        style="white-space: nowrap;">{{ $evaluasi->photo_event_location }}</span>
                                </div>
                            @endif
                            @if ($evaluasi->photo_event_date)
                                <div class="flex items-center gap-2 min-w-0">
                                    <i class="fa-solid fa-calendar-days text-2xl text-white flex-shrink-0"></i>
                                    <span class="truncate text-white block min-w-0 ml-2"
                                        style="white-space: nowrap;">{{ $evaluasi->photo_event_date }}</span>
                                </div>
                            @endif
                            @if ($evaluasi->photo_event_caption)
                                <div class="col-span-2 flex items-center gap-2 min-w-0">
                                    <i class="fa-solid fa-comment text-2xl mt-2 text-white flex-shrink-0"></i>
                                    <span class="truncate text-white block min-w-0 ml-2"
                                        style="white-space: nowrap;">{{ $evaluasi->photo_event_caption }}</span>
                                </div>
                            @endif
                        </div>
                    </a>
                </div>
            </div>
        </div>
</body>

</html>

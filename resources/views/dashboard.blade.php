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
        <!-- Form Input -->
        <form action="{{ route('data.store') }}" method="POST" class="w-full">
            @csrf
            <a href="{{ route('input.select') }}"
                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mb-4 inline-block">
                Tambahkan Data
            </a>

            <div class="bg-green-800 p-6 rounded-lg shadow-md overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300 text-center text-black">
                    <thead>
                        <tr style="background-color: #E4E0E1;">
                            <th class="border border-gray-300 px-2 py-2">Nama Supervisor</th>
                            <th class="border border-gray-300 px-2 py-2">Target DO</th>
                            <th class="border border-gray-300 px-2 py-2">Act DO</th>
                            <th class="border border-gray-300 px-2 py-2">GAP</th>
                            <th class="border border-gray-300 px-2 py-2">Ach (%)</th>
                            <th class="border border-gray-300 px-2 py-2">Target SPK</th>
                            <th class="border border-gray-300 px-2 py-2">ACT SPK</th>
                            <th class="border border-gray-300 px-2 py-2">GAP</th>
                            <th class="border border-gray-300 px-2 py-2">Ach (%)</th>
                            <th class="border border-gray-300 px-2 py-2">Status</th>
                            <th class="border border-gray-300 px-2 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white text-black">
                            <td class="border border-gray-300 px-2 py-1">
                                <input type="text" name="nama_supervisor" class="w-full border border-gray-300 p-1">
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <input type="number" name="target_do" class="w-full border border-gray-300 p-1">
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <input type="number" name="act_do" class="w-full border border-gray-300 p-1">
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <input type="number" name="gap" class="w-full border border-gray-300 p-1">
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <input type="number" name="ach" class="w-full border border-gray-300 p-1">
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <input type="number" name="target_spk" class="w-full border border-gray-300 p-1">
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <input type="number" name="act_spk" class="w-full border border-gray-300 p-1">
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <input type="number" name="gap_spk" class="w-full border border-gray-300 p-1">
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <input type="number" name="ach_spk" class="w-full border border-gray-300 p-1">
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <input type="text" name="status" class="w-full border border-gray-300 p-1">
                            </td>
                            <td class="border border-gray-300 px-2 py-1 flex justify-center space-x-1">
                                <button type="submit"
                                    class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                    Tambah
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Data yang sudah tersimpan -->
        <div class="bg-green-800 p-6 rounded-lg shadow-md overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 text-center text-black">
                <thead>
                    <tr style="background-color: #E4E0E1;">
                        <th class="border border-2 border-black px-2 py-2">Nama Supervisor</th>
                        <th class="border border-2 border-black px-2 py-2">Target DO</th>
                        <th class="border border-2 border-black px-2 py-2">Act DO</th>
                        <th class="border border-2 border-black px-2 py-2">GAP</th>
                        <th class="border border-2 border-black px-2 py-2">Ach (%)</th>
                        <th class="border border-2 border-black px-2 py-2">Target SPK</th>
                        <th class="border border-2 border-black px-2 py-2">ACT SPK</th>
                        <th class="border border-2 border-black px-2 py-2">GAP</th>
                        <th class="border border-2 border-black px-2 py-2">Ach (%)</th>
                        <th class="border border-2 border-black px-2 py-2">Status</th>
                        <th class="border border-2 border-black px-2 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr class="bg-transparent  border-2 border-black text-white text-l">
                            <td class=" border-2 border-black w-20">
                                {{ $item->nama_supervisor }}
                            </td>
                            <td class="border-2 border-black w-20">
                                {{ $item->target_do }}
                            </td>
                            <td class="border-2 border-black w-20">
                                {{ $item->act_do }}
                            </td>
                            <td class="border-2 border-black w-20">
                                {{ $item->gap }}
                            </td>
                            <td class="border-2 border-black w-20">
                                {{ $item->ach }}
                            </td>
                            <td class="border-2 border-black w-20">
                                {{ $item->target_spk }}
                            </td>
                            <td class="border-2 border-black w-20">
                                {{ $item->act_spk }}
                            </td>
                            <td class="border-2 border-black w-20">
                                {{ $item->gap_spk }}
                            </td>
                            <td class="border-2 border-black w-20">
                                {{ $item->ach_spk }}
                            </td>
                            <td class="border-2 border-black w-20">
                                {{ $item->status }}
                            </td>
                            <td class="border-2 border-black w-36">
                                <div class="flex justify-center space-x-1">

                                    <a href="{{ route('data.edit', $item->id) }}"
                                        class="bg-[#d9d9d9] font-bold text-black px-3 py-1 my-1 rounded hover:bg-green-600"
                                        style="font-size: 12px;">
                                        Edit
                                        <i class=" fa-solid fa-pencil"></i>
                                    </a>
                                    <form action="{{ route('data.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda Yakin?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-[#d9d9d9] font-bold text-black px-4 py-1 my-1 rounded hover:bg-red-600"
                                            style="font-size: 12px;">
                                            Delete
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
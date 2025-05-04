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
                <tbody id="supervisor-table-body">
                    @foreach ($dataSupervisors as $supervisor)
                    <tr class="data-row">
                        <td class="w-20 ml-4 text-xl text-white border-2 border-black">
                            <div class="m-2 text-white bg-transparent rounded-md">
                                <input type="text"
                                    class="w-full px-1 text-center bg-transparent paste-input" value="{{ $supervisor->supervisor_name }}"
                                    readonly>
                                <input type="hidden" name="id_supervisor" value="{{ $supervisor->id_supervisor }}">
                                <input type="hidden" name="id_monitoring_do_spk" value="{{ $supervisor->id_monitoring_do_spk }}">
                            </div>
                        </td>
                        <td class="w-20 ml-4 text-xl text-white border-2 border-black">
                            <div class="m-2 text-white bg-transparent rounded-md">
                                <input type="number" name="target_spk" oninput="(calculateGapAndAch(this))"
                                    class="w-full px-1 text-center bg-transparent paste-input" value="{{ $supervisor->target_spk }}">
                            </div>
                        </td>
                        <td class="w-20 ml-4 text-xl text-white border-2 border-black">
                            <div class="m-2 text-white bg-transparent rounded-md">
                                <input type="number" name="act_spk" oninput="(calculateGapAndAch(this))"
                                    class="w-full px-1 text-center bg-transparent paste-input" value="{{ $supervisor->act_spk }}">
                            </div>
                        </td>
                        <td class="w-20 ml-4 text-xl text-white border-2 border-black">
                            <div class="m-2 text-white bg-transparent rounded-md">
                                <input type="text" name="gap_spk"
                                    class="w-full px-1 text-center bg-transparent paste-input" readonly value="{{ $supervisor->gap_spk ?? '' }}">
                            </div>
                        </td>
                        <td class="w-20 ml-4 text-xl text-white border-2 border-black">
                            <div class="m-2 text-white bg-transparent rounded-md">
                                <input type="text" name="ach_spk"
                                    class="w-full px-1 text-center bg-transparent paste-input" readonly value="{{ $supervisor->ach_spk ?? '' }}">
                            </div>
                        </td>
                    </tr>
                    @endforeach
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
        const tr = e.closest('tr');
        const targetSpk = parseFloat(tr.querySelector('input[name="target_spk"]')?.value) || null;
        const actSpk = parseFloat(tr.querySelector('input[name="act_spk"]')?.value) || null;
        const gapSpk = actSpk - targetSpk;
        const achSpk = (targetSpk > 0) ? (actSpk / targetSpk) * 100 : 0;
        tr.querySelector('input[name="gap_spk"]').value = Math.round(gapSpk);
        tr.querySelector('input[name="ach_spk"]').value = Math.round(achSpk) + "%";
        if (targetSpk == null && actSpk == null) {
            tr.querySelector('input[name="gap_spk"]').value = "";
            tr.querySelector('input[name="ach_spk"]').value = "";
        }
    }

    function renderSupervisorRows(supervisors) {
        let html = '';
        supervisors.forEach(function(s) {
            html += `
            <tr class="data-row">
                <td class="w-20 ml-4 text-xl text-white border-2 border-black">
                    <div class="m-2 text-white bg-transparent rounded-md">
                        <input type="text"
                            class="w-full px-1 text-center bg-transparent paste-input" value="${s.supervisor_name}"
                            readonly>
                        <input type="hidden" name="id_supervisor" value="${s.id_supervisor}">
                        <input type="hidden" name="id_monitoring_do_spk" value="${s.id_monitoring_do_spk ?? ''}">
                    </div>
                </td>
                <td class="w-20 ml-4 text-xl text-white border-2 border-black">
                    <div class="m-2 text-white bg-transparent rounded-md">
                        <input type="number" name="target_spk" oninput="(calculateGapAndAch(this))"
                            class="w-full px-1 text-center bg-transparent paste-input" value="${s.target_spk ?? ''}">
                    </div>
                </td>
                <td class="w-20 ml-4 text-xl text-white border-2 border-black">
                    <div class="m-2 text-white bg-transparent rounded-md">
                        <input type="number" name="act_spk" oninput="(calculateGapAndAch(this))"
                            class="w-full px-1 text-center bg-transparent paste-input" value="${s.act_spk ?? ''}">
                    </div>
                </td>
                <td class="w-20 ml-4 text-xl text-white border-2 border-black">
                    <div class="m-2 text-white bg-transparent rounded-md">
                        <input type="text" name="gap_spk"
                            class="w-full px-1 text-center bg-transparent paste-input" readonly value="${s.gap_spk ?? ''}">
                    </div>
                </td>
                <td class="w-20 ml-4 text-xl text-white border-2 border-black">
                    <div class="m-2 text-white bg-transparent rounded-md">
                        <input type="text" name="ach_spk"
                            class="w-full px-1 text-center bg-transparent paste-input" readonly value="${s.ach_spk ?? ''}">
                    </div>
                </td>
            </tr>
            `;
        });
        $('#supervisor-table-body').html(html);
    }

    document.addEventListener("DOMContentLoaded", function() {
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
            $(this).prop('disabled', true);
            $(this).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
            const data = [];
            document.querySelectorAll(".data-row").forEach((row) => {
                const dataRow = {
                    id_supervisor: row.querySelector('input[name="id_supervisor"]')?.value || '',
                    id_monitoring_do_spk: row.querySelector('input[name="id_monitoring_do_spk"]')?.value || '',
                    target_spk: row.querySelector('input[name="target_spk"]')?.value || null,
                    act_spk: row.querySelector('input[name="act_spk"]')?.value || null,
                };
                data.push(dataRow);
            });

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
                            if(data.errors) {
                                throw new Error(Object.values(data.errors).flat().join('\n'));
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
                });
        });

        $('#date').on('change', function() {
            let date = $(this).val();
            $('#supervisor-table-body').html(`
                <tr>
                    <td colspan="5" class="text-center text-white">
                        <i class="fa fa-spinner fa-spin"></i> Loading...
                    </td>
                </tr>
            `);
            $.get("{{ route('inputSPK') }}", { date: date, ajax: 1 }, function(res) {
                renderSupervisorRows(res.dataSupervisors);
            });
        });
    });
</script>
</html>

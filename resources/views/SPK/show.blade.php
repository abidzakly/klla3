<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/css/app.css')
    <style>
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .tab-button.active {
            background-color: #059669;
            color: white;
        }
    </style>
</head>

<body style="background-image: url('{{ asset('image/background.png') }}');"
    class="bg-cover bg-center flex flex-col items-center min-h-screen">
    <nav class="bg-green-900 text-white w-full px-6 py-4 flex items-center shadow-md relative">
        <img src="{{ asset('image/logooo 1.png') }}" alt="Logo" class="absolute left-6">
        <h1 class="text-xl font-bold mx-auto text-center" style="font-size: 36px;">Report Big Event</h1>
    </nav>

    <div class="flex w-[90%] justify-center mt-6">
        <div class="relative w-full flex flex-col rounded-lg shadow-md items-center justify-center group p-6 mb-4">
            <div class="w-full min-h-[80vh] h-full absolute inset-0 bg-green-800 rounded-lg"></div>

            <div class="relative mt-3 w-full flex items-center px-6 font-bold text-white z-20">
                <a href="{{ route('spk.index') }}"><i style="font-size: 30px;"
                        class="fa-solid fa-arrow-left text-2xl ml-2"></i></a>

                <div class="absolute left-1/2 -translate-x-1/2 text-xl flex items-center gap-4">
                    <p style="font-size: 30px;">Detail SPK - {{ $spk->nomor_spk }}</p>
                </div>

                <div class="ml-auto">
                    <a href="{{ route('spk.edit', $spk->id_spk) }}" 
                       class="inline-block px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600 mr-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>

            <div class="relative flex justify-center items-center flex-col w-full">
                <!-- Tab Navigation -->
                <div class="flex justify-between w-full mt-8 mb-6">
                    <button class="tab-button active flex-1 mx-2 py-3 text-center rounded-lg font-bold bg-gray-500 text-white" 
                            onclick="showTab('customer')" data-tab="customer">
                        <div class="text-sm">Tab 1</div>
                        <div>Customer Info</div>
                    </button>
                    <button class="tab-button flex-1 mx-2 py-3 text-center rounded-lg font-bold bg-gray-500 text-white" 
                            onclick="showTab('vehicle')" data-tab="vehicle">
                        <div class="text-sm">Tab 2</div>
                        <div>Vehicle Details</div>
                    </button>
                    <button class="tab-button flex-1 mx-2 py-3 text-center rounded-lg font-bold bg-gray-500 text-white" 
                            onclick="showTab('transaction')" data-tab="transaction">
                        <div class="text-sm">Tab 3</div>
                        <div>Transaksi & Pembayaran</div>
                    </button>
                    <button class="tab-button flex-1 mx-2 py-3 text-center rounded-lg font-bold bg-gray-500 text-white" 
                            onclick="showTab('internal')" data-tab="internal">
                        <div class="text-sm">Tab 4</div>
                        <div>Internal Info</div>
                    </button>
                    <button class="tab-button flex-1 mx-2 py-3 text-center rounded-lg font-bold bg-gray-500 text-white" 
                            onclick="showTab('process')" data-tab="process">
                        <div class="text-sm">Tab 5</div>
                        <div>Proses & Tanggal</div>
                    </button>
                </div>

                <!-- Tab 1: Customer Info -->
                <div class="tab-content active w-full" id="tab-customer">
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h3 class="text-xl font-bold text-black mb-4">Customer Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-black font-bold mb-2">Customer Name 1</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->customer_name_1 }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Customer Name 2</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->customer_name_2 ?? '-' }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Buyer Status</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->buyer_status ?? '-' }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Religion</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->religion ?? '-' }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Province</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->province ?? '-' }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">City</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->city ?? '-' }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">District</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->district ?? '-' }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Sub District</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->sub_district ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Vehicle Details -->
                <div class="tab-content w-full" id="tab-vehicle">
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h3 class="text-xl font-bold text-black mb-4">Vehicle Details</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-black font-bold mb-2">Model</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->model }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Type</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->type }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Color</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->color }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Color Code</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->color_code }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Fleet</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->fleet }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Customer Type</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->customer_type }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Transaction -->
                <div class="tab-content w-full" id="tab-transaction">
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h3 class="text-xl font-bold text-black mb-4">Transaksi & Pembayaran</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-black font-bold mb-2">Nomor SPK</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->nomor_spk }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">SPK Status</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->spk_status }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Leasing</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->leasing ?? '-' }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Status</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->status }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Payment Method</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->payment_method }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Total Payment</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">Rp {{ number_format($spk->total_payment, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 4: Internal -->
                <div class="tab-content w-full" id="tab-internal">
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h3 class="text-xl font-bold text-black mb-4">Internal Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-black font-bold mb-2">Branch ID Text</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->branch_id_text }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Branch</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->branch }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Sales</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->sales }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Supervisor</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->supervisor ?? '-' }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Type ID</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->type_id }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Custom Type</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->custom_type ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 5: Process -->
                <div class="tab-content w-full" id="tab-process">
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h3 class="text-xl font-bold text-black mb-4">Proses & Tanggal</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-black font-bold mb-2">Valid Date</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->valid_date ? $spk->valid_date->format('d/m/Y') : '-' }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Valid</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">
                                    <span class="px-2 py-1 rounded {{ $spk->valid ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $spk->valid ? 'Ya' : 'Tidak' }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">PO Number</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->po_number ?? '-' }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">PO Date</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->po_date ? $spk->po_date->format('d/m/Y') : '-' }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Date If Credit Agreement</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->date_if_credit_agreement ? $spk->date_if_credit_agreement->format('d/m/Y') : '-' }}</div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Date SPK</label>
                                <div class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-black">{{ $spk->date_spk ? $spk->date_spk->format('d/m/Y') : '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });

            // Remove active class from all tab buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active');
            });

            // Show selected tab content
            document.getElementById(`tab-${tabName}`).classList.add('active');

            // Add active class to clicked tab button
            document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
        }
    </script>
</body>

</html>

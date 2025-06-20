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
        .step {
            transition: all 0.3s ease;
        }

        .step.active {
            background-color: #059669;
            color: white;
        }

        .step.completed {
            background-color: #10b981;
            color: white;
        }

        .step.locked {
            background-color: #9ca3af;
            color: #6b7280;
            cursor: not-allowed;
        }

        .step-content {
            display: none;
        }

        .step-content.active {
            display: block;
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: #dc3545;
        }

        .is-invalid {
            border-color: #dc3545 !important;
            background-color: #fef2f2 !important;
        }

        .is-valid {
            border-color: #10b981 !important;
            background-color: #f0fdf4 !important;
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
                <a href="{{ route('spk.index') }}">
                    <i style="font-size: 30px;" class="fa-solid fa-arrow-left text-2xl ml-2"></i>
                </a>


                <div class="absolute left-1/2 -translate-x-1/2 text-xl flex items-center gap-4">
                    <p style="font-size: 30px;">Edit SPK - {{ $spk->nomor_spk }}</p>
                </div>
            </div>

            <div class="relative flex justify-center items-center flex-col w-full">
                <!-- Stepper Navigation -->
                <div class="flex justify-between w-full mt-8 mb-6">
                    <div class="step active flex-1 mx-2 py-3 text-center rounded-lg font-bold cursor-pointer"
                        data-step="1">
                        <div class="text-sm">Step 1</div>
                        <div>Customer Info</div>
                    </div>
                    <div class="step locked flex-1 mx-2 py-3 text-center rounded-lg font-bold cursor-not-allowed"
                        data-step="2">
                        <div class="text-sm">Step 2</div>
                        <div>Vehicle Details</div>
                    </div>
                    <div class="step locked flex-1 mx-2 py-3 text-center rounded-lg font-bold cursor-not-allowed"
                        data-step="3">
                        <div class="text-sm">Step 3</div>
                        <div>Transaksi & Pembayaran</div>
                    </div>
                    <div class="step locked flex-1 mx-2 py-3 text-center rounded-lg font-bold cursor-not-allowed"
                        data-step="4">
                        <div class="text-sm">Step 4</div>
                        <div>Internal Info</div>
                    </div>
                    <div class="step locked flex-1 mx-2 py-3 text-center rounded-lg font-bold cursor-not-allowed"
                        data-step="5">
                        <div class="text-sm">Step 5</div>
                        <div>Proses & Tanggal</div>
                    </div>
                </div>

                <!-- Step 1: Customer Info -->
                <div class="step-content active w-full" id="step-1">
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h3 class="text-xl font-bold text-black mb-4">Customer Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-black font-bold mb-2">Customer Name 1 *</label>
                                <input type="text" name="customer_name_1" value="{{ $spk->customer_name_1 }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black" required>
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Customer Name 2</label>
                                <input type="text" name="customer_name_2" value="{{ $spk->customer_name_2 }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black">
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Buyer Status</label>
                                <input type="text" name="buyer_status" value="{{ $spk->buyer_status }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black">
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Religion</label>
                                <input type="text" name="religion" value="{{ $spk->religion }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black">
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Province</label>
                                <input type="text" name="province" value="{{ $spk->province }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black">
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">City</label>
                                <input type="text" name="city" value="{{ $spk->city }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black">
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">District</label>
                                <input type="text" name="district" value="{{ $spk->district }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black">
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Sub District</label>
                                <input type="text" name="sub_district" value="{{ $spk->sub_district }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black">
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Vehicle Details -->
                <div class="step-content w-full" id="step-2">
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h3 class="text-xl font-bold text-black mb-4">Vehicle Details</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-black font-bold mb-2">Model *</label>
                                <input type="text" name="model" value="{{ $spk->model }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black" required>
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Type *</label>
                                <input type="text" name="type" value="{{ $spk->type }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black" required>
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Color *</label>
                                <input type="text" name="color" value="{{ $spk->color }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black" required>
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Color Code *</label>
                                <input type="text" name="color_code" value="{{ $spk->color_code }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black" required>
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Fleet *</label>
                                <input type="text" name="fleet" value="{{ $spk->fleet }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black" required>
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Customer Type *</label>
                                <input type="text" name="customer_type" value="{{ $spk->customer_type }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black" required>
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Transaksi & Pembayaran -->
                <div class="step-content w-full" id="step-3">
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h3 class="text-xl font-bold text-black mb-4">Transaksi & Pembayaran</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-black font-bold mb-2">Nomor SPK *</label>
                                <input type="text" name="nomor_spk" value="{{ $spk->nomor_spk }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black" required>
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">SPK Status *</label>
                                <input type="text" name="spk_status" value="{{ $spk->spk_status }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black" required>
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Leasing</label>
                                <input type="text" name="leasing" value="{{ $spk->leasing }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black">
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Status *</label>
                                <input type="text" name="status" value="{{ $spk->status }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black" required>
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Payment Method *</label>
                                <input type="text" name="payment_method" value="{{ $spk->payment_method }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black" required>
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Total Payment *</label>
                                <input type="number" step="0.01" name="total_payment"
                                    value="{{ $spk->total_payment }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black" required>
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Internal Info -->
                <div class="step-content w-full" id="step-4">
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h3 class="text-xl font-bold text-black mb-4">Internal Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-black font-bold mb-2">Branch ID Text *</label>
                                <input type="text" name="branch_id_text" value="{{ $spk->branch_id_text }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black" required>
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Branch *</label>
                                <input type="text" name="branch" value="{{ $spk->branch }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black" required>
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Sales *</label>
                                <input type="text" name="sales" value="{{ $spk->sales }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black" required>
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Supervisor</label>
                                <input type="text" name="supervisor" value="{{ $spk->supervisor }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black">
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Type ID *</label>
                                <input type="text" name="type_id" value="{{ $spk->type_id }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black" required>
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Custom Type</label>
                                <input type="text" name="custom_type" value="{{ $spk->custom_type }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black">
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 5: Proses & Tanggal -->
                <div class="step-content w-full" id="step-5">
                    <div class="bg-gray-100 rounded-lg p-6">
                        <h3 class="text-xl font-bold text-black mb-4">Proses & Tanggal</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-black font-bold mb-2">Valid Date *</label>
                                <input type="date" name="valid_date"
                                    value="{{ $spk->valid_date ? $spk->valid_date->format('Y-m-d') : '' }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black" required>
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div class="flex items-center flex-col">
                                <label class="block text-black font-bold mb-2">Valid *</label>
                                <input type="checkbox" name="valid" {{ $spk->valid ? 'checked' : '' }}
                                    class="w-6 h-6">
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">PO Number</label>
                                <input type="text" name="po_number" value="{{ $spk->po_number }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black">
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">PO Date</label>
                                <input type="date" name="po_date"
                                    value="{{ $spk->po_date ? $spk->po_date->format('Y-m-d') : '' }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black">
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Date If Credit Agreement</label>
                                <input type="date" name="date_if_credit_agreement"
                                    value="{{ $spk->date_if_credit_agreement ? $spk->date_if_credit_agreement->format('Y-m-d') : '' }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black">
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                            <div>
                                <label class="block text-black font-bold mb-2">Date SPK *</label>
                                <input type="date" name="date_spk"
                                    value="{{ $spk->date_spk ? $spk->date_spk->format('Y-m-d') : '' }}"
                                    class="w-full px-3 py-2 border rounded-lg text-black" required>
                                <div class="invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between w-full mt-6">
                    <button id="prev-button"
                        class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-all duration-300"
                        style="display: none;">
                        Previous
                    </button>
                    <button id="next-button"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-all duration-300 ml-auto">
                        Next
                    </button>
                    <button id="submit-button"
                        class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-all duration-300 ml-auto"
                        style="display: none;">
                        Update
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        let currentStep = 1;
        let completedSteps = [];
        const maxSteps = 5;

        document.addEventListener("DOMContentLoaded", function() {
            // Initialize CSRF token for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Initialize stepper
            updateStepDisplay();

            // Next button
            document.getElementById('next-button').addEventListener('click', function() {
                validateAndProceed();
            });

            // Previous button
            document.getElementById('prev-button').addEventListener('click', function() {
                if (currentStep > 1) {
                    currentStep--;
                    updateStepDisplay();
                }
            });

            // Step click navigation - only allow if step is completed
            document.querySelectorAll('.step').forEach(step => {
                step.addEventListener('click', function() {
                    const stepNumber = parseInt(this.dataset.step);

                    // Only allow navigation to completed steps or current step
                    if (completedSteps.includes(stepNumber) || stepNumber === currentStep) {
                        currentStep = stepNumber;
                        updateStepDisplay();
                    }
                });
            });

            // Submit button
            document.getElementById('submit-button').addEventListener('click', function() {
                validateAndSubmit();
            });

            // Add input event listeners to clear validation errors when user starts typing
            document.querySelectorAll('input').forEach(input => {
                input.addEventListener('input', function() {
                    clearFieldError(this);
                });

                input.addEventListener('change', function() {
                    clearFieldError(this);
                });
            });
        });

        // ...existing clearFieldError function...

        // ...existing updateStepDisplay function...

        function collectStepData(stepNumber) {
            const stepElement = document.getElementById(`step-${stepNumber}`);
            const formData = {};

            stepElement.querySelectorAll('input[name]').forEach(input => {
                if (input.type === 'checkbox') {
                    // Convert checkbox value to integer (0 or 1)
                    formData[input.name] = input.checked ? 1 : 0;
                } else {
                    formData[input.name] = input.value || '';
                }
            });

            return formData;
        }

        // ...existing clearValidationErrors function...

        // ...existing showValidationErrors function...

        function validateAndProceed() {
            const button = document.getElementById('next-button');
            button.disabled = true;
            button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Validating...';

            clearValidationErrors();

            const stepData = collectStepData(currentStep);

            console.log('Step data being validated:', stepData);
            console.log('Current step:', currentStep);

            $.ajax({
                url: "{{ route('spk.update', $spk->id_spk) }}",
                method: "PUT",
                dataType: 'json',
                data: {
                    validate_step: true,
                    step: currentStep,
                    data: stepData,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    console.log('Validation success response:', data);

                    if (data.error) {
                        if (data.errors) {
                            console.log('Showing validation errors...');
                            showValidationErrors(data.errors);

                            let errorMessages = [];
                            Object.keys(data.errors).forEach(field => {
                                const fieldErrors = Array.isArray(data.errors[field]) ? data.errors[
                                    field] : [data.errors[field]];
                                fieldErrors.forEach(error => {
                                    errorMessages.push(`• ${error}`);
                                });
                            });

                            Swal.fire({
                                icon: "error",
                                title: 'Validasi Gagal',
                                html: errorMessages.join('<br>'),
                                timer: 5000,
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: 'Error',
                                text: data.message || 'Terjadi kesalahan validasi.',
                                timer: 3000,
                            });
                        }
                    } else {
                        // Mark current step as completed
                        if (!completedSteps.includes(currentStep)) {
                            completedSteps.push(currentStep);
                        }

                        // Move to next step
                        if (currentStep < maxSteps) {
                            currentStep++;
                            updateStepDisplay();
                        }

                        // Only show success alert if ignore_alert is not true
                        if (!data.data || !data.data.ignore_alert) {
                            Swal.fire({
                                icon: "success",
                                title: 'Validasi berhasil!',
                                timer: 1000,
                                showConfirmButton: false
                            });
                        }
                    }
                },
                error: function(xhr, status, error) {
                    // ...existing error handling...
                },
                complete: function() {
                    button.disabled = false;
                    button.innerHTML = 'Next';
                }
            });
        }

        function validateAndSubmit() {
            const button = document.getElementById('submit-button');
            button.disabled = true;
            button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Validating...';

            clearValidationErrors();

            const stepData = collectStepData(currentStep);

            // First validate the final step
            $.ajax({
                url: "{{ route('spk.update', $spk->id_spk) }}",
                method: "PUT",
                dataType: 'json',
                data: {
                    validate_step: true,
                    step: currentStep,
                    data: stepData,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    console.log('Final validation response:', data);

                    if (data.error) {
                        // ...existing error handling...
                        button.disabled = false;
                        button.innerHTML = 'Update';
                    } else {
                        // If validation passes, submit the form
                        submitForm();
                    }
                },
                error: function(xhr, status, error) {
                    // ...existing error handling...
                    button.disabled = false;
                    button.innerHTML = 'Update';
                }
            });
        }

        function submitForm() {
            const button = document.getElementById('submit-button');
            button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Updating...';

            // Collect all form data from all steps
            const allFormData = {};
            for (let i = 1; i <= maxSteps; i++) {
                const stepData = collectStepData(i);
                Object.assign(allFormData, stepData);
            }

            console.log('Final form data being submitted:', allFormData);

            $.ajax({
                url: "{{ route('spk.update', $spk->id_spk) }}",
                method: "PUT",
                dataType: 'json',
                data: {
                    ...allFormData,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    console.log('Submit success response:', data);

                    if (data.error) {
                        let errorMessages = [];
                        if (data.errors) {
                            Object.keys(data.errors).forEach(field => {
                                const fieldErrors = Array.isArray(data.errors[field]) ? data.errors[
                                    field] : [data.errors[field]];
                                fieldErrors.forEach(error => {
                                    errorMessages.push(`• ${error}`);
                                });
                            });
                        }

                        Swal.fire({
                            icon: "error",
                            title: 'Error',
                            html: errorMessages.length > 0 ? errorMessages.join('<br>') : data.message,
                            timer: 5000,
                        });
                    } else {
                        Swal.fire({
                            icon: "success",
                            title: 'Data SPK berhasil diperbarui!',
                            timer: 1500,
                        }).then(() => {
                            window.location.href = "{{ route('spk.index') }}";
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // ...existing error handling...
                },
                complete: function() {
                    button.disabled = false;
                    button.innerHTML = 'Update';
                }
            });
        }

        // Copy functions from create.blade.php
        function clearFieldError(input) {
            const feedback = input.parentElement.querySelector('.invalid-feedback');
            if (input.classList.contains('is-invalid')) {
                input.classList.remove('is-invalid');
                if (feedback) {
                    feedback.style.display = 'none';
                    feedback.textContent = '';
                }

                if (input.value.trim() !== '') {
                    input.classList.add('is-valid');
                }
            }

            if (!input.classList.contains('is-invalid') && input.value.trim() !== '') {
                input.classList.add('is-valid');
            } else if (input.value.trim() === '') {
                input.classList.remove('is-valid');
            }
        }

        function updateStepDisplay() {
            // Update step indicators
            document.querySelectorAll('.step').forEach((step, index) => {
                const stepNumber = index + 1;
                step.classList.remove('active', 'completed', 'locked', 'bg-gray-300', 'text-black');

                if (completedSteps.includes(stepNumber)) {
                    step.classList.add('completed');
                    step.style.cursor = 'pointer';
                } else if (stepNumber === currentStep) {
                    step.classList.add('active');
                    step.style.cursor = 'pointer';
                } else {
                    step.classList.add('locked');
                    step.style.cursor = 'not-allowed';
                }
            });

            // Update step content
            document.querySelectorAll('.step-content').forEach((content, index) => {
                content.classList.remove('active');
                if (index + 1 === currentStep) {
                    content.classList.add('active');
                }
            });

            // Update navigation buttons
            const prevButton = document.getElementById('prev-button');
            const nextButton = document.getElementById('next-button');
            const submitButton = document.getElementById('submit-button');

            prevButton.style.display = currentStep > 1 ? 'block' : 'none';

            if (currentStep === maxSteps) {
                nextButton.style.display = 'none';
                submitButton.style.display = 'block';
            } else {
                nextButton.style.display = 'block';
                submitButton.style.display = 'none';
            }
        }

        function clearValidationErrors() {
            const currentStepElement = document.getElementById(`step-${currentStep}`);
            currentStepElement.querySelectorAll('.is-invalid').forEach(input => {
                input.classList.remove('is-invalid');
            });
            currentStepElement.querySelectorAll('.is-valid').forEach(input => {
                input.classList.remove('is-valid');
            });
            currentStepElement.querySelectorAll('.invalid-feedback').forEach(feedback => {
                feedback.style.display = 'none';
                feedback.textContent = '';
            });
        }

        function showValidationErrors(errors) {
            clearValidationErrors();

            const currentStepElement = document.getElementById(`step-${currentStep}`);

            console.log('Showing errors for step:', currentStep);
            console.log('Errors received:', errors);

            Object.keys(errors).forEach(fieldName => {
                console.log('Processing error for field:', fieldName);

                const input = currentStepElement.querySelector(`input[name="${fieldName}"]`);
                console.log('Found input element:', input);

                if (input) {
                    const feedback = input.parentElement.querySelector('.invalid-feedback');
                    console.log('Found feedback element:', feedback);

                    if (feedback) {
                        input.classList.remove('is-valid');
                        input.classList.add('is-invalid');

                        const errorMessage = Array.isArray(errors[fieldName]) ? errors[fieldName][0] : errors[
                            fieldName];
                        feedback.textContent = errorMessage;
                        feedback.style.display = 'block';

                        console.log(`Set error for ${fieldName}: ${errorMessage}`);

                        // Scroll to first error
                        if (Object.keys(errors)[0] === fieldName) {
                            input.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }
                    } else {
                        console.log('No feedback element found for:', fieldName);
                    }
                } else {
                    console.log('No input element found for:', fieldName);
                }
            });
        }
    </script>
</body>

</html>

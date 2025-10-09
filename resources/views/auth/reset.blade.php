<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        html {
            overflow-y: scroll;
        }

        body {
            overflow-x: hidden;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #6b7280;
            padding: 4px;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .password-toggle:hover {
            background-color: #f3f4f6;
            color: #4b5563;
        }

        .input-field {
            transition: all 0.2s ease;
            padding-right: 2.5rem;
        }

        .input-field:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }

        .main-container {
            min-height: 100vh;
            display: flex;
            width: 100%;
        }

        .swal2-popup {
            border-radius: 12px !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2) !important;
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="main-container">
        <div class="w-full lg:w-1/2 flex items-center justify-center bg-white px-6 lg:px-20">
            <div class="w-full max-w-md">

                <h2 class="text-3xl font-bold text-gray-900 mb-2">Reset Your Password</h2>
                <p class="text-sm text-gray-600 mb-6">
                    Enter your new password below and confirm it to update your account password.
                </p>

                <form action="{{ route('guest.password.update') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">

                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                            New Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password" placeholder="Enter new password"
                                class="input-field mt-1 block w-full rounded-lg border border-gray-300 bg-gray-50 py-2.5 px-3.5 shadow-sm focus:outline-none focus:ring-1 sm:text-sm"
                                required>
                            <button type="button" onclick="togglePassword('password')" class="password-toggle">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="Confirm new password"
                                class="input-field mt-1 block w-full rounded-lg border border-gray-300 bg-gray-50 py-2.5 px-3.5 shadow-sm focus:outline-none focus:ring-1 sm:text-sm"
                                required>
                            <button type="button" onclick="togglePassword('password_confirmation')"
                                class="password-toggle">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg shadow-md transition-colors">
                        Reset Password
                    </button>
                </form>
            </div>
        </div>

        <div class="hidden lg:flex w-1/2 relative">
            <img src="{{ asset('/images/background.png') }}" alt="Background"
                class="absolute inset-0 w-full h-full object-cover">
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === "password" ? "text" : "password";
        }

        // SweetAlert for both success and error messages
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Swal.fire({ icon: 'success', title: 'Success!', text: '{{ session('success') }}', timer: 3000, showConfirmButton: false });
            @endif

            @if(session('error'))
                Swal.fire({ icon: 'error', title: 'Oops...', text: '{{ session('error') }}', timer: 3000, showConfirmButton: false });
            @endif
});
    </script>
</body>

</html>

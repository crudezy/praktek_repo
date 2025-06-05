<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laundry Telkom - Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

  <div class="flex h-screen">
    <!-- Left Section -->
    <div class="flex-[3] relative bg-cover bg-center text-white"
      style="background-image: url('{{ asset('images/login.jpg') }}');">
      <!-- Overlay Gelap -->
      <div class="absolute inset-0 bg-black bg-opacity-50"></div>

      <!-- Tulisan di Kiri Atas -->
      <div class="absolute top-6 left-6">
        <div class="text-4xl font-bold text-blue-500">
          KitaLaundry.
        </div>
        <p class="text-sm text-gray-300 mt-1">
          Dapatkan produktivitas yang tinggi <br> melalui otomatisasi dan hemat banyak waktu!
        </p>
      </div>

      <!-- Tulisan di Kiri Bawah -->
      <div class="absolute bottom-6 left-6">
        <p class="text-sm text-gray-300">© 2025 Laundry Telkom. All rights reserved.</p>
      </div>
    </div>

    <!-- Right Section -->
    <div class="flex-[2] bg-white flex flex-col justify-center items-center p-8">
      <div class="w-full max-w-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Welcome Back!</h2>
        <p class="text-sm text-gray-600 mb-6">
          Belum punya akun? <a href="#" class="text-blue-600 font-medium">Buat akun baru sekarang</a>, Hanya butuh kurang dari satu menit!
        </p>
        <form method="POST" action="{{ url('/login') }}" class="space-y-4">
          @csrf
          <!-- Email Input -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" placeholder="you@example.com" required
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
          </div>

          <!-- Password Input -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required
              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
          </div>

          <!-- Remember Me and Forgot Password -->
          <div class="flex items-center justify-between">
            <label class="flex items-center text-sm text-gray-600">
              <input type="checkbox" class="mr-2 rounded border-gray-300 focus:ring-blue-500">
              Remember me
            </label>
            <a href="#" class="text-sm text-blue-600 font-medium">Forgot password?</a>
          </div>

          <!-- Login Button -->
          <button type="submit"
            class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700 transition">
            Login Now
          </button>

          <!-- Divider -->
          <div class="flex items-center my-4">
            <div class="flex-grow border-t border-gray-300"></div>
            <span class="px-4 text-sm text-gray-500">or</span>
            <div class="flex-grow border-t border-gray-300"></div>
          </div>

          <!-- Login with Google -->
          <button type="button"
            class="w-full border border-gray-300 text-gray-700 py-2 px-4 rounded-lg font-medium hover:bg-gray-100 transition flex items-center justify-center gap-2">
            <img src="{{ asset('images/google.webp') }}" alt="Google Logo" class="w-5 h-5">
            Login with Google
          </button>
        </form>

        <!-- Sign Up Link -->
        <p class="text-center mt-4 text-sm text-gray-600">
          Don't have an account? <a href="#" class="text-blue-600 font-medium">Sign Up</a>
        </p>

        <!-- Error Alert -->
        @if ($errors->any())
        <div class="mt-4 text-red-600 text-sm">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
      </div>
    </div>
  </div>

</body>

</html>
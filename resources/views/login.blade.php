<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laundry Telkom - Login</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <style>
    * {
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-color: #f4f6f9;
      margin: 0;
    }

    .login-container {
      display: flex;
      height: 100vh;
      overflow: hidden;
    }

    .form-section {
      flex: 1;
      padding: 60px;
      background: #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .form-section h2 {
      font-weight: 600;
      margin-bottom: 10px;
    }

    .form-section p {
      color: #6c757d;
      margin-bottom: 30px;
    }

    .form-group label {
      font-weight: 500;
    }

    .form-control {
      border-radius: 8px;
      padding: 12px;
    }

    .btn-primary {
      background-color: #6A6F4C;
      border: none;
      border-radius: 8px;
      padding: 12px;
      font-weight: 500;
      transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #5c613f;
    }

    .form-check-label {
      font-size: 0.9rem;
      color: #495057;
    }

    .illustration-section {
      flex: 1;
      background-image: url('{{ asset("images/assets/bg.jpg") }}');
      /* Ganti path sesuai lokasi gambarmu */
      background-size: cover;
      background-position: center;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px;
    }


    .illustration-section img {
      max-width: 90%;
      height: auto;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
      .login-container {
        flex-direction: column-reverse;
      }

      .form-section,
      .illustration-section {
        flex: none;
        width: 100%;
        height: auto;
      }

      .form-section {
        padding: 40px 30px;
      }

      .illustration-section {
        padding: 20px;
      }
    }
  </style>
</head>

<body>

  <div class="login-container">
    <!-- Form Section -->
    <div class="form-section">
      <h2>Welcome Back 👋</h2>
      <p>Please enter your login credentials to continue</p>

      <form method="POST" action="{{ url('/login') }}">
        @csrf
        <div class="form-group">
          <label for="email">Email address</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
        </div>

        <div class="form-group form-check mb-4">
          <input type="checkbox" class="form-check-input" id="remember">
          <label class="form-check-label" for="remember">Remember me for 30 days</label>
        </div>

        <button type="submit" class="btn btn-primary w-100">Sign In</button>

        <!-- Tambahan alert -->
        @if ($errors->any())
        <div style="color: red;">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

      </form>
    </div>

    <!-- Illustration Section -->
    <div class="illustration-section">

      <img src="{{ asset('images/logos/logo.jpg') }}" alt="Login Illustration" style="width: 300px; height: 300px; border-radius: 50%; object-fit: cover;">

    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
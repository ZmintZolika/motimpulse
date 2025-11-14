<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <title>Bejelentkezés</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #e0e7ff, #f0fdf4);
      font-family: 'Inter', 'Segoe UI', sans-serif;
      min-height: 100vh;
    }

    .logo-box {
      text-align: center;
      margin-top: 50px;
      margin-bottom: 20px;
    }

    .logo-box img {
      height: 80px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(59,130,246,0.4);
      animation: fadeIn 1s ease-out;
    }
 h1, h2, h3 {
      color: #3b82f6;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .logo-box h1 {
      margin-top: 10px;
      font-weight: 600;
      color: #3b82f6;
      font-size: 2rem;
      text-shadow: 0 0 8px rgba(59,130,246,0.3);
      letter-spacing: 1px;
    }

    .card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 15px 40px rgba(0,0,0,0.15);
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 25px 60px rgba(0,0,0,0.25);
    }

    .btn-primary {
      background-color: #3b82f6;
      border: none;
      transition: transform 0.2s;
    }

    .btn-primary:hover {
      background-color: #2563eb;
      transform: scale(1.05);
    }

    .login-icon {
      display: inline-block;
      animation: bounce 1s infinite alternate;
    }

    @keyframes bounce {
      0% { transform: translateY(0); }
      100% { transform: translateY(-5px); }
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }

    p, label {
      font-size: 1.1rem;
    }
  </style>
</head>
<body class="bg-light">

<div class="d-flex justify-content-center align-items-center mt-5 mb-4">
  <img src="{{ asset('assets/logo.png') }}" alt="MotImpulse logó" style="height: 60px; border-radius: 12px; box-shadow: 0 0 10px rgba(59,130,246,0.4); margin-right: 15px;">
  <h1 style="font-weight: 600; color: #3b82f6; font-size: 2rem; margin: 0;">MotImpulse</h1>
</div>


  <div class="container d-flex justify-content-center align-items-center">
    <div class="card shadow-sm p-5" style="width: 100%; max-width: 400px;">
      <h2 class="text-center mb-4">
        <span class="login-icon">🔑</span> Bejelentkezés
      </h2>

      <form id="loginForm">
        <div class="mb-3">
          <label for="email" class="form-label">Email cím</label>
          <input type="email" class="form-control" id="email" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Jelszó</label>
          <input type="password" class="form-control" id="password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Bejelentkezés</button>
      </form>

      <div class="text-center mt-3">
        <a href="{{ route('register') }}" class="text-primary">Nincs fiókod? Regisztrálj</a>
      </div>
    </div>
  </div>

  <script>
    document.querySelector('#loginForm').addEventListener('submit', async (e) => {
      e.preventDefault();

      const email = document.querySelector('#email').value;
      const password = document.querySelector('#password').value;

      try {
        const response = await fetch('/api/login', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ email, password })
        });

        const data = await response.json();

        if (response.ok && data.token) {
          localStorage.setItem('token', data.token);
          window.location.href = "{{ route('day-entries') }}";
        } else {
          alert(data.message || 'Hiba történt a bejelentkezés során.');
        }
      } catch (err) {
        alert('Hiba történt a bejelentkezés során.');
        console.error(err);
      }
    });
  </script>

</body>
</html>

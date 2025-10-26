<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <title>Regisztráció</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #e0e7ff, #f0fdf4);
      font-family: 'Inter', 'Segoe UI', sans-serif;
      min-height: 100vh;
    }

    .brand-header {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 50px;
      margin-bottom: 20px;
      animation: fadeInBrand 1s ease-out;
    }

    .brand-header img {
      height: 60px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(59,130,246,0.4);
      margin-right: 15px;
    }
 h1, h2, h3 {
      color: #3b82f6;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .brand-header h1 {
      font-weight: 600;
      color: #3b82f6;
      font-size: 2rem;
      margin: 0;
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

    .register-icon {
      display: inline-block;
      animation: bounce 1s infinite alternate;
    }

    @keyframes bounce {
      0% { transform: translateY(0); }
      100% { transform: translateY(-5px); }
    }

    @keyframes fadeInBrand {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    p, label {
      font-size: 1.1rem;
    }
  </style>
</head>
<body class="bg-light">

  <div class="brand-header">
    <img src="{{ asset('assets/logo.png') }}" alt="MotImpulse logó">
    <h1>MotImpulse</h1>
  </div>

  <div class="container d-flex justify-content-center align-items-center">
    <div class="card shadow-sm p-5" style="width: 100%; max-width: 400px;">
      <h2 class="text-center mb-4">
        <span class="register-icon">📝</span> Regisztráció
      </h2>

      <form id="registerForm">
        <div class="mb-3">
          <label for="name" class="form-label">Név</label>
          <input type="text" class="form-control" id="name" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email cím</label>
          <input type="email" class="form-control" id="email" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Jelszó</label>
          <input type="password" class="form-control" id="password" required>
        </div>

        <div class="mb-3">
          <label for="password_confirmation" class="form-label">Jelszó megerősítése</label>
          <input type="password" class="form-control" id="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Regisztráció</button>
      </form>

      <div class="text-center mt-3">
        <a href="{{ route('login') }}" class="text-primary">Már van fiókod? Jelentkezz be</a>
      </div>
    </div>
  </div>

  <script>
    document.querySelector('#registerForm').addEventListener('submit', async (e) => {
      e.preventDefault();

      const name = document.querySelector('#name').value;
      const email = document.querySelector('#email').value;
      const password = document.querySelector('#password').value;
      const password_confirmation = document.querySelector('#password_confirmation').value;

      try {
        const response = await fetch('/api/register', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ name, email, password, password_confirmation })
        });

        const data = await response.json();

        if (response.ok && data.token) {
          localStorage.setItem('token', data.token);
          window.location.href = "{{ route('day-entries') }}";
        } else {
          alert(data.message || (data.errors ? Object.values(data.errors).flat().join("\n") : 'Hiba történt a regisztráció során.'));
        }
      } catch (err) {
        console.error(err);
        alert('Hiba történt a regisztráció során.');
      }
    });
  </script>

</body>
</html>

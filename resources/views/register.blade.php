<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Regisztráció</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      font-family: 'Inter', 'Segoe UI', sans-serif;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: url('{{ asset('assets/bg-beach.png') }}') no-repeat center center fixed;
      background-size: cover;
      overflow: hidden;
    }

    /* Üveges hatású doboz */
    .card {
      position: relative;
      z-index: 2;
      background-color: rgba(255, 255, 255, 0.55); /* 55% opacity */
      backdrop-filter: blur(10px);
      border: none;
      border-radius: 1rem;
      padding: 3rem;
      box-shadow: 0 15px 40px rgba(0,0,0,0.25);
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 25px 60px rgba(0,0,0,0.3);
    }

    .brand-header {
      text-align: center;
      margin-bottom: 25px;
      animation: fadeIn 1s ease-out;
    }

    .brand-header img {
      height: 70px;
      border-radius: 12px;
      box-shadow: 0 0 12px rgba(59,130,246,0.4);
      margin-bottom: 10px;
    }

    .brand-header h1 {
      font-weight: 600;
      color: #1e3a8a;
      font-size: 2rem;
      text-shadow: 0 0 8px rgba(59,130,246,0.3);
      letter-spacing: 1px;
    }

    h2 {
      color: #1e3a8a;
      margin-bottom: 1.5rem;
      font-weight: 600;
    }

    label {
      font-size: 1.05rem;
      color: #374151;
    }

    .btn-primary {
      background-color: #3b82f6;
      border: none;
      transition: transform 0.2s, background-color 0.2s;
    }

    .btn-primary:hover {
      background-color: #2563eb;
      transform: scale(1.05);
    }

    a.text-primary:hover {
      text-decoration: underline;
    }

    .register-icon {
      display: inline-block;
      animation: bounce 1s infinite alternate;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }

    @keyframes bounce {
      0% { transform: translateY(0); }
      100% { transform: translateY(-5px); }
    }

    @media (max-width: 576px) {
      .card {
        width: 90%;
        padding: 2rem 1.5rem;
      }
    }
  </style>
</head>

<body>
  <div class="card text-center" style="width: 100%; max-width: 420px;">
    <div class="brand-header">
      <img src="{{ asset('assets/logo.png') }}" alt="MotImpulse logó">
      <h1>MotImpulse</h1>
    </div>

    <h2><span class="register-icon">📝</span> Regisztráció</h2>

    <form id="registerForm">
      <div class="mb-3 text-start">
        <label for="name" class="form-label">Név</label>
        <input type="text" class="form-control" id="name" required>
      </div>

      <div class="mb-3 text-start">
        <label for="email" class="form-label">Email cím</label>
        <input type="email" class="form-control" id="email" required>
      </div>

      <div class="mb-3 text-start">
        <label for="password" class="form-label">Jelszó</label>
        <input type="password" class="form-control" id="password" required>
      </div>

      <div class="mb-3 text-start">
        <label for="password_confirmation" class="form-label">Jelszó megerősítése</label>
        <input type="password" class="form-control" id="password_confirmation" required>
      </div>

      <button type="submit" class="btn btn-primary w-100 mt-2">Regisztráció</button>
    </form>

    <div class="text-center mt-3">
      <a href="{{ route('login') }}" class="text-primary">Már van fiókod? Jelentkezz be</a>
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

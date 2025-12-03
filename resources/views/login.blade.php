<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bejelentkezés</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
  <div class="card text-center" style="width: 100%; max-width: 420px;">
    <div class="logo-box">
      <img src="{{ asset('assets/logo.png') }}" alt="MotImpulse logó">
      <h1>MotImpulse</h1>
    </div>

    <h2><span class="login-icon">🔑</span> Bejelentkezés</h2>

    <form id="loginForm">
      <div class="mb-3 text-start">
        <label for="email" class="form-label">Email cím</label>
        <input type="email" class="form-control" id="email" required>
      </div>

      <div class="mb-3 text-start">
        <label for="password" class="form-label">Jelszó</label>
        <input type="password" class="form-control" id="password" required>
      </div>

      <button type="submit" class="btn btn-primary w-100 mt-2">Bejelentkezés</button>
    </form>

    <div class="text-center mt-3">
      <a href="{{ route('register') }}" class="text-primary">Nincs fiókod? Regisztrálj</a>
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
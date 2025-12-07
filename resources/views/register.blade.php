<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Regisztráció</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
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
        <small class="form-text text-muted">Minimum 8 karakter szükséges.</small>
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
          headers: { 
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },

          body: JSON.stringify({ name, email, password, password_confirmation })
        });
        const data = await response.json();

        if (response.ok && data.token) {
          localStorage.setItem('token', data.token);
          window.location.href = "{{ route('entries') }}";
        } else {
          // Validációs hibák megjelenítése
          let errorMsg = '';
          if (data.errors) {
            for (let field in data.errors) {
              errorMsg += data.errors[field].join('\n') + '\n';
            }
          } else if (data.message) {
            errorMsg = data.message;
          } else {
            errorMsg = 'Hiba történt a regisztráció során.';
          }
          alert(errorMsg);
        }

      } catch (err) {
        console.error(err);
        alert('Hiba történt a regisztráció során.');
      }
    });
  </script>
</body>
</html>
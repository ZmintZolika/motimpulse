<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Kezdőlap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #e0e7ff, #f0fdf4);
            font-family: 'Inter', 'Segoe UI', sans-serif;
            min-height: 100vh;
        }

        h1, h2 {
            color: #3b82f6;
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

        .btn-logout {
            background-color: #f87171;
            border: none;
            transition: transform 0.2s;
        }

        .btn-logout:hover {
            background-color: #ef4444;
            transform: scale(1.05);
        }

        .greeting-icon {
            display: inline-block;
            animation: bounce 1s infinite alternate;
        }

        @keyframes bounce {
            0% { transform: translateY(0); }
            100% { transform: translateY(-5px); }
        }

        p {
            font-size: 1.1rem;
            color: #374151;
        }

        .d-grid.gap-3 a, .d-grid.gap-3 button {
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div> 
<div> 
   	<div class="brand-header">
            <img src="{{ asset('assets/logo.png') }}" alt="MotImpulse logó">
            <h1>MotImpulse</h1>
</div>
        <div class="card p-5 text-center" style="width: 100%; max-width: 520px;">
            <!-- Guest nézet -->
            <div id="guestView" style="display: none;">
                <h1 class="mb-4">Üdvözöljük!</h1>
                <p class="mb-4">Jelentkezzen be vagy regisztráljon az alkalmazás használatához.</p>
                <div class="d-grid gap-3">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg"><i class="fas fa-sign-in-alt me-2"></i>Bejelentkezés</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg"><i class="fas fa-user-plus me-2"></i>Regisztráció</a>
                </div>
	    </div>
       </div>

            <!-- Felhasználói nézet -->
            <div id="userView" style="display: none;">
                <h2 class="mb-3">Szia, <span id="userName"></span>!</h2>
                <p>Örülünk, hogy visszatértél az alkalmazásba.</p>
                <div class="d-grid gap-3 mt-4">
                    <a href="{{ route('day-entries') }}" class="btn btn-primary btn-lg"><i class="fas fa-book me-2"></i>Napi bejegyzéseim</a>
                    <button id="logoutBtn" class="btn btn-logout btn-lg"><i class="fas fa-sign-out-alt me-2"></i>Kijelentkezés</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
async function checkUser() {
    const token = localStorage.getItem('token');
    if (!token) {
        document.getElementById('guestView').style.display = 'block';
        return;
    }

    try {
        const response = await fetch('/api/user', {
            headers: { 'Authorization': 'Bearer ' + token }
        });

        if (response.ok) {
            const data = await response.json();
            document.getElementById('userName').innerText = data.name || data.email;
            document.getElementById('userView').style.display = 'block';
        } else {
            localStorage.removeItem('token');
            document.getElementById('guestView').style.display = 'block';
        }
    } catch (error) {
        console.error('Hiba:', error);
        document.getElementById('guestView').style.display = 'block';
    }
}

document.getElementById('logoutBtn')?.addEventListener('click', async () => {
    const token = localStorage.getItem('token');
    if (!token) return;

    const response = await fetch('/api/logout', {
        method: 'POST',
        headers: { 'Authorization': 'Bearer ' + token }
    });

    if (response.ok) {
        localStorage.removeItem('token');
        window.location.reload();
    } else {
        alert('Hiba történt a kijelentkezés során.');
    }
});

checkUser();
</script>

</body>
</html>

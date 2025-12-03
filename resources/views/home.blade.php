<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Kezdőlap - MotImpulse</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>

<div class="card">
    <div class="brand-header">
        <img src="{{ asset('assets/logo.png') }}" alt="MotImpulse logó">
        <h1>MotImpulse</h1>
    </div>

    <div id="guestView" style="display: none;">
        <h2 class="welcome-title">Üdvözöljük!</h2>
        <p class="subtitle">Jelentkezzen be vagy regisztráljon<br>az alkalmazás használatához.</p>
        
        <div class="d-grid gap-3">
            <a href="{{ route('login') }}" class="btn btn-custom-primary btn-lg">
                <i class="fas fa-sign-in-alt"></i> Bejelentkezés
            </a>
            
            <a href="{{ route('register') }}" class="btn btn-custom-secondary btn-lg">
                <i class="far fa-user"></i> Regisztráció
            </a>
        </div>
    </div>

    <div id="userView" style="display: none;">
        <h2 class="welcome-title">Szia, <span id="userName"></span>!</h2>
        <p class="subtitle">Örülünk, hogy visszatértél az alkalmazásba.</p>
        
        <div class="d-grid gap-3 mt-4">
            <a href="{{ route('day-entries') }}" class="btn btn-custom-primary btn-lg">
                <i class="fas fa-book-open"></i> Napi bejegyzéseim
            </a>
            
            <button id="logoutBtn" class="btn btn-custom-danger btn-lg">
                <i class="fas fa-sign-out-alt"></i> Kijelentkezés
            </button>
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

    try {
        await fetch('/api/logout', {
            method: 'POST',
            headers: { 'Authorization': 'Bearer ' + token }
        });
    } catch (e) {
        console.log("Logout error", e);
    } finally {
        localStorage.removeItem('token');
        window.location.reload();
    }
});

checkUser();
</script>

</body>
</html>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Napi Bejegyzés - MotImpulse</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    <style>
        .form-label {
            font-weight: 500;
            color: #1f2937;
            margin-bottom: 0.5rem;
            text-align: left;
            display: block;
        }
        
        /* A beviteli mezők stílusa, hogy passzoljon a kártyához */
        .form-select {
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 12px;
            padding: 10px 15px;
            font-size: 1rem;
        }
        
        .form-select:focus {
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
            border-color: #3b82f6;
        }

        .divider {
            height: 1px;
            background: rgba(0,0,0,0.1);
            margin: 1.5rem 0;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="brand-header">
        <img src="{{ asset('assets/logo.png') }}" alt="MotImpulse logó">
        <h1>MotImpulse</h1>
    </div>

    <h2 class="welcome-title">Szia!</h2>
    <p class="subtitle">Rögzítsd a mai napod adatait.</p>

    <div class="divider"></div>

    <form id="dayEntryForm">
        @csrf

        <div class="mb-3 text-start">
            <label for="mood" class="form-label"><i class="far fa-smile me-2"></i>Milyen a mai hangulatod?</label>
            <select class="form-select" id="mood" name="mood" required>
                <option value="" selected disabled>Válassz egy értéket...</option>
                @for ($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}">{{ $i }} - {{ $i === 1 ? 'Nagyon rossz' : ($i === 10 ? 'Szuper' : '') }}</option>
                @endfor
            </select>
        </div>

        <div class="mb-3 text-start">
            <label for="sleep" class="form-label"><i class="fas fa-bed me-2"></i>Hogy aludtál tegnap?</label>
            <select class="form-select" id="sleep" name="sleep_quality">
                <option value="" selected disabled>Válassz...</option>
                @foreach (['Nagyon rossz','Rossz','Kozepes','Jo','Kivalo'] as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 text-start">
            <label for="activity" class="form-label"><i class="fas fa-briefcase me-2"></i>Mivel töltöd a napod?</label>
            <select class="form-select" id="activity" name="activity">
                <option value="" selected disabled>Válassz...</option>
                @foreach (['Munka','Tanulas','Pihenes','Sport','Szorakozas','Egyeb'] as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4 text-start">
            <label for="health" class="form-label"><i class="fas fa-heart me-2"></i>Egészség tevékenység?</label>
            <select class="form-select" id="health" name="health_action">
                <option value="" selected disabled>Válassz...</option>
                @foreach (['Mozgas','Egeszseges etkezes','Pihenes','Semmi'] as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-custom-primary btn-lg w-100 mb-3">
            <i class="far fa-paper-plane"></i> Beküldés
        </button>
    </form>

    <div class="d-grid gap-2">
        <a href="{{ route('login') }}" class="btn btn-custom-secondary btn-sm">
            Már van fiókom? Belépés
        </a>
        <a href="{{ route('register') }}" class="btn btn-custom-secondary btn-sm">
            Nincs fiókom? Regisztráció
        </a>
    </div>
</div>

<script>
document.getElementById('dayEntryForm').addEventListener('submit', async (e) => {
  e.preventDefault();

  const token = localStorage.getItem('token'); // FIGYELEM: A home.blade.php-ban 'token'-t használtunk, itt egységesítettem arra.
  
  if (!token) {
    alert('Kérlek, jelentkezz be először!');
    window.location.href = '/login';
    return;
  }

  const mood = e.target.mood.value;
  const sleep_quality = e.target.sleep_quality.value;
  const activity = e.target.activity.value;
  const health_action = e.target.health_action.value;

  try {
    // Relatív útvonalat használunk, hogy éles környezetben is működjön
    const response = await fetch('/api/day-entry', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      },
      body: JSON.stringify({ mood, sleep_quality, activity, health_action })
    });

    const data = await response.json();

    if (response.ok) {
      alert('Sikeresen beküldve! 🌟');
      // Ideális esetben visszairányítjuk a főoldalra vagy listázó oldalra
      window.location.href = '/home'; 
    } else {
      alert(data.message || 'Hiba történt a beküldés során');
    }
  } catch (err) {
    console.error(err);
    alert('Hálózati hiba vagy szerverhiba');
  }
});
</script>

</body>
</html>
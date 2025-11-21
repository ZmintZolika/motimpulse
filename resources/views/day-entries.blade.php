<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <title>Napi bejegyzések</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      background: linear-gradient(to right, #f1f5f9, #e2e8f0);
      font-family: 'Segoe UI', sans-serif;
    }
    h1, h2, h3 {
      color: #3b82f6;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    h1 i, h2 i, h3 i {
      margin-left: 10px;
      animation: bounce 1.5s infinite;
    }
    .card {
      border: none;
      box-shadow: 0 5px 25px rgba(0,0,0,0.1);
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 35px rgba(0,0,0,0.15);
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
    .btn-success {
      background-color: #10b981;
      border: none;
      transition: transform 0.2s;
    }
    .btn-success:hover {
      background-color: #059669;
      transform: scale(1.05);
    }
    .btn-danger {
      background-color: #f87171;
      border: none;
      transition: transform 0.2s;
    }
    .btn-danger:hover {
      background-color: #ef4444;
      transform: scale(1.05);
    }
    #quoteCard p {
      color: #3b82f6;
      font-style: italic;
    }
    #quoteCard footer {
      font-weight: 500;
      text-align: center;
      margin-top: 5px;
    }
    .alert {
      animation: fadeInOut 5s forwards;
    }
    @keyframes bounce {
      0%,100%{transform:translateY(0);}
      50%{transform:translateY(-5px);}
    }
    @keyframes fadeInOut {
      0%{opacity:0;}
      10%{opacity:1;}
      90%{opacity:1;}
      100%{opacity:0;}
    }
    .logo {
      height: 48px;
      margin-right: 15px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(59,130,246,0.4);
    }
  </style>
</head>
<body class="bg-light">

<div class="container py-4">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center">
      <img src="/assets/logo.png" alt="MotImpulse logo" class="logo">
      <div>
        <h1 id="userGreeting">Napi bejegyzések <i class="bi bi-journal-text"></i></h1>
      	<small class="text-muted" style="display:none;" id="userEmail"></small>
	</div>
    </div>
    <button id="logoutBtn" class="btn btn-danger">Kijelentkezés</button>
  </div>

  <div id="messageBox"></div>

  <div id="quoteCard" class="card p-4 mb-4 shadow-sm bg-white" style="display:none;">
    <blockquote class="blockquote mb-0 text-center">
      <p id="quoteText" class="fs-5 fw-semibold"></p>
      <footer id="quoteAuthor">- author -</footer>
    </blockquote>
  </div>

  <div class="card p-4 mb-4 shadow-sm">
    <h2 class="mb-3">Új bejegyzés hozzáadása <i class="bi bi-plus-circle"></i></h2>
    <form id="entryForm">
      <div class="row g-3">
        <div class="col-md-3">
          <label for="date" class="form-label">Dátum</label>
          <input type="date" id="date" class="form-control" required max="">
        </div>
        <div class="col-md-2">
          <label for="mood" class="form-label">Hangulat (1-10)</label>
          <input type="number" id="mood" class="form-control" min="1" max="10" required>
        </div>
        <div class="col-md-2">
          <label for="weather" class="form-label">Időjárás</label>
          <select id="weather" class="form-select">
            <option value="">Válassz...</option>
            <option>Napos</option><option>Felhős</option><option>Esős</option><option>Szeles</option><option>Havas</option>
          </select>
        </div>
        <div class="col-md-2">
          <label for="sleep_quality" class="form-label">Alvás</label>
          <select id="sleep_quality" class="form-select">
            <option value="">Válassz...</option>
            <option>Nagyon rossz</option><option>Rossz</option><option>Közepes</option><option>Jó</option><option>Kiváló</option>
          </select>
        </div>
        <div class="col-md-2">
          <label for="activity" class="form-label">Tevékenység</label>
          <select id="activity" class="form-select">
            <option value="">Válassz...</option>
            <option>Munka</option><option>Tanulás</option><option>Pihenés</option><option>Sport</option><option>Szórakozás</option><option>Egyéb</option>
          </select>
        </div>
        <div class="col-md-2">
          <label for="health_action" class="form-label">Egészség</label>
          <select id="health_action" class="form-select">
            <option value="">Válassz...</option>
            <option>Mozgás</option><option>Egészséges étkezés</option><option>Pihenés</option><option>Semmi</option>
          </select>
        </div>
        <div class="col-md-2">
          <label for="score" class="form-label">Napi pont (1-10)</label>
          <input type="number" id="score" class="form-control" min="1" max="10">
        </div>
        <div class="col-12">
          <label for="note" class="form-label">Megjegyzés</label>
          <textarea id="note" class="form-control" rows="2" maxlength="1000"></textarea>
        </div>
        <div class="col-12 text-end">
          <button type="submit" class="btn btn-success mt-3">Mentés</button>
        </div>
      </div>
    </form>
  </div>

  <div class="card p-4 shadow-sm">
    <h3 class="mb-3">Korábbi bejegyzések <i class="bi bi-clock-history"></i></h3>
    <div class="table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>Dátum</th><th>Hangulat</th><th>Időjárás</th><th>Tevékenység</th><th>Alvás</th><th>Pont</th><th>Megjegyzés</th><th></th>
          </tr>
        </thead>
        <tbody id="entriesTableBody">
          <tr><td colspan="8" class="text-center text-muted">Betöltés...</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
const token = localStorage.getItem('token');
if (!token) window.location.href = "{{ route('login') }}";

async function init() {
document.addEventListener('DOMContentLoaded', () => {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('date').setAttribute('max', today);
});

  const messageBox = document.getElementById('messageBox');

  function showMessage(message, type = 'danger') {
    messageBox.innerHTML = `<div class="alert alert-${type}" role="alert">${message}</div>`;
    setTimeout(() => messageBox.innerHTML = '', 5000);
  }

  async function loadUser() {
    try {
      const res = await fetch('/api/user', { headers: { 'Authorization': 'Bearer ' + token } });
      if (!res.ok) throw new Error('Unauthorized');
      const user = await res.json();
      document.getElementById('userGreeting').innerHTML = `Szia, ${user.name || 'Felhasználó'}! <i class="bi bi-emoji-smile"></i>`;
      document.getElementById('userEmail').innerText = user.email;
    } catch {
      localStorage.removeItem('token');
      window.location.href = "{{ route('login') }}";
    }
  }

  document.getElementById('logoutBtn').addEventListener('click', async () => {
    await fetch('/api/logout', { method: 'POST', headers: { 'Authorization': 'Bearer ' + token } });
    localStorage.removeItem('token');
    window.location.reload();
  });

  async function loadEntries() {
    const res = await fetch('/api/day-entries', { headers: { 'Authorization': 'Bearer ' + token } });
    const tbody = document.getElementById('entriesTableBody');
    tbody.innerHTML = '';
    if (!res.ok) return showMessage('Nem sikerült betölteni a bejegyzéseket');
    const entries = await res.json();
    if (!entries.length) {
      tbody.innerHTML = '<tr><td colspan="8" class="text-center text-muted">Még nincs bejegyzés.</td></tr>';
      return;
    }
    entries.forEach(entry => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${entry.date}</td>
        <td>${entry.mood ?? '-'}</td>
        <td>${entry.weather ?? '-'}</td>
        <td>${entry.activity ?? '-'}</td>
        <td>${entry.sleep_quality ?? '-'}</td>
        <td>${entry.score ?? '-'}</td>
        <td>${entry.note ?? ''}</td>
        <td><button class="btn btn-sm btn-danger" onclick="deleteEntry(${entry.id})">🗑</button></td>
      `;
      tbody.appendChild(tr);
    });
  }

  document.getElementById('entryForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const body = {
      date: document.getElementById('date').value,
      mood: parseInt(document.getElementById('mood').value,10),
      weather: document.getElementById('weather').value,
      sleep_quality: document.getElementById('sleep_quality').value,
      activity: document.getElementById('activity').value,
      health_action: document.getElementById('health_action').value,
      score: parseInt(document.getElementById('score').value,10) || null,
      note: document.getElementById('note').value
    };
    try {
      const res = await fetch('/api/day-entries', {
        method: 'POST',
        headers: { 'Authorization': 'Bearer ' + token, 'Content-Type': 'application/json' },
        body: JSON.stringify(body)
      });
      const data = await res.json();
      if (!res.ok) return showMessage(data.message || 'Hiba mentés közben');
      document.getElementById('entryForm').reset();
      await loadEntries();
      await loadQuote();
      showMessage('Sikeres mentés!', 'success');
    } catch { showMessage('Hiba a mentés során'); }
  });

  window.deleteEntry = async function(id) {
    if (!confirm('Biztosan törölni szeretnéd ezt a bejegyzést?')) return;
    const res = await fetch(`/api/day-entries/${id}`, {
      method: 'DELETE', headers: { 'Authorization': 'Bearer ' + token }
    });
    if (res.ok) loadEntries(); else showMessage('Nem sikerült törölni a bejegyzést');
  };

  async function loadQuote() {
    const res = await fetch('/api/quotes/random');
    if (!res.ok) return;
    const quote = await res.json();
    if (quote && quote.text) {
      document.getElementById('quoteText').innerText = `"${quote.text}"`;
      document.getElementById('quoteAuthor').innerText = quote.author ? `– ${quote.author}` : '';
      document.getElementById('quoteCard').style.display = 'block';
    }
  }

  

  await loadUser();
  await loadEntries();
  await loadQuote();
}

init();
</script>
</body>
</html>

<script>
  //---------------------------------------------------------------------------------------------------
  document.addEventListener('DOMContentLoaded', function()) {
    
    // Először definiálunk egy funkciót, ami lekéri és megjeleníti az idézetet
    // Erre azért van szükség, hogy a "Mentés" gomb is meg tudja hívni később
    function fetchAndShowQuote() {
        // A 'fetch' segítségével hívást indítunk a Laravel kontrolleredben
        // definiált útvonalra.
        // FONTOS: Ha az útvonalad '/api/quotes/random', akkor itt javítsd!
        fetch('/api/quotes/random')
            .then(response => {
                // Ellenőrizzük, hogy a válasz sikeres-e
                if (!response.ok) {
                    throw new Error('Hálózati hiba: ' + response.statusText);
                }
                // Átalakítjuk a választ JSON-ná
                return response.json();
            })
            .then(data => {
                // Megkaptuk az adatot (pl. { text: "...", author: "..." })

                // Megkeressük a HTML elemeket az 'id' alapján
                const quoteCard = document.getElementById('quoteCard');
                const quoteText = document.getElementById('quoteText');
                const quoteAuthor = document.getElementById('quoteAuthor');

                // Beállítjuk a tartalmukat a kapott adatok alapján
                if (data && data.text && data.author) {
                    quoteText.textContent = `„${data.text}”`; // Idézőjelekkel szebb
                    quoteAuthor.textContent = `- ${data.author}`;
                    
                    // És a legfontosabb: láthatóvá tesszük a kártyát
                    quoteCard.style.display = 'block';
                } else {
                    console.error('Hiányos idézet adatot kaptunk.');
                }
            })
            .catch(error => {
                // Hiba esetén kiírjuk a konzolra
                console.error('Hiba történt az idézet lekérése közben:', error);
            });
    }
      fetchAndShowQuote();
      </script>
<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <title>Napi bejegyzések</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link href="{{ asset('css/style.css') }}" rel="stylesheet">

  <style>
      body {
          display: block !important; 
          height: auto !important;
          padding-top: 2rem;
          padding-bottom: 2rem;
      }
      .container {
          max-width: 900px;
      }
  </style>
</head>
<body class="bg-light">

<div class="container">

    <div class="card p-4 mb-4 shadow-sm">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center">
            <img src="/assets/logo.png" alt="MotImpulse logo" class="logo">
            <h2 id="userGreeting" class="m-0">Napi bejegyzések <i class="bi bi-journal-text"></i></h2>
        </div>
      	<small class="text-muted" style="display:none;" id="userEmail"></small>
        <button id="logoutBtn" class="btn btn-danger">Kijelentkezés</button>
      </div>   
      </div>

    <div id="messageBox" class="mb-4"></div>

    <div class="card p-4 mb-4 shadow-sm" id="quoteCard" style="display:none;">
      <blockquote class="blockquote mb-0 text-center">
        <p id="quoteText" class="fs-5 fw-semibold"></p>
        <footer id="quoteAuthor">- author -</footer>
      </blockquote>
    </div>

    <div class="card p-4 mb-4 shadow-sm">
      <h3 class="mb-3">Új bejegyzés hozzáadása <i class="bi bi-plus-circle"></i></h3>
      
      <form id="entryForm">
        <div class="row g-3">
          <div class="col-md-3">
            <label for="date" class="form-label">Dátum</label>
            <input type="date" id="date" class="form-control" required max="">
          </div>
          <div class="col-md-2">
              <label for="mood" class="form-label">Hangulat</label>
              <select id="mood" class="form-select" required>
                <option value="">Válassz...</option>
                <option value="Lehangolt">Lehangolt</option>
                <option value="Kiegyensúlyozott">Kiegyensúlyozott</option>
                <option value="Vidám">Vidám</option>
              </select>
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
            <label for="activities" class="form-label">Tevékenység</label>
            <select id="activities" class="form-select">
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
    // Az alert osztály mellé tehetünk shadow-t is, hogy jobban elváljon
    messageBox.innerHTML = `<div class="alert alert-${type} shadow-sm border-0" role="alert">${message}</div>`;
    setTimeout(() => messageBox.innerHTML = '', 5000);
  }

  async function loadUser() {
    try {
      const res = await fetch('/api/user', { headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' } });
      if (!res.ok) throw new Error('Unauthorized');
      const user = await res.json();
      document.getElementById('userGreeting').innerHTML = `Szia, ${user.name || 'Felhasználó'}!`;
      document.getElementById('userEmail').innerText = user.email;
    } catch {
      localStorage.removeItem('token');
      window.location.href = "{{ route('login') }}";
    }
  }

  document.getElementById('logoutBtn').addEventListener('click', async () => {
    await fetch('/api/logout', { method: 'POST', headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' } });
    localStorage.removeItem('token');
    window.location.reload();
  });

async function loadEntries() {
  const res = await fetch('/api/entries', { 
    headers: { 
      'Authorization': 'Bearer ' + token, 
      'Accept': 'application/json' 
    } 
  });

  const tbody = document.getElementById('entriesTableBody');
  tbody.innerHTML = '';

  if (!res.ok) {
    return showMessage('Nem sikerült betölteni a bejegyzéseket');
  }

  const json = await res.json();        // { entries: [...] }
  const entries = json.entries || [];   // innen vesszük ki a tömböt

  if (!entries.length) {
    tbody.innerHTML = '<tr><td colspan="8" class="text-center text-muted">Még nincs bejegyzés.</td></tr>';
    return;
  }

  entries.forEach(entry => {
    const dateObj = new Date(entry.created_at);
    const formattedDate = dateObj.toLocaleDateString('hu-HU', { 
      year: 'numeric', 
      month: 'short', 
      day: 'numeric' 
    });

    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td style="font-weight: 500; color: #3b82f6;">${formattedDate}</td>
      <td>${entry.mood ?? '-'}</td>
      <td>${entry.weather ?? '-'}</td>
      <td>${entry.activities ?? '-'}</td>
      <td>${entry.sleep_quality ?? '-'}</td>
      <td>${entry.score ?? '-'}</td>
      <td class="text-truncate" style="max-width: 150px;">${entry.note ?? ''}</td>
      <td>
        <div class="btn-group" role="group">
          <button class="btn btn-sm btn-danger" onclick="deleteEntry(${entry.entry_id})" title="Törlés">
            <i class="bi bi-trash"></i>
          </button>
        </div>
      </td>
    `;
    tbody.appendChild(tr);
  });
}


document.getElementById('entryForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  const body = {
    date: document.getElementById('date').value,
    mood: document.getElementById('mood').value,
    weather: document.getElementById('weather').value,
    sleep_quality: document.getElementById('sleep_quality').value,
    activities: document.getElementById('activities').value,
    health_action: document.getElementById('health_action').value,
    score: parseInt(document.getElementById('score').value,10) || null,
    note: document.getElementById('note').value
  };

  console.log('Küldött body:', body);

  try {
    const res = await fetch('/api/entries', {
      method: 'POST',
      headers: { 
        'Authorization': 'Bearer ' + token, 
        'Content-Type': 'application/json', 
        'Accept': 'application/json' 
      },
      body: JSON.stringify(body)
    });

    const data = await res.json();

    if (!res.ok) {
      showMessage(data.message || 'Hiba mentés közben');
      return;
    }


    showMessage('Sikeres mentés!', 'success');
    document.getElementById('entryForm').reset();
    await loadEntries();

    if (data.entry && data.entry.quote) {
      document.getElementById('quoteText').innerText = `"${data.entry.quote.quote_text}"`;
      document.getElementById('quoteAuthor').innerText = data.entry.quote.author 
        ? `– ${data.entry.quote.author}` 
        : '';
      document.getElementById('quoteCard').style.display = 'block';
    } else {
      await loadQuote(); // fallback ha nincs hangulathoz illő idézet
    }

    document.getElementById('messageBox').scrollIntoView({ 
      behavior: 'smooth', 
      block: 'center' 
    });



  } catch (err) {
    console.error(err);
    showMessage('Hiba a mentés során (catch ág)');
  }
});


  window.deleteEntry = async function(id) {
    if (!confirm('Biztosan törölni szeretnéd ezt a bejegyzést?')) return;
    const res = await fetch(`/api/entries/${id}`, {
      method: 'DELETE', headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
    });
    if (res.ok) loadEntries(); else showMessage('Nem sikerült törölni a bejegyzést');
  };

  async function loadQuote() {
    const res = await fetch('/api/quotes/random', {
    headers: { 
      'Accept': 'application/json'}});
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
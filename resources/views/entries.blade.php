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
          max-width: 1200px; 
      }
      

      .table-sm td, .table-sm th {
          padding: 0.4rem 0.3rem;
          font-size: 0.875rem;
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
        <table class="table table-striped align-middle table-sm" style="table-layout: fixed; width: 100%;">

          <thead>
            <tr>
              <th style="width: 9%;">Dátum</th>
              <th style="width: 11%;">Hangulat</th>
              <th style="width: 8%;">Időjárás</th>
              <th style="width: 11%;">Tevékenység</th>
              <th style="width: 8%;">Alvás</th>
              <th style="width: 5%;">Pont</th>
              <th style="width: 23%;">Idézet</th>
              <th style="width: 18%;">Megjegyzés</th>
              <th style="width: 7%;"></th>
            </tr>
          </thead>
          <tbody id="entriesTableBody">
            <tr><td colspan="9" class="text-center text-muted">Betöltés...</td></tr>
          </tbody>
        </table>
      </div>
    </div>
</div>


<div class="modal fade" id="quoteModal" tabindex="-1" aria-labelledby="quoteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="quoteModalLabel">Napi idézet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Bezárás"></button>
      </div>
      <div class="modal-body">
        <blockquote class="blockquote text-center">
          <p id="modalQuoteText" class="fs-5 fw-semibold mb-3"></p>
          <footer id="modalQuoteAuthor" class="blockquote-footer"></footer>
        </blockquote>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="editEntryModal" tabindex="-1" aria-labelledby="editEntryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editEntryModalLabel">Bejegyzés szerkesztése</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Bezárás"></button>
      </div>
      <div class="modal-body">
        <form id="editEntryForm">
          <div id="editErrorBox" class="mb-2"></div>
          <input type="hidden" id="edit_entry_id">
          <div class="mb-2">
            <label for="edit_date" class="form-label">Dátum</label>
            <input type="date" id="edit_date" class="form-control" required>
          </div>
          <div class="row g-2">
            <div class="col-md-6">
              <label for="edit_mood" class="form-label">Hangulat</label>
              <select id="edit_mood" class="form-select">
                <option value="">Válassz...</option>
                <option value="Lehangolt">Lehangolt</option>
                <option value="Kiegyensúlyozott">Kiegyensúlyozott</option>
                <option value="Vidám">Vidám</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="edit_weather" class="form-label">Időjárás</label>
              <select id="edit_weather" class="form-select">
                <option value="">Válassz...</option>
                <option>Napos</option><option>Felhős</option><option>Esős</option><option>Szeles</option><option>Havas</option>
              </select>
            </div>
          </div>
          <div class="row g-2 mt-1">
            <div class="col-md-4">
              <label for="edit_sleep_quality" class="form-label">Alvás</label>
              <select id="edit_sleep_quality" class="form-select">
                <option value="">Válassz...</option>
                <option>Nagyon rossz</option><option>Rossz</option><option>Közepes</option><option>Jó</option><option>Kiváló</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="edit_activities" class="form-label">Tevékenység</label>
              <select id="edit_activities" class="form-select">
                <option value="">Válassz...</option>
                <option>Munka</option><option>Tanulás</option><option>Pihenés</option><option>Sport</option><option>Szórakozás</option><option>Egyéb</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="edit_health_action" class="form-label">Egészség</label>
              <select id="edit_health_action" class="form-select">
                <option value="">Válassz...</option>
                <option>Mozgás</option><option>Egészséges étkezés</option><option>Pihenés</option><option>Semmi</option>
              </select>
            </div>
          </div>
          <div class="row g-2 mt-1">
            <div class="col-md-4">
              <label for="edit_score" class="form-label">Pont (1-10)</label>
              <input type="number" id="edit_score" class="form-control" min="1" max="10">
            </div>
          </div>
          <div class="mt-2">
            <label for="edit_note" class="form-label">Megjegyzés</label>
            <textarea id="edit_note" class="form-control" rows="2" maxlength="1000"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégse</button>
        <button type="button" class="btn btn-primary" id="saveEditEntryBtn">Mentés</button>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script>
const token = localStorage.getItem('token');
if (!token) window.location.href = "{{ route('login') }}";

let showMessage;


async function init() {
  const now   = new Date();
  const year  = now.getFullYear();
  const month = String(now.getMonth() + 1).padStart(2, '0');
  const day   = String(now.getDate()).padStart(2, '0');
  const today = `${year}-${month}-${day}`;

  const dateInput     = document.getElementById('date');
  const editDateInput = document.getElementById('edit_date');

  dateInput.setAttribute('max', today);
  if (editDateInput) editDateInput.setAttribute('max', today);

  dateInput.value = today;

  const messageBox = document.getElementById('messageBox');

  showMessage = function(message, type = 'danger') {
    messageBox.innerHTML = `<div class="alert alert-${type} shadow-sm border-0" role="alert">${message}</div>`;
    setTimeout(() => messageBox.innerHTML = '', 5000);
  };

  await loadUser();
  await loadEntries();
  await loadQuote();
}


async function loadUser() {
  try {
    const res = await fetch('/api/user', {
      headers: {
        'Authorization': 'Bearer ' + token,
        'Accept': 'application/json'
      }
    });
    if (!res.ok) throw new Error('Unauthorized');
    const user = await res.json();
    document.getElementById('userGreeting').innerHTML = `Szia, ${user.name || 'Felhasználó'}!`;
    document.getElementById('userEmail').innerText = user.email;
  } catch {
    localStorage.removeItem('token');
    window.location.href = "{{ route('login') }}";
  }
}

// kijelentkezés
document.getElementById('logoutBtn').addEventListener('click', async () => {
  await fetch('/api/logout', {
    method: 'POST',
    headers: {
      'Authorization': 'Bearer ' + token,
      'Accept': 'application/json'
    }
  });
  localStorage.removeItem('token');
  window.location.reload();
});

// korábbi bejegyzések betöltése
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

  const json = await res.json();
  const entries = json.entries || [];

  if (!entries.length) {
    tbody.innerHTML = '<tr><td colspan="9" class="text-center text-muted">Még nincs bejegyzés.</td></tr>';
    return;
  }

  entries.forEach(entry => {
    const dateObj = new Date(entry.entry_date);
    const formattedDate = dateObj.toLocaleDateString('hu-HU', {
      year: 'numeric',
      month: 'short',
      day: 'numeric'
    });

    const tr = document.createElement('tr');
    const quoteText = entry.quote
      ? (entry.quote.quote_text.length > 30
          ? entry.quote.quote_text.substring(0, 30) + '...'
          : entry.quote.quote_text)
      : '-';

    tr.innerHTML = `
      <td style="font-weight: 500; color: #3b82f6;">${formattedDate}</td>
      <td>${entry.mood ?? '-'}</td>
      <td>${entry.weather ?? '-'}</td>
      <td>${entry.activities ?? '-'}</td>
      <td>${entry.sleep_quality ?? '-'}</td>
      <td>${entry.score ?? '-'}</td>
      <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
        ${entry.quote 
          ? `<a href="#" class="text-primary" onclick="showQuoteModal('${entry.quote.quote_text.replace(/'/g, "\\'")}', '${entry.quote.author || 'Ismeretlen'}'); return false;">${quoteText}</a>`
          : '-'
        }
      </td>
      <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${entry.note ?? ''}</td>
      <td>
        <div class="btn-group" role="group">
          <button class="btn btn-sm btn-outline-primary" onclick="openEditModal(${entry.entry_id})" title="Szerkesztés">
            <i class="bi bi-pencil"></i>
          </button>
          <button class="btn btn-sm btn-danger" onclick="deleteEntry(${entry.entry_id})" title="Törlés">
            <i class="bi bi-trash"></i>
          </button>
        </div>
      </td>
    `;

    tbody.appendChild(tr);
  });
}

// új bejegyzés mentése
document.getElementById('entryForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  const body = {
    date: document.getElementById('date').value,
    mood: document.getElementById('mood').value,
    weather: document.getElementById('weather').value,
    sleep_quality: document.getElementById('sleep_quality').value,
    activities: document.getElementById('activities').value,
    health_action: document.getElementById('health_action').value,
    score: parseInt(document.getElementById('score').value, 10) || null,
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
      await loadQuote();
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

// törlés
window.deleteEntry = async function(id) {
  if (!confirm('Biztosan törölni szeretnéd ezt a bejegyzést?')) return;
  const res = await fetch(`/api/entries/${id}`, {
    method: 'DELETE',
    headers: {
      'Authorization': 'Bearer ' + token,
      'Accept': 'application/json'
    }
  });
  if (res.ok) loadEntries();
  else showMessage('Nem sikerült törölni a bejegyzést');
};

// napi idézet
async function loadQuote() {
  const res = await fetch('/api/quotes/random', {
    headers: {
      'Authorization': 'Bearer ' + token,
      'Accept': 'application/json'
    }
  });

  if (!res.ok) return;
  const quote = await res.json();
  if (quote && quote.quote_text) {
    document.getElementById('quoteText').innerText = `"${quote.quote_text}"`;
    document.getElementById('quoteAuthor').innerText = quote.author ? `– ${quote.author}` : '';
    document.getElementById('quoteCard').style.display = 'block';
  }
}


window.showQuoteModal = function(text, author) {
  document.getElementById('modalQuoteText').innerText = `"${text}"`;
  document.getElementById('modalQuoteAuthor').innerText = author ? `– ${author}` : '';

  const modal = new bootstrap.Modal(document.getElementById('quoteModal'));
  modal.show();
};


window.openEditModal = async function(entryId) {
  try {
    const res = await fetch(`/api/entries/${entryId}`, {
      headers: {
        'Authorization': 'Bearer ' + token,
        'Accept': 'application/json'
      }
    });

    if (!res.ok) {
      showMessage('Nem sikerült betölteni a bejegyzést szerkesztéshez');
      return;
    }

    const data = await res.json();
    const entry = data.entry;

    document.getElementById('edit_entry_id').value      = entry.entry_id;
    document.getElementById('edit_date').value          = entry.entry_date;
    document.getElementById('edit_mood').value          = entry.mood || '';
    document.getElementById('edit_weather').value       = entry.weather || '';
    document.getElementById('edit_sleep_quality').value = entry.sleep_quality || '';
    document.getElementById('edit_activities').value    = entry.activities || '';
    document.getElementById('edit_health_action').value = entry.health_action || '';
    document.getElementById('edit_score').value         = entry.score || '';
    document.getElementById('edit_note').value          = entry.note || '';

    const modal = new bootstrap.Modal(document.getElementById('editEntryModal'));
    modal.show();
  } catch (e) {
    console.error(e);
    showMessage('Hiba történt a bejegyzés betöltésekor');
  }
};

document.getElementById('saveEditEntryBtn').addEventListener('click', async () => {
  const id           = document.getElementById('edit_entry_id').value;
  const editDateEl   = document.getElementById('edit_date');
  const editDate     = editDateEl.value;
  const editErrorBox = document.getElementById('editErrorBox');

  const today = new Date();
  today.setHours(0, 0, 0, 0);

  if (!editDate) {
    editErrorBox.innerHTML = '<div class="alert alert-warning py-2 mb-2">Kérlek, adj meg dátumot a bejegyzéshez.</div>';
    return;
  }

  const selected = new Date(editDate);
  selected.setHours(0, 0, 0, 0);

  if (selected > today) {
    editErrorBox.innerHTML = '<div class="alert alert-warning py-2 mb-2">A dátum nem lehet a mai napnál későbbi.</div>';
    return;
  }

  editErrorBox.innerHTML = '';

  const body = {
    entry_date: editDate,
    mood: document.getElementById('edit_mood').value || null,
    weather: document.getElementById('edit_weather').value || null,
    sleep_quality: document.getElementById('edit_sleep_quality').value || null,
    activities: document.getElementById('edit_activities').value || null,
    health_action: document.getElementById('edit_health_action').value || null,
    score: document.getElementById('edit_score').value ? parseInt(document.getElementById('edit_score').value, 10) : null,
    note: document.getElementById('edit_note').value || null,
  };

  try {
    const res = await fetch(`/api/entries/${id}`, {
      method: 'PUT',
      headers: {
        'Authorization': 'Bearer ' + token,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(body)
    });

    const data = await res.json();

    if (!res.ok) {
      showMessage(data.message || 'Hiba a módosítás során');
      return;
    }

    showMessage('Bejegyzés sikeresen módosítva', 'success');
    await loadEntries(); 


    if (data.entry && data.entry.quote) {
      document.getElementById('quoteText').innerText = `"${data.entry.quote.quote_text}"`;
      document.getElementById('quoteAuthor').innerText = data.entry.quote.author 
        ? `– ${data.entry.quote.author}` 
        : '';
      document.getElementById('quoteCard').style.display = 'block';
    }


    const modalEl = document.getElementById('editEntryModal');
    const modal   = bootstrap.Modal.getInstance(modalEl);
    modal.hide();

    document.getElementById('messageBox').scrollIntoView({
    behavior: 'smooth',
    block: 'center'
    });

  } catch (e) {
    console.error(e);
    showMessage('Hiba a módosítás során (catch)');
  }
});




init();
</script>


</body>
</html>
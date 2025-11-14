<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <title>MotImpulse</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- CSRF token a JavaScript fetch kérésekhez -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  @yield('content')

  <!-- Token küldése a backendnek, ha még nincs elmentve -->
  <script>
  const token = localStorage.getItem('auth_token');
  const tokenSent = sessionStorage.getItem('token_sent');

  if (token && !tokenSent) {
    fetch('/set-token', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({ token })
    })
    .then(res => res.json())
    .then(data => {
      console.log('Token mentve a session-be');
      sessionStorage.setItem('token_sent', 'true');
      window.location.href = '/dashboard'; // csak most irányítunk át!
    });
  }
</script>

</body>
</html>

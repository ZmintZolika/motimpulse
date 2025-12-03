<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Az oldal nem található - MotImpulse</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        .brand-header {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            gap: 12px;
        }

        .brand-header img {
            height: 48px;
            width: auto;
            border-radius: 10px;
        }

        .brand-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        h2.error-code {
            font-size: 5rem;
            font-weight: 800;
            color: #3b82f6; /* Kék szín */
            margin: 0;
            line-height: 1;
            text-shadow: 0 4px 10px rgba(59, 130, 246, 0.2);
        }

        h3.error-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        p.subtitle {
            font-size: 1rem;
            color: #4b5563;
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        /* Gomb stílus */
        .btn-custom-primary {
            background-color: #3b82f6;
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
            padding: 12px 25px;
            font-size: 1.1rem;
            border-radius: 12px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.2s;
        }
        .btn-custom-primary:hover {
            background-color: #2563eb;
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-custom-primary i {
            margin-right: 8px;
        }

        @media (max-width: 576px) {
            .glass-card {
                width: 90% !important;
                padding: 2rem 1.5rem !important;
            }
        }
    </style>
</head>

<body style="background: url('assets/bg-beach.png') no-repeat center center fixed; background-size: cover; font-family: 'Inter', sans-serif; min-height: 100vh; display: flex; justify-content: center; align-items: center; margin: 0;">

    <div class="card glass-card" style="
        background-color: rgba(255, 255, 255, 0.55) !important; /* Kicsit fehérebb, hogy olvashatóbb legyen a hibaüzenet */
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        padding: 3rem;
        width: 100%;
        max-width: 500px;
        text-align: center;">

        <div class="brand-header">
            <img src="{{ asset('assets/logo.png') }}" alt="MotImpulse logó">
            <h1>MotImpulse</h1>
        </div>

        <div class="mb-4">
            <h2 class="error-code">404</h2>
            <h3 class="error-title">Hoppá! Ez az oldal nem található.</h3>
        </div>

        <p class="subtitle">
            Úgy tűnik, eltévedtél a parton. A keresett oldal nem létezik vagy áthelyezték.
        </p>

        <a href="{{ url('/') }}" class="btn btn-custom-primary">
            <i class="fas fa-home"></i> Vissza a kezdőlapra
        </a>

    </div>

</body>
</html>
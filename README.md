# MotImpulse Backend API

**Hangulatvezérelt naplózó és motivációs webalkalmazás backend API-ja.**

MotImpulse egy olyan alkalmazás, amely segít a felhasználóknak nyomon követni napi hangulatukat, tevékenységeiket és egészségügyi szokásaikat, miközben motivációs idézetekkel támogatja őket. Ez a repository a Laravel-alapú RESTful API backend-et tartalmazza.

---

## 📋 Tartalomjegyzék

1. [Technológiák](#technológiák)
2. [Funkciók](#funkciók)
3. [Telepítés](#telepítés)
4. [API Endpoint-ok](#api-endpoint-ok)
   - [Authentication](#authentication)
   - [Motivációs Idézetek](#motivációs-idézetek)
   - [Napi Bejegyzések](#napi-bejegyzések)
5. [Adatbázis Struktúra](#adatbázis-struktúra)
6. [Használati Példák](#használati-példák)
7. [Tesztelés](#tesztelés)
8. [Jövőbeli Fejlesztések](#jövőbeli-fejlesztések)

---

## 🛠️ Technológiák

- **Laravel 11.x** - PHP backend framework
- **MySQL 8.0** - Relációs adatbázis
- **Laravel Sanctum** - API token-alapú autentikáció
- **Eloquent ORM** - Adatbázis kezelés
- **RESTful API** - Egységes API tervezés
- **CORS konfiguráció** - Frontend integráció támogatás

---

## ✨ Funkciók

### Felhasználói Autentikáció
- ✅ Regisztráció (email + jelszó)
- ✅ Bejelentkezés (token generálás)
- ✅ Kijelentkezés (token törlés)
- ✅ Sanctum token-alapú védelem

### Motivációs Idézetek
- ✅ Összes idézet lekérése
- ✅ Véletlenszerű idézet
- ✅ Kategória szerinti szűrés (1-10 hangulat skála alapján)
- ✅ 20 előre betöltött magyar motivációs idézet

### Napi Bejegyzések (Day Entries)
- ✅ CRUD műveletek (Create, Read, Update, Delete)
- ✅ Felhasználó-specifikus bejegyzések
- ✅ Soft delete (törölt bejegyzések visszaállíthatók)
- ✅ Részletes nyomkövetés:
  - Hangulat (1-10 skála)
  - Időjárás
  - Alvás minősége
  - Tevékenység
  - Egészségügyi cselekvés
  - Összpontszám
  - Egyéni jegyzet

---

## 🚀 Telepítés

### Előfeltételek

- PHP 8.2 vagy újabb
- Composer
- MySQL 8.0 vagy újabb
- XAMPP / WAMP / LAMP (fejlesztési környezet)

### Lépések

1. **Repository klónozása**

```

git clone https://github.com/ZmintZolika/motimpulse-backend.git
cd motimpulse-backend

```

2. **Composer függőségek telepítése**

```

composer install

```

3. **Environment fájl létrehozása**

```

cp .env.example .env

```

4. **.env fájl beállítása**

Nyisd meg a `.env` fájlt és állítsd be az adatbázis kapcsolatot:

```

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=motimpulse
DB_USERNAME=root
DB_PASSWORD=

```

5. **Alkalmazás kulcs generálása**

```

php artisan key:generate

```

6. **Adatbázis létrehozása**

HeidiSQL / phpMyAdmin-ban:
- Hozz létre egy új adatbázist `motimpulse` névvel
- Karakterkészlet: `utf8mb4_unicode_ci`

7. **Migráció futtatása**

```

php artisan migrate

```

8. **Seeders futtatása (demo adatok)**

```

php artisan db:seed

```

Ez létrehoz:
- 1 teszt felhasználót (`test@example.com` / `password`)
- 20 motivációs idézetet

9. **Fejlesztői szerver indítása**

```

php artisan serve

```

Az API elérhető: `http://localhost:8000`

---

## 📡 API Endpoint-ok

### Base URL

```

http://localhost:8000/api

```

---

### Authentication

#### 1. Regisztráció

**POST** `/api/register`

**Request Body:**
```

{
"name": "Test User",
"email": "test@example.com",
"password": "password123",
"password_confirmation": "password123"
}

```

**Response (201 Created):**
```

{
"user": {
"id": 1,
"name": "Test User",
"email": "test@example.com",
"created_at": "2025-10-12T18:00:00.000000Z",
"updated_at": "2025-10-12T18:00:00.000000Z"
},
"token": "1|abc123xyz...",
"token_type": "Bearer"
}

```

---

#### 2. Bejelentkezés

**POST** `/api/login`

**Request Body:**
```

{
"email": "test@example.com",
"password": "password"
}

```

**Response (200 OK):**
```

{
"user": {
"id": 1,
"name": "Test User",
"email": "test@example.com"
},
"token": "2|xyz789abc...",
"token_type": "Bearer"
}

```

---

#### 3. Kijelentkezés

**POST** `/api/logout`

**Headers:**
```

Authorization: Bearer {token}

```

**Response (200 OK):**
```

{
"message": "Logged out successfully"
}

```

---

#### 4. Felhasználó adatok lekérése

**GET** `/api/user`

**Headers:**
```

Authorization: Bearer {token}

```

**Response (200 OK):**
```

{
"id": 1,
"name": "Test User",
"email": "test@example.com",
"email_verified_at": null,
"created_at": "2025-10-12T18:00:00.000000Z",
"updated_at": "2025-10-12T18:00:00.000000Z"
}

```

---

### Motivációs Idézetek

#### 5. Összes idézet lekérése

**GET** `/api/quotes`

**Response (200 OK):**
```

[
{
"id": 1,
"category": 1,
"text": "Minden nehézség magában hordozza a lehetőséget.",
"author": "Albert Einstein",
"deleted_at": null,
"created_at": "2025-10-12T18:00:00.000000Z",
"updated_at": "2025-10-12T18:00:00.000000Z"
},
...
]

```

---

#### 6. Véletlenszerű idézet

**GET** `/api/quotes/random`

**Response (200 OK):**
```

{
"id": 7,
"category": 4,
"text": "Az út ezer mérföldre is egyetlen lépéssel kezdődik.",
"author": "Lao Ce",
"deleted_at": null,
"created_at": "2025-10-12T18:00:00.000000Z",
"updated_at": "2025-10-12T18:00:00.000000Z"
}

```

---

#### 7. Véletlenszerű idézet kategória szerint

**GET** `/api/quotes/random?category=10`

**Query paraméter:**
- `category` (integer, 1-10): Hangulat skála

**Kategóriák:**
- 1-2: Rossz hangulat
- 3-4: Közepes-alacsony
- 5-6: Semleges
- 7-8: Jó hangulat
- 9-10: Kiváló hangulat

**Response (200 OK):**
```

{
"id": 19,
"category": 10,
"text": "Ragyogj, és világítsd meg mások útját is!",
"author": "Unknown",
"deleted_at": null,
"created_at": "2025-10-12T18:00:00.000000Z",
"updated_at": "2025-10-12T18:00:00.000000Z"
}

```

---

### Napi Bejegyzések

**Minden endpoint védett! (Authorization: Bearer token szükséges)**

---

#### 8. Összes bejegyzés lekérése

**GET** `/api/day-entries`

**Headers:**
```

Authorization: Bearer {token}

```

**Response (200 OK):**
```

[
{
"id": 1,
"user_id": 1,
"date": "2025-10-12",
"mood": 8,
"weather": "Napos",
"sleep_quality": "Jo",
"activity": "Sport",
"health_action": "Mozgas",
"score": 9,
"note": "Remek nap volt!",
"deleted_at": null,
"created_at": "2025-10-12T18:00:00.000000Z",
"updated_at": "2025-10-12T18:00:00.000000Z"
}
]

```

---

#### 9. Új bejegyzés létrehozása

**POST** `/api/day-entries`

**Headers:**
```

Authorization: Bearer {token}

```

**Request Body:**
```

{
"date": "2025-10-12",
"mood": 8,
"weather": "Napos",
"sleep_quality": "Jo",
"activity": "Sport",
"health_action": "Mozgas",
"score": 9,
"note": "Ma remek napom volt!"
}

```

**Érvényes értékek:**

- **mood:** 1-10 (integer)
- **weather:** `Napos`, `Felhos`, `Esos`, `Szeles`, `Havas`
- **sleep_quality:** `Nagyon rossz`, `Rossz`, `Kozepes`, `Jo`, `Kivalo`
- **activity:** `Munka`, `Tanulas`, `Pihenes`, `Sport`, `Szorakozas`, `Egyeb`
- **health_action:** `Mozgas`, `Egeszseges etkezes`, `Pihenes`, `Semmi`
- **score:** 1-10 (integer)
- **note:** bármilyen szöveg (opcionális)

**Response (201 Created):**
```

{
"id": 1,
"user_id": 1,
"date": "2025-10-12",
"mood": 8,
"weather": "Napos",
"sleep_quality": "Jo",
"activity": "Sport",
"health_action": "Mozgas",
"score": 9,
"note": "Ma remek napom volt!",
"deleted_at": null,
"created_at": "2025-10-12T18:00:00.000000Z",
"updated_at": "2025-10-12T18:00:00.000000Z"
}

```

---

#### 10. Egy bejegyzés lekérése ID alapján

**GET** `/api/day-entries/{id}`

**Headers:**
```

Authorization: Bearer {token}

```

**Response (200 OK):**
```

{
"id": 1,
"user_id": 1,
"date": "2025-10-12",
"mood": 8,
...
}

```

---

#### 11. Bejegyzés módosítása

**PUT** `/api/day-entries/{id}`

**Headers:**
```

Authorization: Bearer {token}

```

**Request Body:**
```

{
"date": "2025-10-12",
"mood": 9,
"weather": "Napos",
"sleep_quality": "Kiváló",
"activity": "Sport",
"health_action": "Egeszseges_etkezes",
"score": 10,
"note": "Még jobb nap lett!"
}

```

**Response (200 OK):**
```

{
"id": 1,
"user_id": 1,
"date": "2025-10-12",
"mood": 9,
"weather": "Napos",
"sleep_quality": "Kiváló",
...
"updated_at": "2025-10-13T18:20:00.000000Z"
}

```

---

#### 12. Bejegyzés törlése (Soft Delete)

**DELETE** `/api/day-entries/{id}`

**Headers:**
```

Authorization: Bearer {token}

```

**Response (200 OK):**
```

{
"message": "Entry deleted successfully"
}

```

**Soft Delete:** A bejegyzés nem törlődik véglegesen, csak `deleted_at` időbélyeget kap. Később visszaállítható.

---

## 🗄️ Adatbázis Struktúra

### 1. `users` tábla

| Mező | Típus | Leírás |
|------|-------|--------|
| id | BIGINT UNSIGNED | Elsődleges kulcs |
| name | VARCHAR(255) | Felhasználó neve |
| email | VARCHAR(255) | Email cím (egyedi) |
| email_verified_at | TIMESTAMP | Email megerősítés ideje |
| password | VARCHAR(255) | Titkosított jelszó (bcrypt) |
| remember_token | VARCHAR(100) | "Emlékezz rám" token |
| created_at | TIMESTAMP | Létrehozás ideje |
| updated_at | TIMESTAMP | Utolsó módosítás ideje |

---

### 2. `day_entries` tábla

| Mező | Típus | Leírás |
|------|-------|--------|
| id | BIGINT UNSIGNED | Elsődleges kulcs |
| user_id | BIGINT UNSIGNED | Felhasználó ID (foreign key) |
| date | DATE | Bejegyzés dátuma |
| mood | INTEGER | Hangulat (1-10) |
| weather | ENUM | Időjárás |
| sleep_quality | ENUM | Alvás minősége |
| activity | VARCHAR(255) | Tevékenység |
| health_action | ENUM | Egészségügyi cselekvés |
| score | INTEGER | Összpontszám (1-10) |
| note | TEXT | Egyéni jegyzet |
| deleted_at | TIMESTAMP | Soft delete időbélyeg |
| created_at | TIMESTAMP | Létrehozás ideje |
| updated_at | TIMESTAMP | Utolsó módosítás ideje |

---

### 3. `motivational_quotes` tábla

| Mező | Típus | Leírás |
|------|-------|--------|
| id | BIGINT UNSIGNED | Elsődleges kulcs |
| category | INTEGER | Kategória (1-10, hangulat alapú) |
| text | TEXT | Idézet szövege |
| author | VARCHAR(255) | Szerző neve |
| deleted_at | TIMESTAMP | Soft delete időbélyeg |
| created_at | TIMESTAMP | Létrehozás ideje |
| updated_at | TIMESTAMP | Utolsó módosítás ideje |

---

## 🧪 Tesztelés

### Thunder Client / Postman használata

1. **Importáld be az endpoint-okat** Thunder Client-be
2. **Login végpont hívása** → Token mentése
3. **Token használata** védett endpoint-oknál:
```

Authorization: Bearer {token}

```

### Teszt felhasználó (seeder által létrehozva)

```

Email: test@example.com
Password: password

```

### Tesztelési sorrend

1. ✅ POST `/api/register` - Regisztráció
2. ✅ POST `/api/login` - Token szerzése
3. ✅ GET `/api/user` - Token működésének ellenőrzése
4. ✅ GET `/api/quotes` - Idézetek lekérése
5. ✅ GET `/api/quotes/random?category=10` - Random idézet
6. ✅ POST `/api/day-entries` - Bejegyzés létrehozása
7. ✅ GET `/api/day-entries` - Lista lekérése
8. ✅ GET `/api/day-entries/1` - Egy bejegyzés
9. ✅ PUT `/api/day-entries/1` - Módosítás
10. ✅ DELETE `/api/day-entries/1` - Törlés
11. ✅ POST `/api/logout` - Kijelentkezés

---

## 🔐 Biztonság

### Implementált védelmi mechanizmusok

- ✅ **SQL Injection védelem** - Eloquent ORM prepared statements
- ✅ **Mass Assignment védelem** - `$fillable` tömb használata
- ✅ **Password hashing** - Bcrypt algoritmus
- ✅ **CSRF védelem** - Laravel alapértelmezett védelem
- ✅ **API Token autentikáció** - Laravel Sanctum
- ✅ **Input validáció** - Form Request validáció minden endpoint-nál
- ✅ **CORS konfiguráció** - Frontend integráció támogatás

### Jövőbeli biztonsági fejlesztések

- ⏳ Rate limiting (API throttle)
- ⏳ HTTPS kényszerítés (production)
- ⏳ API versioning (`/api/v1/`)
- ⏳ Request size limiting

---

## 📁 Projekt Struktúra

```

motimpulse-backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       ├── AuthController.php
│   │   │       ├── DayEntryController.php
│   │   │       └── MotivationalQuoteController.php
│   │   └── Requests/
│   │       └── StoreDayEntryRequest.php
│   └── Models/
│       ├── User.php
│       ├── DayEntry.php
│       └── MotivationalQuote.php
├── database/
│   ├── migrations/
│   │   ├── 2024_10_11_create_day_entries_table.php
│   │   └── 2024_10_11_create_motivational_quotes_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── MotivationalQuoteSeeder.php
├── routes/
│   └── api.php
├── config/
│   └── cors.php
├── bootstrap/
│   └── app.php
├── .env.example
└── README.md

```

---

## 🚀 Jövőbeli Fejlesztések

### Backend

- [ ] Email verifikáció
- [ ] Jelszó visszaállítás (forgot password)
- [ ] Felhasználói profil képek feltöltése
- [ ] Napi statisztikák és grafikonok API
- [ ] Exportálás CSV/PDF formátumban
- [ ] Több nyelv támogatása (i18n)
- [ ] WebSocket real-time értesítések

### Frontend

- [ ] Angular frontend fejlesztés
- [ ] React / Vue.js alternatíva
- [ ] Reszponzív design
- [ ] PWA (Progressive Web App)
- [ ] Mobilalkalmazás (Flutter/React Native)

---

## 🤝 Közreműködés

Ez egy egyetemi projekt, jelenleg nem fogadunk külső közreműködést.

---

## 📄 Licensz

Ez a projekt oktatási célokra készült.

---

## 👨‍💻 Készítő

`Mókus csapat`

**MotImpulse Project**  
Backend API - Laravel 11  
2025


## 📞 Kapcsolat

Ha kérdésed van a projekttel kapcsolatban, nyiss egy issue-t a GitHub repository-ban.

---

**Készítve ❤️-vel Laravel 11-ben**
```


***

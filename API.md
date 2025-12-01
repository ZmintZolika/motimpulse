# MotImpulse Backend API Dokumentáció

**Verzió:** 1.0 
**Utolsó frissítés:** 2025-11-20  
**Backend:** Laravel 11 + MySQL  
**Auth:** Laravel Sanctum (Bearer Token)

---

## 📋 Tartalomjegyzék

1. [Base URL és Headers](#base-url-és-headers)
2. [Autentikáció](#autentikáció)
3. [Auth API](#auth-api)
4. [Entry API](#entry-api)
5. [Quote API](#quote-api)
6. [Hibakezelés](#hibakezelés)
7. [Adatmodellek](#adatmodellek)

---

## 🌐 Base URL és Headers

### Base URL
```
http://127.0.0.1:8000/api
```

### Headers (Public endpoint-ok)
```http
Content-Type: application/json
Accept: application/json
```

### Headers (Védett endpoint-ok)
```http
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

---

## 🔐 Autentikáció

**Laravel Sanctum Bearer Token**

1. Register/Login → Token megszerzése
2. Token tárolása (localStorage)
3. Token használata védett endpoint-oknál
4. Logout → Token törlése

---

## 🔑 Auth API

### 1. Regisztráció
**POST** `/api/register`  
**Auth:** Nem szükséges

#### Request Body
```json
{
  "name": "Teszt Felhasználó",
  "email": "test@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

#### Response (201 Created)
```json
{
  "message": "Sikeres regisztráció",
  "user": {
    "user_id": 1,
    "name": "Teszt Felhasználó",
    "email": "test@example.com",
    "created_at": "2025-11-20T18:00:00.000000Z",
    "updated_at": "2025-11-20T18:00:00.000000Z"
  },
  "token": "1|abc123def456..."
}
```

#### Validáció
- `name`: kötelező, min 2 karakter
- `email`: kötelező, email formátum, egyedi
- `password`: kötelező, min 8 karakter, confirmation szükséges

---

### 2. Bejelentkezés
**POST** `/api/login`  
**Auth:** Nem szükséges

#### Request Body
```json
{
  "email": "test@example.com",
  "password": "password123"
}
```

#### Response (200 OK)
```json
{
  "message": "Sikeres bejelentkezés",
  "user": {
    "user_id": 1,
    "name": "Teszt Felhasználó",
    "email": "test@example.com"
  },
  "token": "1|abc123def456..."
}
```

#### Hiba (401 Unauthorized)
```json
{
  "message": "Hibás email vagy jelszó"
}
```

---

### 3. Kijelentkezés
**POST** `/api/logout`  
**Auth:** Bearer token szükséges

#### Response (200 OK)
```json
{
  "message": "Sikeres kijelentkezés"
}
```

---

## 📝 Entry API

**Minden endpoint védett! Bearer token szükséges!**

### 1. Entry lista (user-specifikus)
**GET** `/api/entries`  
**Auth:** Bearer token

#### Response (200 OK)
```json
{
  "entries": [
    {
      "entry_id": 1,
      "user_id": 1,
      "quote_id": 5,
      "mood": "Vidám",
      "weather": "Napos",
      "sleep_quality": "Jó",
      "activities": "Sport",
      "health_action": "Mozgás",
      "note": "Ma remek napom volt!",
      "is_deleted": false,
      "created_at": "2025-11-20T18:00:00.000000Z",
      "updated_at": "2025-11-20T18:00:00.000000Z",
      "quote": {
        "quote_id": 5,
        "quote_category": "Vidám",
        "quote_text": "A boldogság nem cél, hanem életmód.",
        "author": "Ismeretlen"
      }
    }
  ]
}
```

---

### 2. Egy Entry lekérése
**GET** `/api/entries/{id}`  
**Auth:** Bearer token

#### Response (200 OK)
```json
{
  "entry": {
    "entry_id": 1,
    "user_id": 1,
    "mood": "Vidám",
    "weather": "Napos",
    "sleep_quality": "Jó",
    "activities": "Sport",
    "health_action": "Mozgás",
    "note": "Ma remek napom volt!",
    "quote": {
      "quote_id": 5,
      "quote_category": "Vidám",
      "quote_text": "A boldogság nem cél, hanem életmód.",
      "author": "Ismeretlen"
    }
  }
}
```

#### Hiba (404 Not Found)
```json
{
  "message": "Entry nem található"
}
```

---

### 3. Entry létrehozása
**POST** `/api/entries`  
**Auth:** Bearer token

#### Request Body
```json
{
  "mood": "Vidám",
  "weather": "Napos",
  "sleep_quality": "Jó",
  "activities": "Sport",
  "health_action": "Mozgás",
  "note": "Ma remek napom volt!"
}
```

#### Response (201 Created)
```json
{
  "message": "Entry sikeresen létrehozva",
  "entry": {
    "entry_id": 3,
    "user_id": 1,
    "quote_id": 7,
    "mood": "Vidám",
    "weather": "Napos",
    "sleep_quality": "Jó",
    "activities": "Sport",
    "health_action": "Mozgás",
    "note": "Ma remek napom volt!",
    "created_at": "2025-11-20T19:00:00.000000Z",
    "updated_at": "2025-11-20T19:00:00.000000Z",
    "quote": {
      "quote_id": 7,
      "quote_category": "Vidám",
      "quote_text": "Élj úgy, mintha minden nap születésnapod lenne!",
      "author": "Ismeretlen"
    }
  }
}
```

#### Validáció
- `mood`: **nullable**, enum: `["Lehangolt", "Kiegyensúlyozott", "Vidám"]`
- `weather`: **kötelező**, enum: `["Napos", "Felhős", "Esős", "Szeles", "Havas"]`
- `sleep_quality`: **kötelező**, enum: `["Nagyon rossz", "Rossz", "Közepes", "Jó", "Kiváló"]`
- `activities`: **kötelező**, enum: `["Munka", "Tanulás", "Pihenés", "Sport", "Szórakozás", "Egyéb"]`
- `health_action`: **kötelező**, enum: `["Mozgás", "Egészséges étkezés", "Pihenés", "Semmi"]`
- `note`: **nullable**, string, max 1000 karakter

#### Quote generálás
- **Ha mood megadva:** Random quote az adott kategóriából
- **Ha mood NULL:** Random quote az összesből

---

### 4. Entry módosítása
**PUT/PATCH** `/api/entries/{id}`  
**Auth:** Bearer token

#### Request Body (csak a módosítandó mezők)
```json
{
  "mood": "Lehangolt",
  "note": "Módosított szöveg"
}
```

#### Response (200 OK)
```json
{
  "message": "Entry sikeresen frissítve",
  "entry": {
    "entry_id": 1,
    "mood": "Lehangolt",
    "weather": "Napos",
    "sleep_quality": "Jó",
    "activities": "Sport",
    "health_action": "Mozgás",
    "note": "Módosított szöveg",
    "quote": {
      "quote_id": 2,
      "quote_category": "Lehangolt",
      "quote_text": "Minden vihar után kisüt a nap.",
      "author": "Ismeretlen"
    }
  }
}
```

**Megjegyzés:** Ha mood változik → új quote generálódik!

---

### 5. Entry törlése (soft delete)
**DELETE** `/api/entries/{id}`  
**Auth:** Bearer token

#### Response (200 OK)
```json
{
  "message": "Entry sikeresen törölve"
}
```

**Megjegyzés:** Törölt entry-k nem jelennek meg a listában!

---

## 💬 Quote API

**Minden endpoint védett! Bearer token szükséges!**

### 1. Összes Quote
**GET** `/api/quotes`  
**Auth:** Bearer token

#### Response (200 OK)
```json
{
  "quotes": [
    {
      "quote_id": 1,
      "quote_category": "Lehangolt",
      "quote_text": "A legnehezebb napok után jönnek a legszebb holnapok.",
      "author": "Ismeretlen"
    },
    {
      "quote_id": 2,
      "quote_category": "Lehangolt",
      "quote_text": "Minden vihar után kisüt a nap.",
      "author": "Ismeretlen"
    },
    {
      "quote_id": 7,
      "quote_category": "Vidám",
      "quote_text": "A boldogság nem cél, hanem életmód.",
      "author": "Ismeretlen"
    }
  ]
}
```

---

### 2. Random Quote (mood szűrés opcionális)
**GET** `/api/quotes/random` vagy `/api/quotes/random?mood={mood}`  
**Auth:** Bearer token

#### Request példák
```
GET /api/quotes/random
GET /api/quotes/random?mood=Vidám
GET /api/quotes/random?mood=Lehangolt
GET /api/quotes/random?mood=Kiegyensúlyozott
```

#### Response (200 OK)
```json
{
  "quote": {
    "quote_id": 5,
    "quote_category": "Vidám",
    "quote_text": "A boldogság nem cél, hanem életmód.",
    "author": "Ismeretlen"
  }
}
```

#### Hiba (400 Bad Request)
```json
{
  "message": "Érvénytelen mood érték"
}
```

---

## ❌ Hibakezelés

### HTTP Status kódok

| Kód | Jelentés | Használat |
|-----|----------|-----------|
| **200** | OK | Sikeres GET, PUT, DELETE |
| **201** | Created | Sikeres POST |
| **400** | Bad Request | Érvénytelen paraméter |
| **401** | Unauthorized | Hiányzó/érvénytelen token |
| **404** | Not Found | Erőforrás nem található |
| **422** | Unprocessable Entity | Validációs hiba |
| **500** | Internal Server Error | Szerver hiba |

---

### Validációs hiba (422)
```json
{
  "message": "The weather field is required.",
  "errors": {
    "weather": ["The weather field is required."],
    "mood": ["The selected mood is invalid."]
  }
}
```

**Frontend feldolgozás:**
```javascript
if (response.status === 422) {
  const errors = response.data.errors;
  // Hibák megjelenítése input mezők mellett
}
```

---

### Auth hiba (401)
```json
{
  "message": "Unauthenticated."
}
```

**Frontend feldolgozás:**
```javascript
if (response.status === 401) {
  localStorage.removeItem('token');
  window.location.href = '/login';
}
```

---

## 📊 Adatmodellek (TypeScript/JavaScript)

### User
```typescript
interface User {
  user_id: number;
  name: string;
  email: string;
  email_verified_at: string | null;
  created_at: string;
  updated_at: string;
}
```

---

### Entry
```typescript
interface Entry {
  entry_id: number;
  user_id: number;
  quote_id: number | null;
  mood: 'Lehangolt' | 'Kiegyensúlyozott' | 'Vidám' | null;
  weather: 'Napos' | 'Felhős' | 'Esős' | 'Szeles' | 'Havas';
  sleep_quality: 'Nagyon rossz' | 'Rossz' | 'Közepes' | 'Jó' | 'Kiváló';
  activities: 'Munka' | 'Tanulás' | 'Pihenés' | 'Sport' | 'Szórakozás' | 'Egyéb';
  health_action: 'Mozgás' | 'Egészséges étkezés' | 'Pihenés' | 'Semmi';
  note: string | null;
  is_deleted: boolean;
  deleted_at: string | null;
  created_at: string;
  updated_at: string;
  quote?: Quote; // Opcionális relációs adat
}
```

---

### Quote
```typescript
interface Quote {
  quote_id: number;
  quote_category: 'Lehangolt' | 'Kiegyensúlyozott' | 'Vidám';
  quote_text: string;
  author: string;
  created_at: string;
  updated_at: string;
  deleted_at: string | null;
}
```

---

### Auth Response
```typescript
interface AuthResponse {
  message: string;
  user: User;
  token: string;
}
```

---

## 🔧 Példakód (Vanilla JS)

### Fetch wrapper (automatikus token hozzáadás)
```javascript
async function apiFetch(url, options = {}) {
  const token = localStorage.getItem('token');

  const headers = {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
    ...(token && { 'Authorization': `Bearer ${token}` }),
    ...options.headers
  };

  const response = await fetch(url, { ...options, headers });

  // 401 → logout
  if (response.status === 401) {
    localStorage.removeItem('token');
    window.location.href = '/login';
    throw new Error('Unauthenticated');
  }

  return response;
}
```

---

### Login példa
```javascript
async function login(email, password) {
  const response = await fetch('http://127.0.0.1:8000/api/login', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    },
    body: JSON.stringify({ email, password })
  });

  const data = await response.json();

  if (response.ok) {
    localStorage.setItem('token', data.token);
    localStorage.setItem('user', JSON.stringify(data.user));
    return data;
  } else {
    throw new Error(data.message);
  }
}
```

---

### Entry lista lekérése
```javascript
async function getEntries() {
  const token = localStorage.getItem('token');

  const response = await fetch('http://127.0.0.1:8000/api/entries', {
    headers: {
      'Accept': 'application/json',
      'Authorization': `Bearer ${token}`
    }
  });

  const data = await response.json();
  return data.entries;
}
```

---

### Entry létrehozása
```javascript
async function createEntry(entryData) {
  const token = localStorage.getItem('token');

  const response = await fetch('http://127.0.0.1:8000/api/entries', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'Authorization': `Bearer ${token}`
    },
    body: JSON.stringify(entryData)
  });

  const data = await response.json();

  if (response.ok) {
    return data.entry;
  } else if (response.status === 422) {
    // Validációs hibák kezelése
    console.error('Validation errors:', data.errors);
    throw new Error(data.message);
  } else {
    throw new Error(data.message);
  }
}

// Használat
const newEntry = {
  mood: 'Vidám',
  weather: 'Napos',
  sleep_quality: 'Jó',
  activities: 'Sport',
  health_action: 'Mozgás',
  note: 'Ma remek napom volt!'
};

createEntry(newEntry)
  .then(entry => console.log('Entry létrehozva:', entry))
  .catch(error => console.error('Hiba:', error));
```

---

## 📌 Fontos megjegyzések

1. **Token tárolás:** localStorage vagy sessionStorage
2. **Token formátum:** `Bearer {token}` (szóköz után a token!)
3. **CORS:** Laravel backend CORS engedélyezve frontend számára
4. **Dátum formátum:** ISO 8601 (YYYY-MM-DDTHH:mm:ss.000000Z)
5. **Enum értékek:** PONTOSAN úgy írandók, ékezetes betűkkel!
6. **Soft delete:** Törölt entry-k automatikusan kiszűrve a listákból
7. **Quote generálás:** Automatikus entry létrehozásnál és mood változáskor

---

## 🚀 Gyors indítás

```javascript
// 1. Login
const loginData = await login('test@example.com', 'password123');
console.log('Token:', loginData.token);

// 2. Entry lista
const entries = await getEntries();
console.log('Entries:', entries);

// 3. Új entry
const newEntry = await createEntry({
  mood: 'Vidám',
  weather: 'Napos',
  sleep_quality: 'Jó',
  activities: 'Sport',
  health_action: 'Mozgás',
  note: 'Teszt bejegyzés'
});
console.log('New entry:', newEntry);

// 4. Random quote
const quote = await getRandomQuote('Vidám');
console.log('Quote:', quote.quote_text);
```

---

**Készítette:** Backend fejlesztő és tesztelő csapat: Bodvánszki Zoltán és Szerencsés Viktor  
**Kapcsolat:** [motimpulse](https://github.com/ZmintZolika/motimpulse)
**Dokumentáció verzió:** 1.0 (2025-11-20)

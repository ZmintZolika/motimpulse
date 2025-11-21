# MotImpulse API Dokumentáció - Angular Fejlesztőknek

**Backend API:** Laravel 11 + MySQL + Sanctum Authentication

Ez a dokumentum minden információt tartalmaz, ami szükséges az Angular frontend fejlesztéséhez.

---

## 📋 Tartalomjegyzék

1. [Gyors Áttekintés](#gyors-áttekintés)
2. [API Base URL](#api-base-url)
3. [Autentikáció](#autentikáció)
4. [TypeScript Interface-ek](#typescript-interface-ek)
5. [API Endpoint-ok](#api-endpoint-ok)
6. [Hibakezelés](#hibakezelés)
7. [CORS Konfiguráció](#cors-konfiguráció)
8. [Környezeti Változók](#környezeti-változók)
9. [Hasznos Tippek](#hasznos-tippek)

---

## 🚀 Gyors Áttekintés

### Alapvető információk

- **Backend framework:** Laravel 11
- **Autentikáció:** Laravel Sanctum (Bearer Token)
- **API stílus:** RESTful
- **Válasz formátum:** JSON
- **Dátum formátum:** `YYYY-MM-DD` (ISO 8601)
- **Rate limiting:** Nincs (jelenleg korlátlan)

### Működési folyamat

1. **Regisztráció/Login** → Token generálás
2. **Token tárolás** localStorage-ban
3. **Token használat** minden védett endpoint-nál (`Authorization: Bearer {token}`)
4. **Logout** → Token törlés

---

## 🌐 API Base URL

### Development

```

http://localhost:8000/api

```

### Production (később)

```

https://your-production-domain.com/api

```

---

## 🔑 Autentikáció

### Token-alapú autentikáció (Laravel Sanctum)

**Védett endpoint-ok:**
- Minden `/api/day-entries/*` endpoint
- `/api/user`
- `/api/logout`

**Nyilvános endpoint-ok:**
- `/api/register`
- `/api/login`
- `/api/quotes`
- `/api/quotes/random`

### Token használat HTTP kérésekben

**Header:**
```

Authorization: Bearer {token}

```

**Angular HttpClient példa:**

```

import { HttpHeaders } from '@angular/common/http';

const token = localStorage.getItem('auth_token');
const headers = new HttpHeaders({
'Authorization': `Bearer ${token}`,
'Content-Type': 'application/json',
'Accept': 'application/json'
});

this.http.get(`${environment.apiUrl}/user`, { headers });

```

### Token tárolás

**Ajánlott:** `localStorage`

```

// Login után
localStorage.setItem('auth_token', response.token);

// Token lekérése
const token = localStorage.getItem('auth_token');

// Logout után
localStorage.removeItem('auth_token');

```

---

## 📘 TypeScript Interface-ek

### User Interface

```

export interface User {
id: number;
name: string;
email: string;
email_verified_at: string | null;
created_at: string;
updated_at: string;
}

```

### Auth Response Interface

```

export interface AuthResponse {
user: User;
token: string;
token_type: 'Bearer';
}

```

### Login Request Interface

```

export interface LoginRequest {
email: string;
password: string;
}

```

### Register Request Interface

```

export interface RegisterRequest {
name: string;
email: string;
password: string;
password_confirmation: string;
}

```

### Day Entry Interface

```

export interface DayEntry {
id: number;
user_id: number;
date: string; // YYYY-MM-DD
mood: number; // 1-10
weather: 'Napos' | 'Felhos' | 'Esos' | 'Szeles' | 'Havas' | null;
sleep_quality: 'Nagyon rossz' | 'Rossz' | 'Kozepes' | 'Jo' | 'Kivalo' | null;
activity: 'Munka' | 'Tanulas' | 'Pihenes' | 'Sport' | 'Szorakozas' | 'Egyeb' | null;
health_action: 'Mozgas' | 'Egeszseges etkezes' | 'Pihenes' | 'Semmi' | null;
score: number | null; // 1-10
note: string | null;
deleted_at: string | null;
created_at: string;
updated_at: string;
}

```

### Day Entry Request Interface

```

export interface DayEntryRequest {
date: string; // YYYY-MM-DD
mood: number; // 1-10
weather?: 'Napos' | 'Felhos' | 'Esos' | 'Szeles' | 'Havas';
sleep_quality?: 'Nagyon rossz' | 'Rossz' | 'Kozepes' | 'Jo' | 'Kivalo';
activity?: 'Munka' | 'Tanulas' | 'Pihenes' | 'Sport' | 'Szorakozas' | 'Egyeb';
health_action?: 'Mozgas' | 'Egeszseges etkezes' | 'Pihenes' | 'Semmi';
score?: number; // 1-10
note?: string;
}

```

### Motivational Quote Interface

```

export interface MotivationalQuote {
id: number;
category: number; // 1-10
text: string;
author: string;
deleted_at: string | null;
created_at: string;
updated_at: string;
}

```

---

## 📡 API Endpoint-ok

### 1. Authentication Endpoints

---

#### 1.1. Regisztráció

**POST** `/api/register`

**Védelem:** Nincs

**Request Body:**
```

{
name: string;
email: string;
password: string;
password_confirmation: string;
}

```

**Példa:**
```

const registerData: RegisterRequest = {
name: 'Test User',
email: 'test@example.com',
password: 'password123',
password_confirmation: 'password123'
};

this.http.post<AuthResponse>(`${environment.apiUrl}/register`, registerData)
.subscribe(response => {
localStorage.setItem('auth_token', response.token);
console.log('User registered:', response.user);
});

```

**Response (201 Created):**
```

{
"user": {
"id": 1,
"name": "Test User",
"email": "test@example.com",
"created_at": "2025-10-13T18:00:00.000000Z",
"updated_at": "2025-10-13T18:00:00.000000Z"
},
"token": "1|abc123xyz...",
"token_type": "Bearer"
}

```

**Validációs szabályok:**
- `name`: kötelező, string, min 2 karakter
- `email`: kötelező, valid email formátum, egyedi
- `password`: kötelező, min 8 karakter
- `password_confirmation`: kötelező, egyeznie kell a `password`-del

---

#### 1.2. Bejelentkezés

**POST** `/api/login`

**Védelem:** Nincs

**Request Body:**
```

{
email: string;
password: string;
}

```

**Példa:**
```

const loginData: LoginRequest = {
email: 'test@example.com',
password: 'password123'
};

this.http.post<AuthResponse>(`${environment.apiUrl}/login`, loginData)
.subscribe(response => {
localStorage.setItem('auth_token', response.token);
console.log('User logged in:', response.user);
});

```

**Response (200 OK):**
```

{
"user": {
"id": 1,
"name": "Test User",
"email": "test@example.com",
"email_verified_at": null,
"created_at": "2025-10-13T18:00:00.000000Z",
"updated_at": "2025-10-13T18:00:00.000000Z"
},
"token": "2|xyz789abc...",
"token_type": "Bearer"
}

```

**Hibás bejelentkezés (401 Unauthorized):**
```

{
"message": "Invalid credentials"
}

```

---

#### 1.3. Kijelentkezés

**POST** `/api/logout`

**Védelem:** Bearer Token szükséges

**Request Body:** Nincs

**Headers:**
```

Authorization: Bearer {token}

```

**Példa:**
```

const token = localStorage.getItem('auth_token');
const headers = new HttpHeaders({
'Authorization': `Bearer ${token}`
});

this.http.post(`${environment.apiUrl}/logout`, {}, { headers })
.subscribe(() => {
localStorage.removeItem('auth_token');
console.log('Logged out successfully');
});

```

**Response (200 OK):**
```

{
"message": "Logged out successfully"
}

```

---

#### 1.4. Bejelentkezett felhasználó adatai

**GET** `/api/user`

**Védelem:** Bearer Token szükséges

**Headers:**
```

Authorization: Bearer {token}

```

**Példa:**
```

const token = localStorage.getItem('auth_token');
const headers = new HttpHeaders({
'Authorization': `Bearer ${token}`
});

this.http.get<User>(`${environment.apiUrl}/user`, { headers })
.subscribe(user => {
console.log('Current user:', user);
});

```

**Response (200 OK):**
```

{
"id": 1,
"name": "Test User",
"email": "test@example.com",
"email_verified_at": null,
"created_at": "2025-10-13T18:00:00.000000Z",
"updated_at": "2025-10-13T18:00:00.000000Z"
}

```

---

### 2. Motivational Quotes Endpoints

---

#### 2.1. Összes idézet lekérése

**GET** `/api/quotes`

**Védelem:** Nincs

**Példa:**
```

this.http.get<MotivationalQuote[]>(`${environment.apiUrl}/quotes`)
.subscribe(quotes => {
console.log('All quotes:', quotes);
});

```

**Response (200 OK):**
```

[
{
"id": 1,
"category": 1,
"text": "Minden nehézség magában hordozza a lehetőséget.",
"author": "Albert Einstein",
"deleted_at": null,
"created_at": "2025-10-13T18:00:00.000000Z",
"updated_at": "2025-10-13T18:00:00.000000Z"
},
...
]

```

---

#### 2.2. Véletlenszerű idézet

**GET** `/api/quotes/random`

**Védelem:** Nincs

**Példa:**
```

this.http.get<MotivationalQuote>(`${environment.apiUrl}/quotes/random`)
.subscribe(quote => {
console.log('Random quote:', quote);
});

```

**Response (200 OK):**
```

{
"id": 7,
"category": 4,
"text": "Az út ezer mérföldre is egyetlen lépéssel kezdődik.",
"author": "Lao Ce",
"deleted_at": null,
"created_at": "2025-10-13T18:00:00.000000Z",
"updated_at": "2025-10-13T18:00:00.000000Z"
}

```

---

#### 2.3. Véletlenszerű idézet kategória szerint

**GET** `/api/quotes/random?category={category}`

**Védelem:** Nincs

**Query paraméter:**
- `category` (integer, 1-10): Hangulat skála alapján

**Kategóriák:**
- `1-2`: Rossz hangulat
- `3-4`: Közepes-alacsony hangulat
- `5-6`: Semleges hangulat
- `7-8`: Jó hangulat
- `9-10`: Kiváló hangulat

**Példa:**
```

const category = 10;
this.http.get<MotivationalQuote>(`${environment.apiUrl}/quotes/random?category=${category}`)
.subscribe(quote => {
console.log('Random quote for category 10:', quote);
});

```

**Response (200 OK):**
```

{
"id": 19,
"category": 10,
"text": "Ragyogj, és világítsd meg mások útját is!",
"author": "Unknown",
"deleted_at": null,
"created_at": "2025-10-13T18:00:00.000000Z",
"updated_at": "2025-10-13T18:00:00.000000Z"
}

```

---

### 3. Day Entries Endpoints

**MINDEN ENDPOINT VÉDETT! Bearer Token szükséges minden kérésnél.**

---

#### 3.1. Összes bejegyzés lekérése

**GET** `/api/day-entries`

**Védelem:** Bearer Token szükséges

**Headers:**
```

Authorization: Bearer {token}

```

**Példa:**
```

const token = localStorage.getItem('auth_token');
const headers = new HttpHeaders({
'Authorization': `Bearer ${token}`
});

this.http.get<DayEntry[]>(`${environment.apiUrl}/day-entries`, { headers })
.subscribe(entries => {
console.log('All day entries:', entries);
});

```

**Response (200 OK):**
```

[
{
"id": 1,
"user_id": 1,
"date": "2025-10-13",
"mood": 8,
"weather": "Napos",
"sleep_quality": "Jo",
"activity": "Sport",
"health_action": "Mozgas",
"score": 9,
"note": "Remek nap volt!",
"deleted_at": null,
"created_at": "2025-10-13T18:00:00.000000Z",
"updated_at": "2025-10-13T18:00:00.000000Z"
}
]

```

**Üres lista (nincs bejegyzés):**
```

[]

```

---

#### 3.2. Új bejegyzés létrehozása

**POST** `/api/day-entries`

**Védelem:** Bearer Token szükséges

**Headers:**
```

Authorization: Bearer {token}
Content-Type: application/json

```

**Request Body:**
```

{
date: string;        // YYYY-MM-DD formátum, kötelező
mood: number;        // 1-10, kötelező
weather?: string;    // ENUM, opcionális
sleep_quality?: string;  // ENUM, opcionális
activity?: string;   // ENUM, opcionális
health_action?: string;  // ENUM, opcionális
score?: number;      // 1-10, opcionális
note?: string;       // szöveg, opcionális
}

```

**Érvényes ENUM értékek:**

- **weather:** `Napos`, `Felhos`, `Esos`, `Szeles`, `Havas`
- **sleep_quality:** `Nagyon rossz`, `Rossz`, `Kozepes`, `Jo`, `Kivalo`
- **activity:** `Munka`, `Tanulas`, `Pihenes`, `Sport`, `Szorakozas`, `Egyeb`
- **health_action:** `Mozgas`, `Egeszseges etkezes`, `Pihenes`, `Semmi`

**Példa:**
```

const newEntry: DayEntryRequest = {
date: '2025-10-13',
mood: 8,
weather: 'Napos',
sleep_quality: 'Jo',
activity: 'Sport',
health_action: 'Mozgas',
score: 9,
note: 'Ma remek napom volt!'
};

const token = localStorage.getItem('auth_token');
const headers = new HttpHeaders({
'Authorization': `Bearer ${token}`,
'Content-Type': 'application/json'
});

this.http.post<DayEntry>(`${environment.apiUrl}/day-entries`, newEntry, { headers })
.subscribe(entry => {
console.log('Day entry created:', entry);
});

```

**Angular Dátum formázás:**
```

// Mai dátum YYYY-MM-DD formátumban
const today = new Date().toISOString().split('T');

// DatePipe használata
import { DatePipe } from '@angular/common';
const datePipe = new DatePipe('en-US');
const formattedDate = datePipe.transform(new Date(), 'yyyy-MM-dd');

```

**Response (201 Created):**
```

{
"id": 1,
"user_id": 1,
"date": "2025-10-13",
"mood": 8,
"weather": "Napos",
"sleep_quality": "Jo",
"activity": "Sport",
"health_action": "Mozgas",
"score": 9,
"note": "Ma remek napom volt!",
"deleted_at": null,
"created_at": "2025-10-13T18:00:00.000000Z",
"updated_at": "2025-10-13T18:00:00.000000Z"
}

```

**Validációs hiba (422 Unprocessable Entity):**
```

{
"message": "The date field is required. (and 1 more error)",
"errors": {
"date": ["The date field is required."],
"mood": ["The mood field is required."]
}
}

```

---

#### 3.3. Egy bejegyzés lekérése ID alapján

**GET** `/api/day-entries/{id}`

**Védelem:** Bearer Token szükséges

**URL paraméter:**
- `id` (integer): Bejegyzés ID-ja

**Headers:**
```

Authorization: Bearer {token}

```

**Példa:**
```

const entryId = 1;
const token = localStorage.getItem('auth_token');
const headers = new HttpHeaders({
'Authorization': `Bearer ${token}`
});

this.http.get<DayEntry>(`${environment.apiUrl}/day-entries/${entryId}`, { headers })
.subscribe(entry => {
console.log('Day entry:', entry);
});

```

**Response (200 OK):**
```

{
"id": 1,
"user_id": 1,
"date": "2025-10-13",
"mood": 8,
"weather": "Napos",
"sleep_quality": "Jo",
"activity": "Sport",
"health_action": "Mozgas",
"score": 9,
"note": "Remek nap volt!",
"deleted_at": null,
"created_at": "2025-10-13T18:00:00.000000Z",
"updated_at": "2025-10-13T18:00:00.000000Z"
}

```

**Nem található (404 Not Found):**
```

{
"message": "No query results for model [App\\Models\\DayEntry] 999"
}

```

---

#### 3.4. Bejegyzés módosítása

**PUT** `/api/day-entries/{id}`

**Védelem:** Bearer Token szükséges

**URL paraméter:**
- `id` (integer): Bejegyzés ID-ja

**Headers:**
```

Authorization: Bearer {token}
Content-Type: application/json

```

**Request Body:** Ugyanaz, mint a POST-nál (minden mező kötelező!)

**Példa:**
```

const entryId = 1;
const updatedEntry: DayEntryRequest = {
date: '2025-10-13',
mood: 9,
weather: 'Napos',
sleep_quality: 'Kivalo',
activity: 'Sport',
health_action: 'Egeszseges etkezes',
score: 10,
note: 'Még jobb nap lett!'
};

const token = localStorage.getItem('auth_token');
const headers = new HttpHeaders({
'Authorization': `Bearer ${token}`,
'Content-Type': 'application/json'
});

this.http.put<DayEntry>(`${environment.apiUrl}/day-entries/${entryId}`, updatedEntry, { headers })
.subscribe(entry => {
console.log('Day entry updated:', entry);
});

```

**Response (200 OK):**
```

{
"id": 1,
"user_id": 1,
"date": "2025-10-13",
"mood": 9,
"weather": "Napos",
"sleep_quality": "Kivalo",
"activity": "Sport",
"health_action": "Egeszseges etkezes",
"score": 10,
"note": "Még jobb nap lett!",
"deleted_at": null,
"created_at": "2025-10-13T18:00:00.000000Z",
"updated_at": "2025-10-13T19:00:00.000000Z"
}

```

---

#### 3.5. Bejegyzés törlése (Soft Delete)

**DELETE** `/api/day-entries/{id}`

**Védelem:** Bearer Token szükséges

**URL paraméter:**
- `id` (integer): Bejegyzés ID-ja

**Headers:**
```

Authorization: Bearer {token}

```

**Példa:**
```

const entryId = 1;
const token = localStorage.getItem('auth_token');
const headers = new HttpHeaders({
'Authorization': `Bearer ${token}`
});

this.http.delete(`${environment.apiUrl}/day-entries/${entryId}`, { headers })
.subscribe(() => {
console.log('Day entry deleted');
});

```

**Response (200 OK):**
```

{
"message": "Entry deleted successfully"
}

```

**Fontos:** Ez egy **soft delete**, a bejegyzés nem törlődik véglegesen, csak `deleted_at` időbélyeget kap. GET kéréseknél nem jelenik meg többé.

---

## 🚨 Hibakezelés

### HTTP Status Kódok

| Kód | Jelentés | Mikor történik |
|-----|----------|----------------|
| 200 | OK | Sikeres GET, PUT, DELETE |
| 201 | Created | Sikeres POST (új resource létrehozva) |
| 401 | Unauthorized | Érvénytelen/hiányzó token |
| 404 | Not Found | Resource nem található |
| 422 | Unprocessable Entity | Validációs hiba |
| 500 | Internal Server Error | Szerver oldali hiba |

---

### Hiba struktúrák

#### 401 Unauthenticated

```

{
"message": "Unauthenticated."
}

```

**Mikor történik:**
- Hiányzó `Authorization` header
- Érvénytelen token
- Lejárt/törölt token

**Angular kezelés:**
```

this.http.get(url, { headers }).subscribe(
response => { /* success */ },
error => {
if (error.status === 401) {
// Redirect login oldalra
localStorage.removeItem('auth_token');
this.router.navigate(['/login']);
}
}
);

```

---

#### 422 Validációs Hiba

```

{
"message": "The email field is required. (and 2 more errors)",
"errors": {
"email": [
"The email field is required."
],
"password": [
"The password field is required."
],
"date": [
"The date field must be a valid date."
]
}
}

```

**Angular kezelés:**
```

this.http.post(url, data, { headers }).subscribe(
response => { /* success */ },
error => {
if (error.status === 422) {
const validationErrors = error.error.errors;

      // Mezőnkénti hibák megjelenítése
      Object.keys(validationErrors).forEach(field => {
        console.log(`${field}: ${validationErrors[field]}`);
      });
    }
    }
);

```

---

#### 404 Not Found

```

{
"message": "No query results for model [App\\Models\\DayEntry] 999"
}

```

**Mikor történik:**
- Nem létező ID-val hívott endpoint
- Más user bejegyzését próbálod lekérni

---

#### 500 Internal Server Error

```

{
"message": "Server Error"
}

```

**Mikor történik:**
- Backend oldali hiba
- Adatbázis kapcsolati hiba
- Váratlan exception

---

### Angular HttpInterceptor példa

**Globális hibakezelés:**

```

import { Injectable } from '@angular/core';
import { HttpInterceptor, HttpRequest, HttpHandler, HttpErrorResponse } from '@angular/common/http';
import { Router } from '@angular/router';
import { catchError } from 'rxjs/operators';
import { throwError } from 'rxjs';

@Injectable()
export class ErrorInterceptor implements HttpInterceptor {
constructor(private router: Router) {}

intercept(req: HttpRequest<any>, next: HttpHandler) {
return next.handle(req).pipe(
catchError((error: HttpErrorResponse) => {
if (error.status === 401) {
// Token lejárt vagy érvénytelen
localStorage.removeItem('auth_token');
this.router.navigate(['/login']);
}

        if (error.status === 422) {
          // Validációs hibák
          console.error('Validation errors:', error.error.errors);
        }
        
        if (error.status === 500) {
          // Szerver hiba
          console.error('Server error:', error.error.message);
        }
        
        return throwError(() => error);
      })
    );
    }
}

```

---

## 🌐 CORS Konfiguráció

### Backend CORS beállítások

A Laravel backend **engedélyezi a CORS kéréseket** a következő beállításokkal:

**Engedélyezett origin-ek:**
- `http://localhost:4200` (Angular dev server)
- `http://localhost:3000`
- További origin-ek hozzáadhatók a `config/cors.php` fájlban

**Engedélyezett HTTP metódusok:**
- GET
- POST
- PUT
- DELETE
- OPTIONS

**Engedélyezett header-ek:**
- `Authorization`
- `Content-Type`
- `Accept`
- `X-Requested-With`

**Credentials:** Engedélyezve (cookies/session támogatás)

---

### Angular HttpClient konfiguráció

**Alapértelmezett header-ek beállítása:**

```

import { HttpHeaders } from '@angular/common/http';

const headers = new HttpHeaders({
'Content-Type': 'application/json',
'Accept': 'application/json'
});

```

**Token hozzáadása:**

```

const token = localStorage.getItem('auth_token');
if (token) {
headers = headers.set('Authorization', `Bearer ${token}`);
}

```

---

### HttpInterceptor token automatikus hozzáadásához

```

import { Injectable } from '@angular/core';
import { HttpInterceptor, HttpRequest, HttpHandler } from '@angular/common/http';

@Injectable()
export class AuthInterceptor implements HttpInterceptor {
intercept(req: HttpRequest<any>, next: HttpHandler) {
const token = localStorage.getItem('auth_token');

    if (token) {
      const cloned = req.clone({
        headers: req.headers.set('Authorization', `Bearer ${token}`)
      });
      return next.handle(cloned);
    }
    
    return next.handle(req);
    }
}

```

**Regisztrálás `app.config.ts`-ben:**

```

import { HTTP_INTERCEPTORS } from '@angular/common/http';

export const appConfig: ApplicationConfig = {
providers: [
provideHttpClient(withInterceptorsFromDi()),
{ provide: HTTP_INTERCEPTORS, useClass: AuthInterceptor, multi: true },
{ provide: HTTP_INTERCEPTORS, useClass: ErrorInterceptor, multi: true }
]
};

```

---

## 🔧 Környezeti Változók

### `src/environments/environment.ts` (Development)

```

export const environment = {
production: false,
apiUrl: 'http://localhost:8000/api'
};

```

### `src/environments/environment.prod.ts` (Production)

```

export const environment = {
production: true,
apiUrl: 'https://your-production-domain.com/api'
};

```

### Használat Angular service-ben

```

import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../environments/environment';

@Injectable({
providedIn: 'root'
})
export class ApiService {
private apiUrl = environment.apiUrl;

constructor(private http: HttpClient) {}

getQuotes() {
return this.http.get(`${this.apiUrl}/quotes`);
}
}

```

---

## 💡 Hasznos Tippek

### 1. Dátum formázás

**TypeScript/Angular:**

```

// Mai dátum YYYY-MM-DD formátumban
const today = new Date().toISOString().split('T');
// '2025-10-13'

// Konkrét dátum formázás
const date = new Date(2025, 9, 13); // Hónap 0-indexelt!
const formatted = date.toISOString().split('T');
// '2025-10-13'

// DatePipe használata template-ben
{{ dateValue | date:'yyyy-MM-dd' }}

```

---

### 2. ENUM értékek Angular-ban

**TypeScript ENUM definiálás:**

```

export enum Weather {
Napos = 'Napos',
Felhos = 'Felhos',
Esos = 'Esos',
Szeles = 'Szeles',
Havas = 'Havas'
}

export enum SleepQuality {
NagyonRossz = 'Nagyon rossz',
Rossz = 'Rossz',
Kozepes = 'Kozepes',
Jo = 'Jo',
Kivalo = 'Kivalo'
}

export enum Activity {
Munka = 'Munka',
Tanulas = 'Tanulas',
Pihenes = 'Pihenes',
Sport = 'Sport',
Szorakozas = 'Szorakozas',
Egyeb = 'Egyeb'
}

export enum HealthAction {
Mozgas = 'Mozgas',
EgeszsegEtkezes = 'Egeszseges etkezes',
Pihenes = 'Pihenes',
Semmi = 'Semmi'
}

```

**Select dropdown template:**

```

<select [(ngModel)]="dayEntry.weather">
<option value="">Válassz időjárást</option>

  <option *ngFor="let weather of weatherOptions" [value]="weather">
    {{ weather }}
  </option>
</select>

```

**Component:**

```

export class DayEntryFormComponent {
weatherOptions = Object.values(Weather);
sleepQualityOptions = Object.values(SleepQuality);
activityOptions = Object.values(Activity);
healthActionOptions = Object.values(HealthAction);
}

```

---

### 3. Token expiration ellenőrzés

**Jelenleg a Sanctum token-ek NEM járnak le.**

Ha később token expiration-t implementálunk:

```

// Token decode (jwt-decode library)
import jwtDecode from 'jwt-decode';

isTokenExpired(token: string): boolean {
try {
const decoded: any = jwtDecode(token);
const expiry = decoded.exp * 1000; // milliszekundumra konvertálás
return Date.now() > expiry;
} catch {
return true;
}
}

```

---

### 4. Loading state kezelés

```

export class DayEntriesComponent {
isLoading = false;
entries: DayEntry[] = [];

loadEntries() {
this.isLoading = true;

    this.apiService.getDayEntries().subscribe(
      data => {
        this.entries = data;
        this.isLoading = false;
      },
      error => {
        console.error(error);
        this.isLoading = false;
      }
    );
    }
}

```

**Template:**

```

<div *ngIf="isLoading">Betöltés...</div>

<div *ngIf="!isLoading">
  <!-- Adatok megjelenítése -->
</div>
```

---

### 5. RxJS operátorok használata

```

import { catchError, tap, map } from 'rxjs/operators';
import { throwError } from 'rxjs';

getDayEntries(): Observable<DayEntry[]> {
return this.http.get<DayEntry[]>(`${this.apiUrl}/day-entries`, { headers })
.pipe(
tap(data => console.log('Fetched entries:', data)),
map(entries => entries.filter(e => e.deleted_at === null)),
catchError(error => {
console.error('Error fetching entries:', error);
return throwError(() => error);
})
);
}

```

---

### 6. Mood alapú idézet lekérés

```

getQuoteByMood(mood: number): Observable<MotivationalQuote> {
// Mood 1-10 → category 1-10
return this.http.get<MotivationalQuote>(
`${this.apiUrl}/quotes/random?category=${mood}`
);
}

```

**Használat:**

```

onMoodChange(mood: number) {
this.apiService.getQuoteByMood(mood).subscribe(quote => {
this.motivationalQuote = quote;
});
}

```

---

### 7. Form validáció Angular Reactive Forms-szal

```

import { FormBuilder, FormGroup, Validators } from '@angular/forms';

export class DayEntryFormComponent {
entryForm: FormGroup;

constructor(private fb: FormBuilder) {
this.entryForm = this.fb.group({
date: ['', [Validators.required]],
mood: ['', [Validators.required, Validators.min(1), Validators.max(10)]],
weather: [''],
sleep_quality: [''],
activity: [''],
health_action: [''],
score: ['', [Validators.min(1), Validators.max(10)]],
note: ['']
});
}

onSubmit() {
if (this.entryForm.valid) {
this.apiService.createDayEntry(this.entryForm.value).subscribe(
response => console.log('Success:', response),
error => console.error('Error:', error)
);
}
}
}

```

---

## 📞 Kapcsolat és Támogatás

Ha bármilyen kérdésed van az API használatával kapcsolatban:

1. Ellenőrizd ezt a dokumentációt
2. Nézd meg a backend `README.md` fájlt
3. Tesztelj Thunder Client-tel
4. Ellenőrizd a Laravel log-okat (`storage/logs/laravel.log`)

---

## ✅ Checklist Angular fejlesztőknek

### Projekt kezdés előtt

- [ ] Backend fut (`php artisan serve`)
- [ ] Adatbázis migráció futott
- [ ] Seeders futottak (teszt user + idézetek)
- [ ] `environment.ts` beállítva (`apiUrl`)
- [ ] HttpClient importálva
- [ ] Interceptor-ok regisztrálva

### Fejlesztés során

- [ ] Token tárolás implementálva (localStorage)
- [ ] Auth guard készült (védett route-ok)
- [ ] Interface-ek létrehozva TypeScript-ben
- [ ] Service-ek készültek (AuthService, ApiService)
- [ ] Error handling implementálva
- [ ] Loading state-ek kezelve
- [ ] Form validáció működik

### Tesztelés

- [ ] Login/Register működik
- [ ] Token automatikusan hozzáadódik kérésekhez
- [ ] CRUD műveletek működnek (day entries)
- [ ] Hibakezelés működik (401, 422, 404, 500)
- [ ] Logout törli a token-t
- [ ] Motivációs idézetek megjelennek

---

**Készítve ❤️-vel Laravel 11 + Angular fejlesztőknek**

**Utolsó frissítés:** 2025-10-13
```


***

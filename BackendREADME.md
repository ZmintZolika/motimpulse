# MotImpulse Backend API

[![Laravel](https://img.shields.io/badge/Laravel-11-red.svg)](https://laravel.com)  
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://www.php.net/)  
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange.svg)](https://www.mysql.com/)  
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

> Motivációs és hangulatkövető RESTful backend API Laravel 11-el, Sanctum autentikációval.

---

## 📋 Tartalomjegyzék

- [Áttekintés](#áttekintés)
- [Fő funkciók](#fő-funkciók)
- [Technológiai környezet](#technológiai-környezet)
- [Követelmények](#követelmények)
- [Telepítés](#telepítés)
- [Konfiguráció](#konfiguráció)
- [Adatbázis szerkezet](#adatbázis-szerkezet)
- [API végpontok](#api-végpontok)
- [Validáció és hibakezelés](#validáció-és-hibakezelés)
- [Tesztelés](#tesztelés)
- [Fejlesztési ajánlások](#fejlesztési-ajánlások)
- [Üzembe helyezés (produkció)](#üzembe-helyezés-produkció)
- [Közreműködés](#közreműködés)
- [Licenc és kapcsolattartás](#licenc-és-kapcsolattartás)

---

## 🎯 Áttekintés

A MotImpulse backend egy biztonságos, RESTful API, amely naplózza a felhasználók hangulatát és egészségügyi állapotát, valamint motivációs idézeteket rendel hozzájuk. A backend Laravel 11 és Sanctum technológiával készült.

---

## ✨ Fő funkciók

- **Felhasználói regisztráció, login, logout** Laravel Sanctum tokenekkel
- **Bejegyzéskezelés (Entry CRUD):** hangulat, időjárás, alvásminőség, tevékenységek, egészségügyi akciók, megjegyzések kezelése
- **Soft delete:** logikailag törlés bejegyzéseknél
- **Motivációs idézetek kezelése:** mood szerinti idézetválasztás
- **API végpontok hitelesítése tokennel**
- **Részletes validáció és hibakezelés magyar nyelven**

---

## 🖥️ Technológiai környezet

- PHP 8.2+
- Laravel 11.x
- MySQL 8.0+ / MariaDB 10.5+
- Laravel Sanctum autentikáció
- RESTful API JSON válaszokkal

---

## 📦 Követelmények

- Composer 2.5+
- Git
- (Fejlesztéshez) Node.js, npm (frontend)

---

## 🚀 Telepítés

1. Klónozd a repót:  
git clone <a repo URL>
cd motimpulse-backend

text
2. Telepítsd a PHP függőségeket:  
composer install

text
3. Másold és szerkeszd a környezeti konfigurációt:  
cp .env.example .env

text
4. Generáld az alkalmazás kulcsát:  
php artisan key:generate

text
5. Készítsd el az adatbázist (MySQL):  
CREATE DATABASE motimpulse CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

text
6. Futtasd a migrációkat:  
php artisan migrate

text
7. Töltsd fel a quote adatokat:  
php artisan db:seed --class=QuoteSeeder

text
8. Indítsd el a fejlesztői szervert:  
php artisan serve

text

---

## ⚙️ Konfiguráció

- `config/cors.php` - CORS beállítások fejlesztői és produkciós környezethez  
- `.env` változók: adatbázis hozzáférés, Sanctum állapot, app URL, stb.

---

## 🗄️ Adatbázis szerkezet

### users tábla

| Mező | Típus | Leírás |
|-------|---------|--------------|
| user_id | INT PK | Felhasználó azonosító |
| name | VARCHAR(100) | Név |
| email | VARCHAR(150) | Egyedi email |
| password | VARCHAR(255) | Jelszó (bcrypt) |

### entries tábla

| Mező | Típus | Leírás |
|-------|---------|--------------|
| entry_id | INT PK | Bejegyzés azonosító |
| user_id | INT FK | Tulajdonos user ID |
| quote_id | INT FK, nullable | Hozzárendelt idézet |
| mood | ENUM, nullable | Hangulat (Lehangolt, Kiegyensúlyozott, Vidám) |
| weather | ENUM | Időjárás |
| sleep_quality | ENUM | Alvásminőség |
| activities | ENUM | Tevékenység |
| health_action | ENUM | Egészségügyi akció |
| note | TEXT, nullable | Megjegyzések |
| is_deleted | BOOLEAN | Soft delete flag |
| deleted_at | TIMESTAMP nullable | Törlés dátuma |

### quotes tábla

| Mező | Típus | Leírás |
|-------|---------|--------------|
| quote_id | INT PK | Idézet azonosító |
| quote_category | ENUM | Kategória (mood) egybeesik |
| quote_text | TEXT | Idézet szövege |
| author | VARCHAR(100) | Szerző |

---

## 📚 API végpontok

### Auth

| Művelet | Endpoint | Auth | Leírás |
|---|----------|------|---------|
| Regisztráció | POST `/api/register` | Nem | Új felhasználó létrehozása |
| Bejelentkezés | POST `/api/login` | Nem | Token kérés |
| Kijelentkezés | POST `/api/logout` | Igen | Token törlése |

### Entry

| Művelet | Endpoint | Auth | Leírás |
|---|----------|------|---------|
| Listázás | GET `/api/entries` | Igen | Saját bejegyzések listája |
| Lekérés | GET `/api/entries/{id}` | Igen | Egy bejegyzés részlete |
| Létrehozás | POST `/api/entries` | Igen | Új bejegyzés (automatikus quote) |
| Módosítás | PUT/PATCH `/api/entries/{id}` | Igen | Bejegyzés módosítása (mood változás → új quote) |
| Törlés | DELETE `/api/entries/{id}` | Igen | Soft delete |

### Quote

| Művelet | Endpoint | Auth | Leírás |
|---|----------|------|---------|
| Lista | GET `/api/quotes` | Igen | Összes idézet |
| Véletlen idézet | GET `/api/quotes/random` | Igen | Véletlenszerű idézet |
| Véletlen idézet mood alapján | GET `/api/quotes/random?mood=<mood>` | Igen | Véletlenszerű idézet adott mood szerint |

---

## ✅ Validáció és hibakezelés

- 422: Validációs hibák részletes JSON struktúrában  
- 400: Hibás paraméter (pl. rossz mood)  
- 401: Nem hitelesített kérés  
- 404: Nem talált erőforrás  
- 200, 201: Sikeres műveletek  
- Egyértelmű frontend hibakezelési minták

---

## 🧪 Tesztelés

- Laravel tesztek (phpunit):  
php artisan test

text
- Postman/Thunder Client importálható collection (külön fájl)

---

## 🛠️ Fejlesztési ajánlások

- Branch szabályok (feature branch, pull request)  
- Commit message szabványok (feat, fix, docs, chore...)  
- Code style PSR-12 Pint használattal  

---

## 🚢 Produkciós telepítés

- `.env` production beállítások  
- CORS domain váltás  
- Biztonsági készenlét (HTTPS, cache)  
- Migrációk futtatása, mentések  

---

## 🤝 Közreműködés

- Fork → Feature branch → Commit → Push → PR  
- Dokumentáció és tesztek mindig frissítendők  

---

## 📄 Licenc

MIT licenc

---

## 📧 Kapcsolat

- GitHub repository: https://github.com/ZmintZolika/motimpulse

---

**Utolsó frissítés:** 2025-11-20  
**Készítette:** Backend fejlesztő és tesztelő csapat: Bodvánszki Zoltán és Szerencsés Viktor 
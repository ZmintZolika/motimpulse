MotImpulse – Funkcionális specifikáció


Verzió 1.0
2025. október 8.

Készítette:
Bodvánszki Zoltán
Konczné Dr. Vályi Éva
Nagyidai Barbara
Szerencsés Viktor 
Tartalom
Funkcionális specifikáció	3
A projekt célja	3
Felhasználói szerepek	3
Funkcionális követelmények	3

Funkcionális specifikáció

 A projekt célja

A rendszer lehetővé teszi a felhasználók számára, hogy napi szinten rögzítsék hangulatukat, szokásaikat és egészségi állapotukat, majd ezek alapján értékelést és motivációt kapjanak. A cél az önismeret és a mentális jóllét támogatása.

 Felhasználói szerepek

- Regisztrált felhasználó: bejegyzéseket hoz létre, szerkeszt, statisztikát néz
- Admin (opcionális): idézeteket kezel, statisztikákat lát

 Funkcionális követelmények

1. Regisztráció és bejelentkezés
   - Email + jelszó alapú regisztráció
   - Validáció (pl. jelszó minimum 8 karakter)
   - Bejelentkezés és munkamenet-kezelés

2. Naplóbejegyzés létrehozása
   - Adatok: hangulat (1–5), alvás (óra), tevékenységek (szöveg), időjárás (választható), egészség (checkbox), jegyzet (szabad szöveg)
   - Dátum automatikusan vagy manuálisan

3. Bejegyzés szerkesztése és törlése
   - Szerkesztés: minden mező módosítható
   - Törlés: soft delete (nem véglegesen törlődik, csak elrejtés)

4. Napi pontszám generálása
   - Algoritmus: hangulat + alvás + egészség alapján
   - Pontszám skála: 0–10
   - Megjelenítés a bejegyzés után

5. Motivációs idézetek megjelenítése
   - Pontszám alapján kategorizált idézetek (pl. alacsony → bátorító, magas → inspiráló)
   - Idézetek adatbázisból

6. Statisztikák és trendek megtekintése
   - Grafikon: hangulat alakulása időben
   - Átlagos alvásidő, tevékenységek gyakorisága
   - Időszűrés: heti, havi, összes

7. Kijelentkezés funkció
   - Biztonságos logout
   - Token vagy session törlése
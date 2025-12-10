MotImpulse – Funkcionális specifikáció


Verzió 1.1
2025. 
November 7.

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

A rendszer lehetővé teszi a felhasználók számára, hogy napi szinten rögzítsék hangulatukat, szokásaikat és egészségi állapotukat, majd ezek alapján motivációs idézetet kapjanak. A cél az önismeret és a mentális jóllét támogatása.

 Felhasználói szerepek

- Regisztrált felhasználó: bejegyzéseket hoz létre, szerkeszt
- Admin : idézeteket kezel, felhasználókat kezel

 Funkcionális követelmények

1. Regisztráció és bejelentkezés
   - Email + jelszó alapú regisztráció
   - Validáció (pl. jelszó minimum 8 karakter)
   - Bejelentkezés és munkamenet-kezelés




2. Naplóbejegyzés létrehozása
   - Adatok: hangulat (enum), időjárás (enum), alvásminőség (enum), tevékenység (enum), egészségmegőrző tevékenységnek (enum), jegyzet (text)
   - Dátum automatikusan vagy manuálisan

3. Bejegyzés szerkesztése és törlése
   - Szerkesztés: minden mező módosítható
   - Törlés: soft delete (nem véglegesen törlődik, csak elrejtés)

4. Motivációs idézetek megjelenítése
   - Pontszám alapján kategorizált idézetek (pl. alacsony → bátorító, magas → inspiráló)
   - Idézetek adatbázisból

5. Kijelentkezés funkció
   - Biztonságos logout
   - Token vagy session törlése
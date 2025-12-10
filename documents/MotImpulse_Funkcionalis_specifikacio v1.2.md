MotImpulse – Funkcionális specifikáció
Verzió 1.2
2025. November 23.
Készítette:
Bodvánszki Zoltán
Konczné Dr. Vályi Éva
Nagyidai Barbara
Szerencsés Viktor
Tartalomjegyzék
Funkcionális specifikáció	2
1.Bevezetés	3
2. Rendszeráttekintés	3
3. Felhasználói szerepek	3
4.Funkcionális követelmények -Felhasználói felületek	3
4.1. Regisztráció és bejelentkezés	4
4.3. Bejegyzés szerkesztése és törlése	4
4.4. Motivációs idézetek megjelenítése	4
4.5. Kijelentkezés funkció	5
5. Adatmodell (DB diagram)	5
6. Rendszerkövetelmények	6

Funkcionális specifikáció
1.Bevezetés 
Ez a dokumentum a MotImpulse funkcionális működését írja le. Célja, hogy pontosan meghatározza, a rendszer milyen funkciókat biztosít, hogyan viselkedik a felhasználói interakciók során, és milyen adatokat kezel.
2. Rendszeráttekintés
A rendszer lehetővé teszi a felhasználók számára, hogy napi szinten rögzítsék hangulatukat, szokásaikat és egészségi állapotukat, majd ezek alapján motivációs idézetet kapjanak. A cél az önismeret és a mentális jóllét támogatása.

3. Felhasználói szerepek
    • Regisztrált felhasználó:	
        ◦ bejegyzéseket hoz létre,
        ◦ szerkeszt
    • Admin:
        ◦ idézeteket kezel,
        ◦ felhasználókat kezel
4.Funkcionális követelmények -Felhasználói felületek
4.1. Regisztráció és bejelentkezés
- Email + jelszó alapú regisztráció
- Validáció (pl. jelszó minimum 8 karakter)
- Bejelentkezés és munkamenet-kezelés
4.2. Naplóbejegyzés létrehozása
- Adatok:
- hangulat (enum),
- időjárás (enum),
- alvásminőség (enum),
- tevékenység (enum),
- egészségmegőrző tevékenységnek (enum),
- jegyzet (text)
- Dátum:
-automatikusan,
-manuálisan
4.3. Bejegyzés szerkesztése és törlése
- Szerkesztés: minden mező módosítható
- Törlés: soft delete (nem véglegesen törlődik, csak elrejtés)
4.4. Motivációs idézetek megjelenítése
- Pontszám alapján kategorizált idézetek például:
- alacsony → bátorító,
- magas → inspiráló)
- Idézetek megjelenítése adatbázisból
4.5. Kijelentkezés funkció
- Biztonságos logout
- Token vagy session törlése

5. Adatmodell (DB diagram)

6. Rendszerkövetelmények
- Böngésző: Chrome, Firefox, Edge, Brave, Safari legfrissebb verziói.
- Képernyőméret: mobil és asztali támogatás.

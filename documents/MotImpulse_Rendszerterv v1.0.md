MotImpulse – Rendszerterv

Verzió 1.0
2025. október 6.

Készítette:
Bodvánszki Zoltán
Konczné Dr. Vályi Éva
Nagyidai Barbara
Szerencsés Viktor 
Tartalom
1. Bevezetés	2
2. Cél és funkciók	2
3. Használt technológiák	2
4. Rendszerarchitektúra	2
5. Funkcionális követelmények	2
6. Nem funkcionális követelmények	2
7. Adatbázis-terv	3
7.1 users tábla	3
7.2 day_entries tábla	3
7.3 motivational_quotes tábla	4
8. Jogosultságok	4
9. Tesztelési terv (manuális funkcionális tesztelés)	4
10. Összefoglalás	4


1. Bevezetés
A MotImpulse egy motivációs és hangulatnapló webalkalmazás, amely lehetővé teszi a felhasználók számára, hogy rögzítsék napi érzéseiket, szokásaikat, és értékeljék napjaikat. Az alkalmazás célja a mentális jóllét támogatása, valamint személyre szabott motivációs idézetek megjelenítése a felhasználói adatok alapján.
2. Cél és funkciók
A rendszer lehetőséget biztosít a napi bejegyzések létrehozására, szerkesztésére, törlésére (soft delete), valamint az adatok statisztikai elemzésére. A motivációs funkciók célja, hogy a nap értékelése alapján releváns idézeteket és tanácsokat jelenítsenek meg.
3. Használt technológiák
Backend: Laravel (PHP keretrendszer, REST API)
Frontend: HTML, CSS, JS, PHP
Verziókezelés: Git, GitHub
4. Rendszerarchitektúra
A MotImpulse architektúrája kliens-szerver alapú. Az Angular frontend HTTP kéréseket küld a Laravel REST API felé, amely az adatokat MySQL adatbázisban tárolja. A felhasználói hitelesítés JWT tokenekkel történik.
5. Funkcionális követelmények
    • Felhasználói regisztráció, belépés és kijelentkezés
    • Napi bejegyzések létrehozása, szerkesztése és soft törlése
    • Motivációs idézetek megjelenítése a napi értékelés alapján
    • Statisztikák megjelenítése (hangulat, alvás, egészség trendek)
    • Admin felület idézetek kezelésére
6. Nem funkcionális követelmények
    • Reszponzív felhasználói felület
    • Adatbiztonság (titkosított jelszavak, hitelesített kérések)
    • Megbízhatóság és könnyű karbantarthatóság
7. Adatbázis-terv
7.1 users tábla

id – INT (PK)
name – VARCHAR(100)
email – VARCHAR(150)
password – VARCHAR(255)
created_at – TIMESTAMP
updated_at – TIMESTAMP

7.2 day_entries tábla

id – INT (PK)
user_id – INT (FK)
date – DATE
mood – ENUM('Nagyon jó', 'Jó', 'Semleges', 'Rossz', 'Nagyon rossz')
weather – ENUM('Napos', 'Felhős', 'Esős', 'Szeles', 'Havas')
sleep_quality – ENUM('Kiváló', 'Jó', 'Közepes', 'Rossz', 'Nagyon rossz')
activity – ENUM('Munka', 'Tanulás', 'Pihenés', 'Sport', 'Szórakozás', 'Egyéb')
health_action – ENUM('Mozgás', 'Egészséges étkezés', 'Pihenés', 'Semmi')
score – TINYINT
note – TEXT
deleted_at – TIMESTAMP NULL (Soft delete mező)
created_at – TIMESTAMP
updated_at – TIMESTAMP

A deleted_at mező a Laravel SoftDeletes funkcióját támogatja, lehetővé téve a bejegyzések logikai törlését.
7.3 motivational_quotes tábla

id – INT (PK)
category – ENUM('low', 'medium', 'high')
text – TEXT
deleted_at – TIMESTAMP NULL
created_at – TIMESTAMP
updated_at – TIMESTAMP

8. Jogosultságok
    • Felhasználó: saját bejegyzéseinek kezelése, motivációk megtekintése.
    • Admin: motivációs idézetek kezelése, rendszerkarbantartás.
9. Tesztelési terv (manuális funkcionális tesztelés)
A tesztelés célja a MotImpulse fő funkcióinak manuális ellenőrzése. A csapat a funkciókat felhasználói szemmel vizsgálja, nem automatizált eszközökkel.
Tesztelendő területek:
    • Felhasználói fiók: regisztráció, belépés, kijelentkezés
    • Napi bejegyzések: létrehozás, szerkesztés, törlés (soft delete)
    • Motivációs idézetek: megjelenítés pontszám alapján
    • Navigáció és linkek: menük, oldalak, visszanavigálás
    • Statisztikák: helyes adatmegjelenítés, átlagok
    • Hibakezelés: hiányos adatok, duplikált nap, jogosulatlan hozzáférés
10. Összefoglalás
A MotImpulse egy motivációs és hangulatkövető rendszer, amely a felhasználók mindennapi jóllétét támogatja. A Laravel – Angular alapú architektúra modern, bővíthető és könnyen karbantartható megoldást biztosít.
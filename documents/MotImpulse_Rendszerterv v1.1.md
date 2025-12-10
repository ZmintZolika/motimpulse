MotImpulse – Rendszerterv

Verzió 1.1
2025. október 6.

Készítette:
Bodvánszki Zoltán
Konczné Dr. Vályi Éva
Nagyidai Barbara
Szerencsés Viktor 
Tartalom
1. Bevezetés	3
2. Cél és funkciók	3
3. Használt technológiák	3
4. Rendszerarchitektúra	3
5. Funkcionális követelmények	3
6. Nem funkcionális követelmények	3
7. Adatbázis-terv	4
8. Jogosultságok	5
9. Tesztelési terv (manuális funkcionális tesztelés)	6
10. Összefoglalás	6


1. Bevezetés
A MotImpulse egy motivációs és hangulatnapló webalkalmazás, amely lehetővé teszi a felhasználók számára, hogy rögzítsék napi érzéseiket, szokásaikat, és értékeljék napjaikat. Az alkalmazás célja a mentális jóllét támogatása, valamint személyre szabott motivációs idézetek megjelenítése a felhasználói adatok alapján.
2. Cél és funkciók
A rendszer lehetőséget biztosít a napi bejegyzések létrehozására, szerkesztésére, törlésére (soft delete), valamint az adatok statisztikai elemzésére. A motivációs funkciók célja, hogy a nap értékelése alapján releváns idézeteket és tanácsokat jelenítsenek meg.
3. Használt technológiák
Backend: Laravel (PHP keretrendszer, REST API)
Frontend: Angular (SPA architektúra)
Adatbázis: MySQL
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

    1. users tábla
id - BIGINT UNSIGNED (PK, AUTO_INCREMENT)
name - VARCHAR(100) NOT NULL
email - VARCHAR(150) NOT NULL
email_verified_at - TIMESTAMP NULL
password - VARCHAR(255) NOT NULL
remember_token - VARCHAR(100) NULL
created_at - TIMESTAMP NULL
updated_at - TIMESTAMP NULL

UNIQUE INDEX idx_email (email)

    2. day_entries tábla
id - BIGINT UNSIGNED (PK, AUTO_INCREMENT)
user_id - BIGINT UNSIGNED NOT NULL
date - DATE NOT NULL
mood - TINYINT UNSIGNED NOT NULL (1-10)
weather - ENUM('Napos', 'Felhős', 'Esős', 'Szeles', 'Havas') NULL
sleep_quality - ENUM('Nagyon rossz', 'Rossz', 'Közepes', 'Jó', 'Kiváló') NULL
activity - ENUM('Munka', 'Tanulás', 'Pihenés', 'Sport', 'Szórakozás', 'Egyéb') NULL
health_action - ENUM('Mozgás', 'Egészséges étkezés', 'Pihenés', 'Semmi') NULL
score - TINYINT UNSIGNED NULL (1-10)
note - TEXT NULL
deleted_at - TIMESTAMP NULL
created_at - TIMESTAMP NULL
updated_at - TIMESTAMP NULL

UNIQUE INDEX idx_user_date (user_id, date)
INDEX idx_mood (mood)
INDEX idx_deleted_at (deleted_at)

FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE

Megjegyzés: az ékezetes betűk használata meggondolandó, a kódban változtatni szükséges hozzá.

    3. motivational_quotes tábla
id - BIGINT UNSIGNED (PK, AUTO_INCREMENT)
category - TINYINT UNSIGNED NOT NULL (1-10)
text - TEXT NOT NULL
author - VARCHAR(150) NULL
deleted_at - TIMESTAMP NULL
created_at - TIMESTAMP NULL
updated_at TIMESTAMP NULL

INDEX idx_category (category)
INDEX idx_deleted_at (deleted_at)

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
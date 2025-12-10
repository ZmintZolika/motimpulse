MotImpulse – Rendszerterv

Verzió 1.2
2025. november 7.

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
A rendszer lehetőséget biztosít a napi bejegyzések létrehozására, szerkesztésére, törlésére (soft delete), valamint az adatok statisztikai elemzésére. A motivációs funkciók célja, hogy a napi hangulata alapján releváns idézeteket és tanácsokat jelenítsenek meg.
3. Használt technológiák
Backend: Laravel (PHP keretrendszer, REST API)
Frontend: HTML, CSS, JS, PHP
Adatbázis: MySQL
Verziókezelés: Git, GitHub
4. Rendszerarchitektúra
A MotImpulse architektúrája kliens-szerver alapú. Az Angular frontend HTTP kéréseket küld a Laravel REST API felé, amely az adatokat MySQL adatbázisban tárolja. A felhasználói hitelesítés JWT tokenekkel történik.
5. Funkcionális követelmények
    • Felhasználói regisztráció, belépés és kijelentkezés
    • Napi bejegyzések létrehozása, szerkesztése és soft törlése
    • Motivációs idézetek megjelenítése a napi hangulat alapján
    • Statisztikák megjelenítése 
    • Admin felület idézetek kezelésére
6. Nem funkcionális követelmények
    • Reszponzív felhasználói felület
    • Adatbiztonság (titkosított jelszavak, hitelesített kérések)
    • Megbízhatóság és könnyű karbantarthatóság
7. Adatbázis-terv

Table "users" {
  "user_id" int [pk, increment]
  "name" varchar(100) [not null]
  "email" varchar(150) [unique, not null]
  "email_verified_at" timestamp [null]
  "password" varchar(255) [not null]
  "remember_token" varchar(100)
  "created_at" timestamp [null]
  "updated_at" timestamp [null]
}
Table "entries" {
  "entry_id" int [pk, increment]
  "user_id" int [not null]
  "quote_id" int 
  "mood" enum("Lehangolt","Kiegyensúlyozott", "Vidám")
  "weather" enum("Napos", "Felhős", "Esős", "Szeles", "Havas") [not null]
  "sleep_quality" enum("Nagyon rossz", "Rossz", "Közepes", "Jó", "Kiváló") [not null]
  "activities" enum("Munka", "Tanulás", "Pihenés", "Sport", "Szórakozás", "Egyéb") [not null]
  "health_action" enum("Mozgás", "Egészséges étkezés", "Pihenés", "Semmi") [not null]
  "note" text 
  "is_deleted" boolean [default: false]  
  "created_at" timestamp [null]
  "updated_at" timestamp [null]
  "deleted_at" timestamp [null]
}
Table "quotes" {
  "quote_id" int [pk, increment] 
  "quote_category"  enum("Lehangolt","Kiegyensúlyozott", "Vidám")
  "quote_text" text [not null]
  "author" varchar(100)
  "created_at" timestamp [null]
  "updated_at" timestamp [null]
  "deleted_at" timestamp [null]
}
Ref:"users"."user_id" < "entries"."user_id"
Ref: "entries"."mood" < "quotes"."quote_category"
Ref: "quotes"."quote_id" < "entries"."quote_id"


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
A MotImpulse egy motivációs és hangulatkövető rendszer, amely a felhasználók mindennapi jóllétét támogatja.
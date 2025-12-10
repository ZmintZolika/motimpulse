
MotImpulse – Szoftverkövetelmény specifikáció (SRS)


Verzió 1.0
2025. október 5.

Készítette:
Bodvánszki Zoltán
Konczné Dr. Vályi Éva
Nagyidai Barbara
Szerencsés Viktor

Tartalom
1. Bevezetés	3
1.1 Cél	3
1.2 Hatókör	3
1.3 Fogalmak és rövidítések	3
2. A rendszer általános leírása	3
2.1 A rendszer környezete	3
2.2 Felhasználói típusok	3
2.3 Függőségek és korlátozások	3
3. Funkcionális követelmények	3
4. Nem funkcionális követelmények	4
5. Adatkezelési követelmények	4
6. Felhasználói felület követelményei	4
7. Tesztelési irányelvek	4
8. Jövőbeli fejlesztési lehetőségek	5
9. Jóváhagyás	5


1. Bevezetés
A MotImpulse egy motivációs és önfejlesztő webalkalmazás, amely segít a felhasználóknak nyomon követni mindennapi hangulatukat, tevékenységeiket és életmódjukat. Az alkalmazás célja, hogy a felhasználók felismerjék szokásaik és hangulatuk közötti összefüggéseket, valamint személyre szabott motivációs idézetekkel támogassa őket.
1.1 Cél
Ez a dokumentum a MotImpulse alkalmazás szoftverkövetelményeit tartalmazza. A cél a rendszer funkcionalitásának, teljesítményének és felhasználói elvárásainak pontos meghatározása.
1.2 Hatókör
A rendszer webes környezetben működik, és lehetőséget biztosít a felhasználók számára, hogy naplóbejegyzéseket készítsenek, amelyek tartalmazzák a hangulatot, alvásminőséget, tevékenységeket, időjárást, egészségügyi szokásokat és jegyzeteket. A rendszer ezen adatok alapján statisztikákat készít, valamint motivációs idézeteket jelenít meg.
1.3 Fogalmak és rövidítések
    • SRS – Szoftverkövetelmény-specifikáció
    • CRUD – Create, Read, Update, Delete
    • API – Alkalmazásprogramozási felület 
2. A rendszer általános leírása
2.1 A rendszer környezete
A MotImpulse alkalmazás böngészőalapú rendszer, amelynek frontendje Angularban, backendje Laravelben készül. A két réteg REST API-n keresztül kommunikál, az adatokat MySQL adatbázisban tárolja.
2.2 Felhasználói típusok
    1. Regisztrált felhasználó: naplóbejegyzéseket készít, szerkeszt, töröl, megtekint.
    2. Adminisztrátor: rendszerfelügyelet, felhasználói aktivitás és statisztikák áttekintése.
2.3 Függőségek és korlátozások
    • A rendszer működéséhez internetkapcsolat és modern böngésző szükséges.
    • A felhasználói azonosítás email + jelszó alapon történik.
    • A rendszer nem tartalmaz médiarögzítést (képek, videók).
3. Funkcionális követelmények
    1. Regisztráció és bejelentkezés – a felhasználó email és jelszó megadásával regisztrálhat és beléphet.
    2. Naplóbejegyzés létrehozása – a felhasználó rögzíti napi adatait (pl. hangulat, alvás, tevékenységek, időjárás, egészség, jegyzet).
    3. Bejegyzés szerkesztése és törlése – a felhasználó módosíthatja korábbi bejegyzéseit, illetve soft delete funkcióval elrejtheti őket.
    4. Napi pontszám generálása – a rendszer a megadott adatok alapján értékeli a napot.
    5. Motivációs idézetek megjelenítése – a napi pontszám alapján a rendszer idézetet jelenít meg.
    6. Statisztikák és trendek megtekintése – grafikus visszajelzések a hangulat és szokások alakulásáról.
    7. Kijelentkezés funkció – biztonságos munkamenet-kezelés.
4. Nem funkcionális követelmények
    • Teljesítmény: a rendszernek átlagosan 2 másodpercen belül kell válaszolnia API-hívásokra.
    • Biztonság: jelszavak titkosítással.
    • Használhatóság: reszponzív webfelület, egyszerű űrlapkitöltés.
    • Megbízhatóság: a bejegyzések soft delete funkcióval nem vesznek el véglegesen.
    • Karbantarthatóság: a Laravel és Angular moduláris architektúrája támogatja a hosszú távú fejlesztést.
5. Adatkezelési követelmények
Az adatbázis három fő táblából áll: Felhasználók, Bejegyzések, Motivációk.
A bejegyzéseknél a 'deleted' mező jelzi, hogy a bejegyzés inaktív-e, így nem jelenik meg, de megőrzi a múltbeli nyomát.
Az ENUM típusokat használjuk előre meghatározott mezőkhöz, mint a hangulat, időjárás vagy alvásminőség.
6. Felhasználói felület követelményei
    • Egyszerű, motivációs jellegű design.
    • Főoldal: napi hangulatbejegyzések listája.
    • Új bejegyzés űrlap: előre definiált mezők (ENUM-ok) és szöveges jegyzet.
    • Statisztika oldal: grafikonok a hangulat és tevékenységek alakulásáról.
    • Motivációs panel: idézetek megjelenítése a napi értékelés szerint.
7. Tesztelési irányelvek
A tesztelés manuálisan történik, a funkciók, linkek, űrlapok és bejegyzéskezelés ellenőrzésével. A cél az, hogy minden funkcionális követelmény hibamentesen működjön, és az adatok helyesen jelenjenek meg.
8. Jövőbeli fejlesztési lehetőségek
    • Képfeltöltés és médiatartalom támogatás.
    • Többnyelvű felület.
    • AI-alapú motivációs javaslatok személyre szabottan.
    • Mobilalkalmazás verzió (PWA vagy natív).
9. Jóváhagyás
A dokumentumot átnézte és jóváhagyta a MotImpulse fejlesztői csapat (2025. október).
MotImpulse - 3 táblás adatbázis-terv

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


Megjegyzés: a weather, sleep_quality, activity, health_action enumok, csak a diagram nem engedi.
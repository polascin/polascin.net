# polascin.net

Zdrojový kód osobnej stránky [polascin.net](https://polascin.net): verejný web,
blog, kontaktný formulár, newsletter a jednoduchá administrácia. Aplikácia je
postavená na PHP a MariaDB bez aplikačného frameworku.

## Požiadavky

- PHP 8.2 alebo novšie s rozšíreniami PDO MySQL, DOM a iconv alebo mbstring
- MariaDB 10.5+ alebo kompatibilný MySQL server
- web server s HTTPS; Apache pravidlá sú v `.htaccess`

## Lokálne spustenie

1. Skopírujte `env.ini.example` do `private/polascin.env.ini` a doplňte lokálne
   databázové údaje. Adresár `private/` aj všetky `*.ini` sú ignorované Gitom.
2. Vytvorte prázdnu databázu a spustite `php setup_db.php`. Skript je dostupný
   iba cez príkazový riadok a bezpečne aplikuje aj verzované migrácie.
3. Spustite lokálny server, napríklad `php -S 127.0.0.1:8080`, a otvorte
   `http://127.0.0.1:8080`.

Pri prvom vytvorení administrátora nastavte premenné
`POLASCIN_ADMIN_EMAIL` a `POLASCIN_ADMIN_PASSWORD`. Bez explicitného hesla
skript v interaktívnom režime vygeneruje silné jednorazové heslo.

Ak aplikácia beží za reverzným proxy, zapnite `TRUST_PROXY_HEADERS=true` iba
spolu s presným allowlistom `TRUSTED_PROXY_IPS`. Bez allowlistu sa preposlaným
hlavičkám zámerne nedôveruje.

## Kontroly kvality

Základná regresná sada nevyžaduje databázu:

```text
php tests/run.php
```

Pred odovzdaním zmien sa kontroluje aj syntax všetkých PHP a JavaScript
súborov. Rovnaké kontroly spúšťa validačný job v GitHub Actions.

## Nasadenie

Produkčný workflow a lokálny deploy skript synchronizujú iba verejné súbory,
chránia privátnu konfiguráciu a následne spustia databázové migrácie. Presné
nastavenie tajomstiev, SSH host key a bezpečnostné poistky sú popísané v
[DEPLOY.md](DEPLOY.md).

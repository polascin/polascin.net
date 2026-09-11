# Kontrola produkčnej databázy — polascin.net

Generované: 2026-09-11 19:30:36 CEST  
Databáza: `Z5oV9wRn`  
Server: `11.4.13-MariaDB-ubu2204-log`  
Režim: read-only transakcia, iba `SELECT`/`SHOW`

STATUS: NÁLEZY
NALEZOV: 1

## Súhrn

- **STREDNÉ** — `form_rate_limit` drží záznamy staré 44 dní; tabuľka je prevádzková a mala by sa priebežne prerezávať.

## Tabuľky

| Tabuľka | Engine | Collation | Riadkov (presne) |
| --- | --- | --- | --- |
| `access_logs` | InnoDB | utf8mb4_unicode_ci | 20103 |
| `admin_audit_log` | InnoDB | utf8mb4_unicode_ci | 0 |
| `articles` | InnoDB | utf8mb4_unicode_ci | 0 |
| `contact_messages` | InnoDB | utf8mb4_unicode_ci | 191 |
| `content_blocks` | InnoDB | utf8mb4_unicode_ci | 5 |
| `form_rate_limit` | InnoDB | utf8mb4_unicode_ci | 13 |
| `newsletter_subscribers` | InnoDB | utf8mb4_unicode_ci | 0 |
| `schema_migrations` | InnoDB | utf8mb4_unicode_ci | 3 |
| `users` | InnoDB | utf8mb4_unicode_ci | 1 |

## Migrácie schémy

- ✅ `2026072801_security_indexes` — 2026-07-29 15:56:06
- ✅ `2026072901_multilingual_content` — 2026-07-29 15:56:06
- ✅ `2026072902_profile_copy` — 2026-07-29 18:45:44

## Indexy strážené migráciou

- ✅ `form_rate_limit.idx_action_last_attempt`
- ✅ `newsletter_subscribers.idx_confirm_token`
- ✅ `newsletter_subscribers.idx_unsubscribe_token`

## Prístupové účty

- Aktívnych administrátorov: **1**
- Deaktivovaných administrátorov: 0
- Neadministrátorských účtov: 0

## Obsah a jazyky

- Publikovaných článkov: 0
- Články podľa jazyka:
- Obsahové bloky podľa jazyka:
  - `sk`: 5

## Retencia osobných údajov

Nastavená retencia access logov: **90 dní** (`ACCESS_LOG_RETENTION_DAYS`).

| Tabuľka | Riadkov | Najstarší záznam | Vek (dní) |
| --- | --- | --- | --- |
| `access_logs` | 20103 | 2026-07-28 12:20:55 | 45 |
| `contact_messages` | 191 | 2026-07-29 02:43:39 | 44 |
| `newsletter_subscribers` | 0 | — | — |
| `form_rate_limit` | 13 | 2026-07-29 16:32:16 | 44 |


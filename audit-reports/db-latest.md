# Kontrola produkčnej databázy — polascin.net

Generované: 2026-09-21 22:41:17 CEST  
Server: `MariaDB 11.4.x`  
Režim: read-only transakcia, iba `SELECT`/`SHOW`

Názov databázy a presná verzia servera sa do reportu zámerne nepíšu —
repozitár je verejný.

STATUS: OK
NALEZOV: 0

## Súhrn

Bez nálezov — schéma, migrácie, indexy, účty aj retencia sú v očakávanom stave.

## Tabuľky

| Tabuľka | Engine | Collation | Riadkov (presne) |
| --- | --- | --- | --- |
| `access_logs` | InnoDB | utf8mb4_unicode_ci | 25879 |
| `admin_audit_log` | InnoDB | utf8mb4_unicode_ci | 19 |
| `articles` | InnoDB | utf8mb4_unicode_ci | 50 |
| `contact_messages` | InnoDB | utf8mb4_unicode_ci | 0 |
| `content_blocks` | InnoDB | utf8mb4_unicode_ci | 5 |
| `form_rate_limit` | InnoDB | utf8mb4_unicode_ci | 0 |
| `newsletter_subscribers` | InnoDB | utf8mb4_unicode_ci | 0 |
| `schema_migrations` | InnoDB | utf8mb4_unicode_ci | 11 |
| `users` | InnoDB | utf8mb4_unicode_ci | 1 |

## Migrácie schémy

- ✅ `2026072801_security_indexes` — 2026-07-29 15:56:06
- ✅ `2026072901_multilingual_content` — 2026-07-29 15:56:06
- ✅ `2026072902_profile_copy` — 2026-07-29 18:45:44
- ✅ `2026091101_admin_password_rotation` — 2026-09-11 20:56:52
- ✅ `2026091701_glp1_steroid_food_noise_article` — 2026-09-17 18:48:41
- ✅ `2026091702_arenibus_ai_security_audit_article` — 2026-09-17 18:53:07
- ✅ `2026091703_via_practica_vld_algorithm_article` — 2026-09-17 18:55:43
- ✅ `2026091704_ai_model_freedom_article` — 2026-09-17 18:59:57
- ✅ `2026091705_article_cover_images` — 2026-09-17 19:18:16
- ✅ `2026091706_article_all_language_translations` — 2026-09-17 19:31:35
- ✅ `2026092001_ai_author_phishing_email_article` — 2026-09-20 16:33:14

## Indexy strážené migráciou

- ✅ `form_rate_limit.idx_action_last_attempt`
- ✅ `newsletter_subscribers.idx_confirm_token`
- ✅ `newsletter_subscribers.idx_unsubscribe_token`

## Prístupové účty

- Aktívnych administrátorov: **1**
- Deaktivovaných administrátorov: 0
- Neadministrátorských účtov: 0

## Obsah a jazyky

- Publikovaných článkov: 50
- Články podľa jazyka:
  - `cs`: 5
  - `de`: 5
  - `en`: 5
  - `es`: 5
  - `fr`: 5
  - `hu`: 5
  - `it`: 5
  - `pl`: 5
  - `sk`: 5
  - `uk`: 5
- Obsahové bloky podľa jazyka:
  - `sk`: 5

## Retencia osobných údajov

Nastavená retencia access logov: **90 dní** (`ACCESS_LOG_RETENTION_DAYS`).

| Tabuľka | Riadkov | Najstarší záznam | Vek (dní) |
| --- | --- | --- | --- |
| `access_logs` | 25879 | 2026-07-28 12:20:55 | 55 |
| `contact_messages` | 0 | — | — |
| `newsletter_subscribers` | 0 | — | — |
| `form_rate_limit` | 0 | — | — |


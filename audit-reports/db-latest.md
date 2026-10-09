# Kontrola produkčnej databázy — polascin.net

Generované: 2026-10-09 22:46:16 CEST  
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
| `access_logs` | InnoDB | utf8mb4_unicode_ci | 41579 |
| `admin_audit_log` | InnoDB | utf8mb4_unicode_ci | 40 |
| `articles` | InnoDB | utf8mb4_unicode_ci | 220 |
| `contact_messages` | InnoDB | utf8mb4_unicode_ci | 1 |
| `content_blocks` | InnoDB | utf8mb4_unicode_ci | 5 |
| `form_rate_limit` | InnoDB | utf8mb4_unicode_ci | 4 |
| `newsletter_subscribers` | InnoDB | utf8mb4_unicode_ci | 0 |
| `schema_migrations` | InnoDB | utf8mb4_unicode_ci | 33 |
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
- ✅ `2026092401_ai_receptionist_twelve_questions_article` — 2026-09-24 16:50:35
- ✅ `2026092402_cloudflare_disallow_ai_training_article` — 2026-09-24 17:25:47
- ✅ `2026092403_cloudflare_article_published_at_fix` — 2026-09-24 17:28:13
- ✅ `2026092404_secret_scanner_shell_history_article` — 2026-09-24 17:39:05
- ✅ `2026092405_arenibus_google_4177_tests_article` — 2026-09-24 17:42:53
- ✅ `2026092406_arenibus_article_published_at_fix` — 2026-09-24 17:46:20
- ✅ `2026092501_anonymize_blog_personal_names` — 2026-09-25 16:49:03
- ✅ `2026092502_ai_book_trailer_scam_article` — 2026-09-25 16:55:49
- ✅ `2026092503_atlas_agents_cold_email_article` — 2026-09-25 17:07:28
- ✅ `2026092504_awai_two_page_story_article` — 2026-09-25 17:56:58
- ✅ `2026092505_awai_figel_wording` — 2026-09-25 19:40:58
- ✅ `2026092506_good_sceptic_probabilia_article` — 2026-09-25 20:13:20
- ✅ `2026100101_ceresare_kyjov_article` — 2026-10-01 08:12:56
- ✅ `2026100301_web_guard_own_ai_article` — 2026-10-03 06:10:49
- ✅ `2026100302_efficiency_refilled_article` — 2026-10-03 21:35:52
- ✅ `2026100303_incremental_hd_odds_ratio_article` — 2026-10-03 21:58:56
- ✅ `2026100304_pipeline_i_sign_article` — 2026-10-03 22:20:01
- ✅ `2026100305_three_unsolicited_offers_article` — 2026-10-03 22:21:04
- ✅ `2026100401_what_exists_sunday_article` — 2026-10-04 16:43:57
- ✅ `2026100402_experience_starting_point_article` — 2026-10-04 16:52:55
- ✅ `2026100801_human_skill_md_article` — 2026-10-08 07:37:06
- ✅ `2026100802_remove_blog_contact_ctas` — 2026-10-08 08:11:37

## Indexy strážené migráciou

- ✅ `form_rate_limit.idx_action_last_attempt`
- ✅ `newsletter_subscribers.idx_confirm_token`
- ✅ `newsletter_subscribers.idx_unsubscribe_token`

## Prístupové účty

- Aktívnych administrátorov: **1**
- Deaktivovaných administrátorov: 0
- Neadministrátorských účtov: 0

## Obsah a jazyky

- Publikovaných článkov: 220
- Články podľa jazyka:
  - `cs`: 22
  - `de`: 22
  - `en`: 22
  - `es`: 22
  - `fr`: 22
  - `hu`: 22
  - `it`: 22
  - `pl`: 22
  - `sk`: 22
  - `uk`: 22
- Obsahové bloky podľa jazyka:
  - `sk`: 5

## Retencia osobných údajov

Nastavená retencia access logov: **90 dní** (`ACCESS_LOG_RETENTION_DAYS`).

| Tabuľka | Riadkov | Najstarší záznam | Vek (dní) |
| --- | --- | --- | --- |
| `access_logs` | 41579 | 2026-07-28 12:20:55 | 73 |
| `contact_messages` | 1 | 2026-10-08 20:58:00 | 1 |
| `newsletter_subscribers` | 0 | — | — |
| `form_rate_limit` | 4 | 2026-10-08 20:58:00 | 1 |

Kontaktné správy: **0** vybavených, **1** nevybavených
(z toho **0** nevybavených dlhšie ako 30 dní, **0** vybavených starších ako 180 dní).


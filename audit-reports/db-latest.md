# Kontrola produkčnej databázy — polascin.net

Generované: 2026-10-30 21:37:01 CET  
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
| `access_logs` | InnoDB | utf8mb4_unicode_ci | 61986 |
| `admin_audit_log` | InnoDB | utf8mb4_unicode_ci | 54 |
| `articles` | InnoDB | utf8mb4_unicode_ci | 420 |
| `contact_messages` | InnoDB | utf8mb4_unicode_ci | 2 |
| `content_blocks` | InnoDB | utf8mb4_unicode_ci | 5 |
| `form_rate_limit` | InnoDB | utf8mb4_unicode_ci | 5 |
| `newsletter_subscribers` | InnoDB | utf8mb4_unicode_ci | 0 |
| `schema_migrations` | InnoDB | utf8mb4_unicode_ci | 59 |
| `users` | InnoDB | utf8mb4_unicode_ci | 1 |

## Migrácie schémy

- ✅ `2026072801_security_indexes` — 2026-07-29 14:56:06
- ✅ `2026072901_multilingual_content` — 2026-07-29 14:56:06
- ✅ `2026072902_profile_copy` — 2026-07-29 17:45:44
- ✅ `2026091101_admin_password_rotation` — 2026-09-11 19:56:52
- ✅ `2026091701_glp1_steroid_food_noise_article` — 2026-09-17 17:48:41
- ✅ `2026091702_arenibus_ai_security_audit_article` — 2026-09-17 17:53:07
- ✅ `2026091703_via_practica_vld_algorithm_article` — 2026-09-17 17:55:43
- ✅ `2026091704_ai_model_freedom_article` — 2026-09-17 17:59:57
- ✅ `2026091705_article_cover_images` — 2026-09-17 18:18:16
- ✅ `2026091706_article_all_language_translations` — 2026-09-17 18:31:35
- ✅ `2026092001_ai_author_phishing_email_article` — 2026-09-20 15:33:14
- ✅ `2026092401_ai_receptionist_twelve_questions_article` — 2026-09-24 15:50:35
- ✅ `2026092402_cloudflare_disallow_ai_training_article` — 2026-09-24 16:25:47
- ✅ `2026092403_cloudflare_article_published_at_fix` — 2026-09-24 16:28:13
- ✅ `2026092404_secret_scanner_shell_history_article` — 2026-09-24 16:39:05
- ✅ `2026092405_arenibus_google_4177_tests_article` — 2026-09-24 16:42:53
- ✅ `2026092406_arenibus_article_published_at_fix` — 2026-09-24 16:46:20
- ✅ `2026092501_anonymize_blog_personal_names` — 2026-09-25 15:49:03
- ✅ `2026092502_ai_book_trailer_scam_article` — 2026-09-25 15:55:49
- ✅ `2026092503_atlas_agents_cold_email_article` — 2026-09-25 16:07:28
- ✅ `2026092504_awai_two_page_story_article` — 2026-09-25 16:56:58
- ✅ `2026092505_awai_figel_wording` — 2026-09-25 18:40:58
- ✅ `2026092506_good_sceptic_probabilia_article` — 2026-09-25 19:13:20
- ✅ `2026100101_ceresare_kyjov_article` — 2026-10-01 07:12:56
- ✅ `2026100301_web_guard_own_ai_article` — 2026-10-03 05:10:49
- ✅ `2026100302_efficiency_refilled_article` — 2026-10-03 20:35:52
- ✅ `2026100303_incremental_hd_odds_ratio_article` — 2026-10-03 20:58:56
- ✅ `2026100304_pipeline_i_sign_article` — 2026-10-03 21:20:01
- ✅ `2026100305_three_unsolicited_offers_article` — 2026-10-03 21:21:04
- ✅ `2026100401_what_exists_sunday_article` — 2026-10-04 15:43:57
- ✅ `2026100402_experience_starting_point_article` — 2026-10-04 15:52:55
- ✅ `2026100801_human_skill_md_article` — 2026-10-08 06:37:06
- ✅ `2026100802_remove_blog_contact_ctas` — 2026-10-08 07:11:37
- ✅ `2026101001_blog_prose_pass` — 2026-10-10 21:46:33
- ✅ `2026101501_buy_for_bottleneck_article` — 2026-10-15 16:49:53
- ✅ `2026101502_death_cancellation_rule_article` — 2026-10-15 16:48:13
- ✅ `2026101503_right_number_wrong_currency_article` — 2026-10-15 16:52:21
- ✅ `2026101504_fewer_reports_not_less_work_article` — 2026-10-15 16:52:21
- ✅ `2026101505_largest_version_usefulness_article` — 2026-10-15 17:52:08
- ✅ `2026101506_curiosity_without_borrowed_authority_article` — 2026-10-15 17:54:47
- ✅ `2026101901_normal_results_missing_uacr_article` — 2026-10-19 18:00:44
- ✅ `2026102001_pneumococcal_ckd_eight_weeks_article` — 2026-10-20 12:17:11
- ✅ `2026102401_consent_two_conditions_article` — 2026-10-24 01:42:18
- ✅ `2026102501_names_are_not_reading_article` — 2026-10-25 12:10:52
- ✅ `2026102502_mercury_token_limit_article` — 2026-10-25 17:25:20
- ✅ `2026102503_same_death_three_acts_article` — 2026-10-25 17:55:15
- ✅ `2026102504_same_death_three_acts_title` — 2026-10-25 19:21:58
- ✅ `2026102601_mercury_claude_three_tasks_article` — 2026-10-26 20:44:12
- ✅ `2026102701_drop_manual_pii_backups` — 2026-10-27 07:30:06
- ✅ `2026102702_sanitizer_tags_refresh` — 2026-10-27 16:54:35
- ✅ `2026102703_cheaper_token_higher_bill_article` — 2026-10-27 23:24:39
- ✅ `2026102704_cheaper_token_ramp_not_gartner` — 2026-10-27 23:24:39
- ✅ `2026102801_generated_is_not_delivered_article` — 2026-10-28 00:52:37
- ✅ `2026102803_checkout_before_diagnosis_article` — 2026-10-28 00:56:49
- ✅ `2026102804_right_answer_bad_reason_article` — 2026-10-28 00:56:49
- ✅ `2026102805_typesetting_package_not_print_article` — 2026-10-28 00:57:28
- ✅ `2026102901_month_of_verification_article` — 2026-10-29 19:43:00
- ✅ `2026102902_context_comes_in_batches_article` — 2026-10-29 19:51:24
- ✅ `2026102903_month_of_verification_closing` — 2026-10-29 19:53:20

## Indexy strážené migráciou

- ✅ `form_rate_limit.idx_action_last_attempt`
- ✅ `newsletter_subscribers.idx_confirm_token`
- ✅ `newsletter_subscribers.idx_unsubscribe_token`

## Prístupové účty

- Aktívnych administrátorov: **1**
- Deaktivovaných administrátorov: 0
- Neadministrátorských účtov: 0

## Obsah a jazyky

- Publikovaných článkov: 420
- Články podľa jazyka:
  - `cs`: 42
  - `de`: 42
  - `en`: 42
  - `es`: 42
  - `fr`: 42
  - `hu`: 42
  - `it`: 42
  - `pl`: 42
  - `sk`: 42
  - `uk`: 42
- Obsahové bloky podľa jazyka:
  - `sk`: 5

## Retencia osobných údajov

Nastavená retencia access logov: **90 dní** (`ACCESS_LOG_RETENTION_DAYS`).
Kontaktné správy: **180 dní**; nepotvrdený newsletter: **72 hodín**; administrátorský audit: **365 dní**.

| Tabuľka | Riadkov | Najstarší záznam | Vek (dní) |
| --- | --- | --- | --- |
| `access_logs` | 61986 | 2026-08-01 21:19:21 | 90 |
| `contact_messages` | 2 | 2026-10-29 00:06:00 | 1 |
| `newsletter_subscribers` | 0 | — | — |
| `admin_audit_log` | 54 | 2026-09-11 19:22:06 | 49 |
| `form_rate_limit` | 5 | 2026-10-29 00:06:00 | 1 |

Kontaktné správy: **0** vybavených, **2** nevybavených
(z toho **0** nevybavených dlhšie ako 30 dní, **0** správ prekročilo retenčnú lehotu 180 dní).


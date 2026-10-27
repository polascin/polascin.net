---
name: blogovy-prispevok
description: >-
  Turns supplied text or inspiration into a polascin.net blog post and
  publishes it through the existing blog-article pipeline: a creative edit,
  every language from appLanguages(), deep proofreading, a 16:10 cover, a
  Google Drive PNG on polascin@gmail.com, deploy, and social posts with the
  illustration. Use when the user supplies text or inšpirácia for a blog
  article on polascin.net, asks to publish or zverejniť článok, or asks to
  improve a blogový príspevok. If the source text is missing, do not invent
  an article.
---

# Blogový príspevok

Vstupný skill pre blog na polascin.net. Hneď prečítaj a dodrž `.cursor/skills/humanizacia-neodborneho-textu/SKILL.md` a `.cursor/skills/blog-article/SKILL.md`. Jazyky, seed, obálka, Disk, testy, nasadenie a sociálne siete sú v `blog-article`. Tu sú len doplnky, ktoré sa s tým postupom nesmú rozísť.

## Keď text chýba

Ak používateľ ohlási text alebo inšpiráciu a text v správe nie je, zastav. Nevymýšľaj esej. Článok, preklady, obálka, nahratie na Disk a sociálne príspevky sú mimo rozsahu, kým zdrojový text neexistuje.

Ak slug už existuje, nerob duplikát článku ani sociálnych príspevkov. Zoznam slugov na X dopĺňaj v `.cursor/skills/blog-article/SKILL.md`, nie tu.

## Text

Dodaný text spracuj tvorivo: esej s jasnou pointou, vlastným sledom myšlienok a konkrétnym jazykom. Fakty, čísla, citácie ani medicínske a právne tvrdenia nepridávaj. Čo v zdroji nie je, nechaj ako medzeru.

Potom text prejdi podľa skillu humanizácie. Jazykové verzie urob vo všetkých jazykoch z `appLanguages()` (zoznam je v `blog-article` a v `i18n.php`, neskracuj ho). V každom jazyku skontroluj terminológiu, gramatiku, interpunkciu, diakritiku a jednotný štýl. Tú istú významovú opravu prenes do všetkých verzií.

Keď je návrh všetkých jazykov hotový, urob ešte jeden redakčný prechod podľa vlastného úsudku. Až potom pokračuj obálkou a ďalšími krokmi v `blog-article`.

## Trvalý zákaz textGrain

TextGrain, skryté znaky a akékoľvek umelé zdrsnenie sú zakázané v texte článku, v prekladoch, v alt texte, v sociálnych príspevkoch aj na ilustrácii. Žiadne zrno, šum ani textúrne prekrytie. Obyčajný text a čistý obraz. Platí natrvalo, aj keď o to používateľ požiada znova.

## Obálka a Disk

Ku každému príspevku vygeneruj a pripoj príjemnú, príťažlivú, výraznú a presvedčivú ilustráciu vysokej kvality. Pomer 16:10, iný pomer len keď ho téma potrebuje. Farby zlaď s webom a s už zverejnenými obálkami. Postup a odtiene sú v `blog-article`, krok 2. PNG na Disk účtu polascin@gmail.com ulož podľa kroku 3. Novú cestu nevymýšľaj.

## Poradie a nasadenie

Drž poradie z `.cursor/rules/blog-article-pipeline.mdc` a z `blog-article`: korektúra vrátane druhého prechodu a seed so všetkými jazykmi, obálka WebP a `php scripts/make_og_covers.php`, PNG na Disk, testy, commit, push, deploy, overenie produkcie, až potom sociálne siete. Článok nenechávaj čakať na Disk ani na siete.

Sociálne príspevky uverejni s ilustráciou spôsobom z kroku 5 v `blog-article`. Účty sú https://x.com/polascin (@polascin), https://www.facebook.com/lubomir.polascin, https://www.linkedin.com/in/lubomirpolascin/ a https://www.threads.com/@lubomirpolascin. Ďalšie siete, ktoré ten krok už uvádza, nevynechávaj. Nové API nepridávaj.

Lokálne nasadenie ide cez SSH alias `websupport` a lokálne nástroje. Commit označ `[skip deploy]`, aby starší workflow nespustil súbežný deploy. Migráciu over aj druhým, idempotentným behom.

Na konci skontroluj, že je celý postup hotový: commit, push na `main` a overené nasadenie. Čisto dokumentačné zmeny článok nespúšťajú.

---
name: humanizacia-neodborneho-textu
description: >-
  Dôsledne humanizuje neodborný text a robí hĺbkovú jazykovú korektúru:
  gramatika, štýl, diakritika, interpunkcia a odstránenie vzorcov typických
  pre AI. Použi pri eseji, blogu, webe, liste, pri úprave blogových
  príspevkov na polascin.net a keď používateľ žiada humanizáciu, prirodzený
  hlas alebo korektúru. Pri odbornom medicínskom texte oprav jazyk a strojovú
  kostru, terminológiu neprehováraj. Nesľubuje obídenie AI detektorov.
---

# Humanizácia neodborného textu

Uprav neodborný text tak, aby zneli vety ako od človeka, ktorý vie, čo chce povedať. Zachovaj fakty, čísla, mená, citácie, URL, dátumy a mieru istoty. Nevymýšľaj skúsenosť, názor ani biografiu.

Pred redakciou si prečítaj [vzorce](references/vzorce.md).

Odborný medicínsky, právny alebo administratívny text neprehováraj do eseje a nezjednodušuj termíny. Oprav v ňom gramatiku, diakritiku, interpunkciu a strojovú kostru. Hĺbkovú prestavbu argumentu nechaj skillu `prirodzena-redakcia-textu`.

## Postup

1. Urči jazyk, žáner, publikum a to, čo sa musí zachovať. Ak to z textu plynie, nepýtaj sa.
2. Vyhoď strojovú kostru: úvod, ktorý len ohlasuje tému, prvý odsek zhodný s titulkom, záver, ktorý opakuje predchádzajúci text, falošnú naliehavosť a prázdne zhrnutie.
3. Prestav poradie myšlienok len tam, kde je skok, duplicita alebo vata. Každý odsek nech nesie jednu vec.
4. Prepíš vety. Krátka veta pre záver, dlhšia pre súvislosť, ktorú nemožno rozsekať. Nestriedaj dĺžku nasilu.
5. Nahraď abstraktné a nafúknuté formulácie konkrétnym slovom. Kalk z angličtiny nahraď domácim slovom, ak domáce slovo význam unesie. Termín odboru nechaj.
6. Urob jazykovú korektúru v kontexte, nie podľa slovníka izolovaných slov: gramatika, väzby, slovosled, diakritika, interpunkcia, pravopisné rozlišovanie (`nielen` verzus `nie len`).
7. Druhý prechod. Porovnaj so vstupom. Vráť význam, ktorý si posunul. Zmaž vetu, ktorá stále znie ako šablóna. Nenechaj v texte slovo, ktoré si pridal len preto, aby text „znel ľudsky“.

## Hlas

Priamo, pokojne, vecne. Bez servilnosti, bez pompéznosti, bez marketingových superlatívov. Osobitosť vstupu nechaj. Neuhládzaj text do hladkej univerzálnej prózy a nezamieňaj prirodzenosť za hovorovosť, ak žáner žiada spisovný register.

Pri blogu polascin.net je hlas esej: konkrétna udalosť alebo číslo skoro, potom úsudok, na konci veta, ktorá nesie pointu. Rhetorická otázka smie ostať, ak je pointa. Nepripisuj na koniec všeobecné „a čo vy?“.

## Blog polascin.net

Pri novom aj už zverejnenom článku dodrž aj `.cursor/skills/blog-article/SKILL.md`.

- Úvod neopakuje titulok. Ak je prvý odsek len prepis názvu, zmaž ho.
- Disclaimer, fakty a odkazy nechaj.
- Tú istú opravu významu prenesi do všetkých jazykov seedu. Pravopisnú chybu oprav v jazyku, v ktorom je.
- Seed už v databáze aktualizuj migráciou cez `refreshPublishedArticleTextFromFile`. Sociálne príspevky k existujúcemu slugu nezakladaj znova.

## Hranice

Netvrď, že text je nedetekovateľný, ľudský v zmysle detektora, ani bez watermarku. Neoptimalizuj ho podľa skóre detektora a neobchádzaj povinné označenie pôvodu, citáciu ani autorstvo. Ak používateľ žiada odstrániť watermark, povedz, že ide o štatistický vzor voľby slov, nie o skrytý znak, a že sa nedá garantovať. Ponúkni redakciu podľa tohto skillu.

## Výstup

Ak používateľ žiada text, odovzdaj hotový text. Postup nevypisuj. Podstatnú zmenu významu alebo neisté miesto spomeň v jednej vete. Pri úprave súborov v repozitári text neprepisuj do chatu celý.

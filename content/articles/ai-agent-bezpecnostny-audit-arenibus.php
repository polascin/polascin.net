<?php

declare(strict_types=1);

$requestedScript = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? ''));
$executedFile = isset($_SERVER['SCRIPT_FILENAME']) ? realpath((string) $_SERVER['SCRIPT_FILENAME']) : false;
if (
    $executedFile === __FILE__
    || preg_match('~(?:^|/)content/articles/.+\.php(?:/|$)~i', $requestedScript) === 1
) {
    if (PHP_SAPI === 'cli') {
        fwrite(STDERR, "Chyba: súbor článku je interný a nemožno ho spúšťať priamo.\n");
        exit(1);
    }
    http_response_code(403);
    exit('Prístup odmietnutý.');
}
unset($requestedScript, $executedFile);

/**
 * Blogový príspevok o bezpečnostnom audite Arenibusu s AI agentom.
 * Zdroj: CI/CD a audit 15.–16. 9. 2026 (Claude Opus 5, 14 nálezov, v0.17.128).
 */
return [
    'slug' => 'ai-agent-bezpecnostny-audit-arenibus',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-09-17 18:50:00',
    'translations' => [
        'sk' => [
            'title' => 'AI agent našiel 3 závažné bezpečnostné nálezy. Opravu som nasadil ešte pred ránom.',
            'excerpt' => 'Ako sólový lekár-vývojár používam Claude Opus 5 a Cursor na bezpečnostný audit Arenibusu. Včera agent nahlásil 14 nálezov, tri z nich s vysokou prioritou, napísal záplaty a pred spaním odišla verzia v0.17.128.',
            'content' => <<<'HTML'
<p>Včera v noci našiel AI agent v mojej aplikácii tri závažné bezpečnostné zraniteľnosti, napísal záplaty a pomohol mi ich dostať do produkcie ešte pred ránom.</p>
<p>Staviam <a href="https://arenibus.polascin.net/">Arenibus</a>, informačný systém v .NET pre nefrológiu a manažment dialýzy. Ako sólový vývojár, ktorý je zároveň lekár, nemám tím DevSecOps. Tú medzeru som začal zapĺňať Claude Opus 5 a Cursorom.</p>
<p>Včera som spustil úplný bezpečnostný audit. AI prešla kód a nahlásila 14 nálezov — tri z nich s vysokou prioritou. Ku každému napísala záplatu. Pred zlúčením som si prečítal každý riadok.</p>
<p>CI pipeline spustila 1&nbsp;011 testov Vitest. Všetky zelené. Predtým, než som išiel spať, odišla verzia v0.17.128.</p>
<p>Toto nie je hypotéza. Ani demo. Je to skutočný postup, ktorým ako jeden človek posielam do sveta klinický softvér.</p>
<p>Chcem byť úprimný v jednom: AI nenahradila úsudok. Vyniesla na povrch veci, ktoré by som prehliadol, a napísala boilerplate, ktorý som písať nechcel. Ale rozhodnúť, či nález záleží, či je záplata správna a či je bezpečné nasadiť — to ostáva na mne.</p>
<p>Skutočný posun nie je v tom, že „AI píše kód“. Je v tom, že priepasť medzi tým, čo zvládne sólový zakladateľ, a tým, čo zvládne malý tím, sa dramaticky zúžila.</p>
<p>Ak staviate niečo sami: ktorú jednu úlohu by ste AI agentovi odovzdali ako prvú? Napíšte mi cez <a href="contact.php">kontakt</a>.</p>
HTML,
        ],
        'en' => [
            'title' => 'Last night an AI agent found 3 high-priority vulnerabilities. We shipped the fix before morning.',
            'excerpt' => 'As a solo physician-developer I use Claude Opus 5 and Cursor to security-audit Arenibus. Yesterday the agent flagged 14 findings, three of them high priority, wrote the patches, and v0.17.128 went out before I slept.',
            'content' => <<<'HTML'
<p>Last night an AI agent found three high-priority security vulnerabilities in my app, wrote the patches, and helped me ship the fix before morning.</p>
<p>I have been building <a href="https://arenibus.polascin.net/">Arenibus</a>, a .NET information system for nephrology and dialysis management. As a solo developer who is also a physician, I do not have a DevSecOps team. So I have been using Claude Opus 5 and Cursor to fill that gap.</p>
<p>Yesterday I ran a full security audit. The AI reviewed the codebase and flagged 14 findings — three of them high priority. It then wrote the patches for each one. I reviewed every line before merging.</p>
<p>The CI pipeline ran 1,011 Vitest tests. All green. I deployed v0.17.128 before I went to bed.</p>
<p>This is not a hypothetical. It is not a demo. It is the actual workflow I use to ship clinical software as a one-person team.</p>
<p>The part I want to be honest about: the AI did not replace judgment. It surfaced things I would have missed and wrote boilerplate I did not want to write. But deciding whether a finding matters, whether the patch is correct, and whether it is safe to deploy — that is still on me.</p>
<p>The real shift is not “AI writes code.” It is that the gap between what a solo founder can build and what a small team can build has narrowed dramatically.</p>
<p>If you are building something alone, what is the one task you would hand to an AI agent first? Write to me via the <a href="contact.php">contact form</a>.</p>
HTML,
        ],
    ],
];

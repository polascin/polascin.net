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
 * Authority príspevok o model-agnostickom AI workflow.
 * Zdroj: Kilo Code Weekly (11. 9. 2026), DeepSeek-V4.1-Flash, GPT-6 Astra, OpenRouter.
 */
return [
    'slug' => 'ai-modely-ako-nastroje-nie-operacny-system',
    'author' => 'MUDr. Ľubomír Polaščín',
    'category' => 'blog',
    'is_top' => 0,
    'published_at' => '2026-09-17 19:00:00',
    'image' => 'images/articles/ai-modely-ako-nastroje-nie-operacny-system.webp',
    'translations' => [
        'sk' => [
            'title' => 'Ak celý workflow visí na jednom AI modeli, nemáte workflow. Máte predplatné.',
            'image_alt' => 'Otvorená taška s nástrojmi namiesto zamknutého operačného systému — každý AI model ako iný nástroj.',
            'excerpt' => 'DeepSeek-V4.1-Flash, GPT-6 Astra a nástroje ako OpenRouter a Kilo Code ukazujú, že model treba voliť podľa úlohy. Kto si workflow postaví okolo jedného modelu, pri ďalšej aktualizácii ostane stáť.',
            'content' => <<<'HTML'
<p>Ak celý workflow visí na jednom AI modeli, nemáte workflow. Máte predplatné.</p>
<p>Tento týždeň ukázali nové vydania modelov niečo jasné: vstupujeme do éry slobody vo výbere modelu — a väčšina ľudí si to ešte nevšimla.</p>
<p>Vyšiel DeepSeek-V4.1-Flash. GPT-6 Astra dostal aktualizácie. A nástroje, ktoré skutočne používam — <a href="https://openrouter.ai/">OpenRouter</a> a <a href="https://kilo.ai/">Kilo Code</a> — sa nestarajú, ktorý je „najlepší“. Smerujú na správny model podľa úlohy.</p>
<p>AI používam v niekoľkých veľmi odlišných úlohách. Pri zhrnutí medicínskej literatúry chcem model, ktorý zvládne uvažovanie v dlhom kontexte. Pri písaní C# migrácií ten, ktorý píše čistý, idiomatický kód. Pri rýchlych prekladoch medicínskej terminológie medzi slovenčinou a angličtinou chcem rýchlosť pred hĺbkou.</p>
<p>Žiadny jeden model nevyhráva všetky tri. A ten, ktorý vyhráva dnes, nemusí vyhrať budúci mesiac.</p>
<p>Pasca je postaviť si postup okolo zvlášností jedného modelu. Keď sa zmení — a zmení sa — workflow sa zlomí. Vidím to pri tímoch, ktoré sa preučia na konkrétnu štruktúru promptu alebo správanie API a potom stratia dni, keď poskytovateľ nasadí aktualizáciu.</p>
<p>Princíp: berte modely ako náradie v taške, nie ako operačný systém. Voľne ich vymeňte. Merajte výstupy, nie vernosť značke.</p>
<p>Tímy, ktoré si teraz postavia modelovo nezávislý workflow, sa prispôsobia rýchlejšie ako tie, ktoré si vyberú stranu. Viac o tomto prístupe píše aj Kilo pod heslom <a href="https://kilo.ai/model-freedom">model freedom</a>.</p>
<p>Smerujete medzi modelmi, alebo ste oddaní jednému? Napíšte mi cez <a href="contact.php">kontakt</a>.</p>
HTML,
        ],
        'en' => [
            'title' => 'If your entire workflow depends on one AI model, you do not have a workflow. You have a subscription.',
            'image_alt' => 'An open tool bag instead of a locked operating system — each AI model as a different instrument.',
            'excerpt' => 'DeepSeek-V4.1-Flash, GPT-6 Astra, and tools like OpenRouter and Kilo Code make the point: pick the model for the task. Build around one vendor’s quirks and the next update will stall you.',
            'content' => <<<'HTML'
<p>If your entire workflow depends on one AI model, you do not have a workflow. You have a subscription.</p>
<p>This week’s AI model releases made something clear: we are entering the era of model freedom, and most people have not noticed.</p>
<p>DeepSeek-V4.1-Flash dropped. GPT-6 Astra shipped updates. And the tools I actually use — <a href="https://openrouter.ai/">OpenRouter</a> and <a href="https://kilo.ai/">Kilo Code</a> — do not care which one is “best.” They route to the right model for the task automatically.</p>
<p>I use AI across several very different jobs. For summarizing medical literature, I want the model that handles long-context reasoning. For writing C# migrations, I want the one that writes clean, idiomatic code. For quick translations between Slovak and English medical terminology, I want speed over depth.</p>
<p>No single model wins all three. And the one that wins today will not necessarily win next month.</p>
<p>The trap is building your process around one model’s quirks. When it changes — and it will — your workflow breaks. I have seen this with teams that overfit to a specific prompt structure or API behavior, then lose days when the provider ships an update.</p>
<p>The principle: treat models like tools in a bag, not like an operating system. Swap freely. Measure outputs, not brand loyalty.</p>
<p>The teams that build model-agnostic workflows now will adapt faster than the ones picking a side. Kilo frames the same idea as <a href="https://kilo.ai/model-freedom">model freedom</a>.</p>
<p>Are you routing between models, or are you committed to one? Write to me via the <a href="contact.php">contact form</a>.</p>
HTML,
        ],
    ],
];

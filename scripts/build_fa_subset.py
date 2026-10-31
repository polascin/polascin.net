#!/usr/bin/env python3
"""Zostaví podmnožinu Font Awesome len s ikonami, ktoré web používa.

Plný balík (fontawesome.css 86 KB, fa-solid-900.woff2 113 KB,
fa-brands-400.woff2 101 KB) blokoval vykreslenie každej stránky, hoci
šablóny používajú asi tridsať ikon. Skript nájde triedy `fa-*` v šablónach
v koreni repozitára a v `js/`, z CSS balíka vyberie jadro a pravidlá týchto
ikon a písma oreže na ich znaky.

Výstup:
  css/icons.css
  fonts/icons-solid.woff2
  fonts/icons-brands.woff2

Spustenie (vyžaduje fonttools a brotli, venv mimo repozitára):
  python -m venv "$TEMP/fa-venv" && "$TEMP/fa-venv/Scripts/pip" install fonttools brotli
  PYTHONUTF8=1 "$TEMP/fa-venv/Scripts/python" scripts/build_fa_subset.py

Po pridaní novej ikony do šablóny skript spusti znova. `tests/run.php`
zlyhá, ak niektorá použitá ikona v podmnožine chýba.
"""

from __future__ import annotations

import hashlib
import re
import sys
from pathlib import Path

from fontTools import subset

ROOT = Path(__file__).resolve().parent.parent
FA_DIR = ROOT / "fontawesome-free-7.1.0-web"
OUT_CSS = ROOT / "css" / "icons.css"
OUT_FONTS = {
    "solid": ROOT / "fonts" / "icons-solid.woff2",
    "brands": ROOT / "fonts" / "icons-brands.woff2",
}
SRC_FONTS = {
    "solid": FA_DIR / "webfonts" / "fa-solid-900.woff2",
    "brands": FA_DIR / "webfonts" / "fa-brands-400.woff2",
}

# Triedy štýlu a pomocné triedy nie sú ikony.
NON_ICON = {
    "solid", "regular", "brands", "classic", "fw", "xs", "sm", "lg", "xl",
    "2xs", "2xl", "1x", "2x", "3x", "4x", "5x", "6x", "7x", "8x", "9x", "10x",
    "spin", "pulse", "border", "inverse", "ul", "li", "stack", "stack-1x",
    "stack-2x", "flip", "beat", "fade", "bounce", "shake",
}

ICON_RULE = re.compile(r'^\.fa-([a-z0-9-]+) \{\n  --fa: "\\([0-9a-f]+)";\n\}\n', re.M)


def used_icons() -> list[str]:
    sources = list(ROOT.glob("*.php")) + list(ROOT.glob("*.html")) + list((ROOT / "js").glob("*.js"))
    names: set[str] = set()
    for path in sources:
        text = path.read_text(encoding="utf-8")
        names.update(re.findall(r"\bfa-([a-z0-9]+(?:-[a-z0-9]+)*)\b", text))
    return sorted(n for n in names if n not in NON_ICON)


def icon_rules(css: str) -> dict[str, tuple[str, str]]:
    return {m.group(1): (m.group(0), m.group(2)) for m in ICON_RULE.finditer(css)}


def subset_font(src: Path, dst: Path, codepoints: list[int]) -> str:
    options = subset.Options()
    options.flavor = "woff2"
    options.layout_features = ["*"]
    options.name_IDs = ["*"]
    options.notdef_outline = True
    font = subset.load_font(str(src), options)
    subsetter = subset.Subsetter(options)
    subsetter.populate(unicodes=codepoints)
    subsetter.subset(font)
    subset.save_font(font, str(dst), options)
    return hashlib.sha256(dst.read_bytes()).hexdigest()[:8]


def main() -> int:
    core_css = (FA_DIR / "css" / "fontawesome.css").read_text(encoding="utf-8")
    solid_css = (FA_DIR / "css" / "solid.css").read_text(encoding="utf-8")
    brands_css = (FA_DIR / "css" / "brands.css").read_text(encoding="utf-8")

    first_icon = core_css.index("\n.fa-0 {")
    core_head = core_css[:first_icon].rstrip() + "\n"
    solid_rules = icon_rules(core_css)
    brand_rules = icon_rules(brands_css)
    brands_head = brands_css[: brands_css.index("\n.fa-firefox-browser {")].rstrip() + "\n"

    picked: dict[str, list[tuple[str, str]]] = {"solid": [], "brands": []}
    missing = []
    for name in used_icons():
        if name in brand_rules:
            picked["brands"].append(brand_rules[name])
        elif name in solid_rules:
            picked["solid"].append(solid_rules[name])
        else:
            missing.append(name)
    if missing:
        print("Neznáme ikony: " + ", ".join(missing), file=sys.stderr)
        return 1

    versions = {}
    for style, rules in picked.items():
        codepoints = sorted({int(code, 16) for _, code in rules})
        versions[style] = subset_font(SRC_FONTS[style], OUT_FONTS[style], codepoints)

    def font_src(style: str, css: str, original: str) -> str:
        url = f'url("../fonts/{OUT_FONTS[style].name}?v={versions[style]}") format("woff2")'
        return css.replace(f'url("../webfonts/{original}")', url)

    parts = [
        "/* Podmnožina Font Awesome Free 7.1.0, generuje scripts/build_fa_subset.py; needitovať ručne. */\n",
        core_head,
        font_src("solid", solid_css, "fa-solid-900.woff2").rstrip() + "\n",
        font_src("brands", brands_head, "fa-brands-400.woff2"),
    ]
    for style in ("solid", "brands"):
        parts.extend("\n" + rule for rule, _ in picked[style])
    OUT_CSS.write_text("".join(parts), encoding="utf-8", newline="\n")

    total = sum(len(v) for v in picked.values())
    print(f"{total} ikon ({len(picked['solid'])} solid, {len(picked['brands'])} brands)")
    for style, path in OUT_FONTS.items():
        print(f"{path.relative_to(ROOT).as_posix()}: {path.stat().st_size} B")
    print(f"{OUT_CSS.relative_to(ROOT).as_posix()}: {OUT_CSS.stat().st_size} B")
    return 0


if __name__ == "__main__":
    sys.exit(main())

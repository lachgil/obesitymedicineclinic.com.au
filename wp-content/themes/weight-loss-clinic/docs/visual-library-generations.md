# Visual Library — Generation Log

Records every Higgsfield generation that was accepted into
`assets/images/`. Each entry captures the target filename, the full prompt
sent to the model, the Higgsfield job ID, and a one-line note on retry.

Reference framework: `docs/visual-library.md`.
Reference truth set: `ventures/weight-loss-clinic/Dr. Kevin Dolan Photographs/`.

Model used throughout: **GPT Image 2** (`job_set_type: gpt_image_2`,
backend model `videotape-alpha`), `quality: high`, `resolution: 2k`,
downsampled to the spec dimensions before saving as JPEG q88.

---

## 1. `assets/images/pathway/01-assessment.jpg`

- **Aspect ratio:** 4:3 landscape (1600x1200, generated at 2336x1744)
- **Higgsfield job ID:** `b2b81846-89d7-4ff6-812b-654a0429c1e2`
- **Result URL:** https://d8j0ntlcm91z4.cloudfront.net/user_3Bdf2mKmJHJE1ie5lLwtpzuOdMU/hf_20260514_071945_b2b81846-89d7-4ff6-812b-654a0429c1e2.png
- **Retry?** No — accepted on first try.
- **Notes:** Strong Kevin Dolan match. Overweight late-40s Australian woman in soft knit jumper, ordinary lived-in kitchen with fruit bowl, paperwork, mug, kid's drawings on noticeboard, warm-neutral daylight from blinds. Off-centre composition, mid-task posture, no smile. No Firefly watermark.

**Prompt (verbatim worked example A1 from visual-library.md §6):**

```
Match the photographic world of Dr Kevin Dolan's real Australian clinic photographs: warm-neutral colour temperature ~5400K, large white horizontal venetian blinds spilling soft daylight across the back of the frame, off-white walls, lived-in Australian clinical or domestic interior, untouched skin texture with visible pores and lines, ~35–85mm lens feel, moderate depth of field with the background readable but not blurred, editorial off-centre composition, mid-task working posture, calm and medically serious — not a wellness or SaaS stock ad.

Subject: an overweight Australian woman in her late 40s, ordinary work clothes (a soft knit jumper, no makeup retouching, hair down, real skin texture, dignified and private). She is sitting at a kitchen table in an ordinary Australian home — Laminex bench visible behind her, a half-empty mug of tea, a stack of household paperwork off to one side. She is looking at a laptop screen completing a short confidential health assessment, not smiling, calm, focused, slightly relieved that she has begun.

Shot on a 35mm DSLR with natural window light, warm-neutral 5400K, mild contrast, real shadow on the side of the face, slight grain. Editorial documentary feel. Background readable. Composition off-centre, subject in the right two-thirds of the frame, daylight from a window behind her left shoulder.

No before/after imagery. No gym setting. No fitness influencer. No pharmaceutical advertising gloss. No fake influencer look. No styled wellness aesthetic. No beige minimalist designer kitchen. No navy polo on a lean stubbled 30-something man. No Firefly-style sparkle watermark. No skin smoothing. No teeth-bared stock smile. No body-shaming framing.

Aspect ratio: 4:3 landscape. 1600x1200.
```

---

## 2. `assets/images/pathway/03-ongoing.jpg`

- **Aspect ratio:** 4:3 landscape (1600x1200, generated at 2336x1744)
- **Higgsfield job ID:** `db353270-78aa-4920-82d1-58ba0084c4f8`
- **Result URL:** https://d8j0ntlcm91z4.cloudfront.net/user_3Bdf2mKmJHJE1ie5lLwtpzuOdMU/hf_20260514_072428_db353270-78aa-4920-82d1-58ba0084c4f8.png
- **Retry?** No — accepted on first try.
- **Notes:** Plus-size late-20s Australian woman on a small lounge sofa, reading a phone with a calm relieved half-smile (not a stock teeth-bared grin). White horizontal venetian blinds directly behind her — closest direct callback to Kevin Dolan 002. Bookshelf, folded throw, glass of water, framed picture all present. Warm-neutral daylight. Off-centre composition. No Firefly watermark, no influencer body type.

**Prompt (worked example B1 from visual-library.md §6 with Section 4 clauses substituted verbatim):**

```
Match the photographic world of Dr Kevin Dolan's real Australian clinic photographs: warm-neutral colour temperature ~5400K, large white horizontal venetian blinds spilling soft daylight across the back of the frame, off-white walls, lived-in Australian clinical or domestic interior, untouched skin texture with visible pores and lines, ~35–85mm lens feel, moderate depth of field with the background readable but not blurred, editorial off-centre composition, mid-task working posture, calm and medically serious — not a wellness or SaaS stock ad.

Subject: a plus-size Australian woman in her late 20s, ordinary t-shirt, jeans, hair tied back, real skin texture, no makeup retouching. She is sitting at home — a small two-seater sofa visible, a folded throw, a glass of water on a side table. She is reading a confirmation message on her phone after submitting a clinical assessment, the expression is calm and relieved, not performative.

Shot on a 35mm DSLR with natural window light, warm-neutral 5400K, mild contrast, real shadow on the side of the face, slight grain. Editorial documentary feel. Background readable. Composition off-centre. Subject three-quarter or candid. No HDR, no cinematic LUT, no glamour retouching.

No before/after imagery. No gym setting. No fitness influencer. No pharmaceutical advertising gloss. No fake influencer look. No styled wellness aesthetic. No beige minimalist designer kitchen. No navy polo on a lean stubbled 30-something man. No Firefly-style sparkle watermark. No skin smoothing. No teeth-bared stock smile. No body-shaming framing. No weight-related visual jokes.

Aspect ratio: 4:3 landscape. 1600x1200.
```

---

## 3. `assets/images/intake/intake-welcome.jpg`

- **Aspect ratio:** 16:9 landscape (1600x900, generated at 2688x1520)
- **Higgsfield job ID:** `d0dac9a1-eff3-4431-acf8-0d9c2eb46d69`
- **Result URL:** https://d8j0ntlcm91z4.cloudfront.net/user_3Bdf2mKmJHJE1ie5lLwtpzuOdMU/hf_20260514_072857_d0dac9a1-eff3-4431-acf8-0d9c2eb46d69.png
- **Retry?** No — accepted on first try.
- **Notes:** Quiz-sidebar variant of the assessment scene. Older Anglo-Australian woman in her early 60s, grey cardigan, reading glasses, ordinary lived-in kitchen with magnets/photos on the fridge, ceramic mug, mid-task posture at the laptop. White horizontal venetian blinds behind. Slippers detail came through. Different patient, different angle — clearly distinct from `01-assessment.jpg` while keeping the same photographic world.

**Prompt (built from visual-library.md §4 framework — reference anchor + subject + action + environment + photographic spec + negative clauses):**

```
Match the photographic world of Dr Kevin Dolan's real Australian clinic photographs: warm-neutral colour temperature ~5400K, large white horizontal venetian blinds spilling soft daylight across the back of the frame, off-white walls, lived-in Australian clinical or domestic interior, untouched skin texture with visible pores and lines, ~35–85mm lens feel, moderate depth of field with the background readable but not blurred, editorial off-centre composition, mid-task working posture, calm and medically serious — not a wellness or SaaS stock ad.

Subject: an older Anglo-Australian woman in her early 60s, soft grey cardigan over a plain blouse, reading glasses perched on the end of her nose, hair softly grey, real skin with lines and age spots, no makeup retouching, dignified and private. She is sitting at the kitchen table in an ordinary Australian home — Laminex bench in the background, a ceramic mug, a folded tea towel, a pair of slippers visible at the floor edge. She is about to begin a confidential online health assessment on her laptop, hand resting on the trackpad, looking at the screen with quiet attention, not smiling, mood is calm and private.

Shot on a 35mm DSLR with natural window light, warm-neutral 5400K, mild contrast, real shadow on the side of the face, slight grain. Editorial documentary feel. Background readable. Composition off-centre, subject in the left two-thirds of the frame, daylight from a window behind her right shoulder casting horizontal blind bars on the back wall.

No before/after imagery. No gym setting. No fitness influencer. No pharmaceutical advertising gloss. No fake influencer look. No styled wellness aesthetic. No beige minimalist designer kitchen. No navy polo on a lean stubbled 30-something man. No Firefly-style sparkle watermark. No skin smoothing. No teeth-bared stock smile. No body-shaming framing. No weight-related visual jokes.

Aspect ratio: 16:9 landscape. 1600x900.
```

---

## 4. `assets/images/intake/intake-pathway.jpg`

- **Aspect ratio:** 16:9 landscape (1600x900, generated at 2688x1520)
- **Higgsfield job ID:** `727656eb-d4e4-46d5-931b-014717691666`
- **Result URL:** https://d8j0ntlcm91z4.cloudfront.net/user_3Bdf2mKmJHJE1ie5lLwtpzuOdMU/hf_20260514_073230_727656eb-d4e4-46d5-931b-014717691666.png
- **Retry?** No — accepted on first try.
- **Notes:** Lebanese-Australian woman in cream cotton hijab and plain tunic, sitting back from a closed laptop, eyes lowered in calm relief, real skin without smoothing. Ordinary Australian dining room — mail stack, tea glass, family photo, plant, coffee maker on bench. The white horizontal venetian blinds behind are a near-direct visual rhyme with Kevin Dolan 011 — the model has actually internalised the reference world.

**Prompt (built from visual-library.md §4 framework):**

```
Match the photographic world of Dr Kevin Dolan's real Australian clinic photographs: warm-neutral colour temperature ~5400K, large white horizontal venetian blinds spilling soft daylight across the back of the frame, off-white walls, lived-in Australian clinical or domestic interior, untouched skin texture with visible pores and lines, ~35–85mm lens feel, moderate depth of field with the background readable but not blurred, editorial off-centre composition, mid-task working posture, calm and medically serious — not a wellness or SaaS stock ad.

Subject: a Lebanese-Australian woman in her late 30s, soft cream cotton hijab worn ordinarily (not styled), plain long-sleeve cotton tunic, real skin texture with visible pores, no makeup retouching, dignified and calm. She is sitting at her dining table in an ordinary Australian home — Laminex tabletop, an everyday tea glass beside her, a stack of opened mail to one side. The laptop in front of her is closed; she has just submitted a confidential clinical health assessment and is sitting back slightly in the chair with her hands resting in her lap, eyes lowered for a moment, the expression is calm relief — not smiling, not posed, just a private exhale of having taken the first step.

Shot on a 35mm DSLR with natural window light, warm-neutral 5400K, mild contrast, real shadow on the side of the face, slight grain. Editorial documentary feel. Background readable. Composition off-centre, subject in the right two-thirds of the frame, daylight from a window behind her casting horizontal blind bars on the off-white wall.

No before/after imagery. No gym setting. No fitness influencer. No pharmaceutical advertising gloss. No fake influencer look. No styled wellness aesthetic. No beige minimalist designer kitchen. No navy polo on a lean stubbled 30-something man. No Firefly-style sparkle watermark. No skin smoothing. No teeth-bared stock smile. No body-shaming framing. No weight-related visual jokes.

Aspect ratio: 16:9 landscape. 1600x900.
```

---

## 5. `assets/images/intake/intake-questions.jpg`

- **Aspect ratio:** 16:9 landscape (1600x900, generated at 2688x1520)
- **Higgsfield job ID:** `e59c93d5-ef93-4941-ba04-aa4afbbeb7cc`
- **Result URL:** https://d8j0ntlcm91z4.cloudfront.net/user_3Bdf2mKmJHJE1ie5lLwtpzuOdMU/hf_20260514_073643_e59c93d5-ef93-4941-ba04-aa4afbbeb7cc.png
- **Retry?** No — accepted on first try.
- **Notes:** Strongest match of the batch. Overweight mid-50s Australian man with real body type, jowls, day-old stubble, thin metal reading glasses, dark grey marle t-shirt, focused brow. Phone held in both hands. Lived-in lounge with framed family photo, "Australia / NSW" book on the shelf (lovely incidental Australian-touch detail the model added unprompted), folded throw, remote on armrest, glass of water on coffee table. White horizontal blinds behind. No Firefly watermark. Could almost be a candid frame from the same Kevin Dolan shoot day.

**Prompt (built from visual-library.md §4 framework):**

```
Match the photographic world of Dr Kevin Dolan's real Australian clinic photographs: warm-neutral colour temperature ~5400K, large white horizontal venetian blinds spilling soft daylight across the back of the frame, off-white walls, lived-in Australian clinical or domestic interior, untouched skin texture with visible pores and lines, ~35–85mm lens feel, moderate depth of field with the background readable but not blurred, editorial off-centre composition, mid-task working posture, calm and medically serious — not a wellness or SaaS stock ad.

Subject: an overweight Australian man in his mid 50s, plain dark grey marle t-shirt and worn jeans, thin metal-frame reading glasses, short greying hair, day-old stubble, real skin texture with pores and lines, no makeup retouching, dignified and private. He is sitting forward on an ordinary three-seater fabric sofa in a lived-in Australian living room — a folded throw beside him, a remote control on the armrest, a half-drunk glass of water on a coffee table in the foreground, a bookshelf and a framed family photo on the wall behind. He is holding a smartphone in both hands and reading a sequence of clinical assessment questions on the screen, expression is focused and serious, brow slightly furrowed in concentration, not smiling.

Shot on a 35mm DSLR with natural window light, warm-neutral 5400K, mild contrast, real shadow on the side of the face, slight grain. Editorial documentary feel. Background readable. Composition off-centre, subject in the left two-thirds of the frame, daylight from a window behind him casting horizontal blind bars on the off-white wall.

No before/after imagery. No gym setting. No fitness influencer. No pharmaceutical advertising gloss. No fake influencer look. No styled wellness aesthetic. No beige minimalist designer kitchen. No navy polo on a lean stubbled 30-something man. No Firefly-style sparkle watermark. No skin smoothing. No teeth-bared stock smile. No body-shaming framing. No weight-related visual jokes.

Aspect ratio: 16:9 landscape. 1600x900.
```

---

## Batch summary

- **Date:** 2026-05-14
- **Images generated:** 5 / 5 (all accepted on first try; zero retries)
- **Total Higgsfield credit spend:** 35 credits (7 credits per image — GPT Image 2 high quality, 2k)
- **Wall time:** ~17 minutes start-to-finish for the batch
- **Operator:** Claude Code session against `charlie.gray@surfpacific.com.au`


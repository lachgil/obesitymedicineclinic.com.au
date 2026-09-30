# Visual Library — Kevin Dolan-Aligned Image System

The site has two photographic worlds bolted together. The real Dr Kevin Dolan
photographs are warm, lived-in, daylit Australian clinic photography. The
existing AI-generated patient/lifestyle images are SaaS-stock men in beige
minimalist kitchens — they belong to a different brand. This document is the
canonical reference for closing that gap.

Anything generated for this brand from now on must visually pass for the same
shoot day as the real Kevin Dolan photographs.

---

## 1. Source library — Kevin Dolan reference set

23 original photographs, single-day shoot, 2018-10-06.

Path: `ventures/weight-loss-clinic/Dr. Kevin Dolan Photographs/`

| File | Scene | Use as reference for |
|------|-------|----------------------|
| 002 | Kevin standing beside exam table, full-length, sunlit white blinds | Clinical room scenes, full-length figures |
| 003–004 | Variants of 002 | Wardrobe + posture continuity |
| 007 | Office desk, three-quarter, anatomical model on desk | Desk/consultation scenes |
| 010–011 | Office desk, writing in folder, clinic literature visible | Patient-facing consultation, paperwork |
| 014–016 | Talking-with-hands, anatomical model | Education / explanation framing |
| 021 | Holding stomach model, animated explanation | Procedural explanation |
| 023–025 | Same desk continuity | Continuity for any "in office" composite |
| 027 | **Reception desk with female staff member, "PLEASE MIND YOUR STEP" decal** | This is the actual physical clinic — re-use as anchor environment |
| 029–034 | Continuing reception/staff variants | Front-of-house realism |
| 035, 041–042 | Theatre scrubs, surgical light, monitor in frame | Surgical authority shots |
| 044, 047, 050, 053 | Mask + face shield variants | Procedural credibility |

These are the truth set. Every generated image is judged against them.

---

## 2. Visual characteristics extracted

Distilled from inspecting every Kevin Dolan source frame.

### Colour & light
- **Colour temperature:** ~5200–5600K. Warm-neutral. Not the cool blue of stock medical or the warm orange of "wellness".
- **Light source:** Predominantly large windows with horizontal white venetian blinds. Strong but diffused daylight ripping across the back wall in soft horizontal bars.
- **Highlights:** White blinds clip near pure white. Foreground retains shadow detail.
- **Backlight:** Always present — the window is almost always behind or 3/4 behind the subject.
- **Shadow density:** Mid. Not Hollywood contrasty, not flat documentary. Real shadow on the side of the face.

### Skin & subject
- **Skin texture:** Untouched. Pores, lines, day-of-shoot fatigue all visible.
- **Wardrobe:** Crisp white business shirt; charcoal trousers; black belt; thin metal-frame glasses; OR full surgical scrubs. No styled "telehealth doctor" look.
- **Expression:** Engaged but not theatrical. Slight smile, talking, mid-sentence, hands moving.
- **Posture:** Working posture. Leaning into desk, holding model, signing folder. Never centred-and-composed.

### Environment
- **Clinic walls:** Plain off-white, slight cream cast.
- **Floor:** Beige/grey ceramic tile, scuffed.
- **Furniture:** Real working office — black mesh chair, paper sorter shelves, small desktop printer, keyboard, phone, anatomical models, brochure holders.
- **Reception (027):** Mint-green/sage panelled reception desk with white orchid, brand brochures stood up in a holder, vinyl floor decal — a real Australian small-clinic interior, not a SaaS render.

### Lens & framing
- **Focal length feel:** ~35mm (room scenes), ~50mm (desk shots), ~85mm (portraits). Modest compression.
- **Depth of field:** Moderate. Subject sharp; background readable but not pin-sharp. Not the f/1.4 dreamy look of stock.
- **Aspect:** Mix of portrait and landscape. Composed off-centre, with the window/blinds taking ~⅓ to ½ of frame.
- **Crop style:** Generous head/feet room. Editorial, not square Instagram.

### Emotional tone
- Professional, calm, lived-in, slightly weary, not selling.
- Reads as "real working clinician on a Tuesday" — not "lifestyle ad shoot".

---

## 3. What the current AI library gets wrong

Inspected: `assets/images/pathway/01-assessment.jpg`, `03-ongoing.jpg`, `assets/images/intake/intake-welcome.jpg`, `intake-pathway.jpg` (and the rest of intake-*).

| Wrong | Right |
|-------|-------|
| Identical lean 30-something model man, navy/grey polo, manicured stubble | Real adults, mid-40s+, mixed body types, including overweight and obese |
| Sterilised beige minimalist kitchens with curated houseplants | Ordinary Australian homes — Laminex, dated cabinetry, real clutter |
| Soft Adobe Firefly skin smoothing + visible sparkle watermark | Untouched skin, pores, real texture |
| Cool grey colour cast | Warm-neutral, daylit |
| Wellness/SaaS "calm" energy | Quiet medical seriousness |
| Centered hero composition | Off-centre, working posture |
| Always solo, always smiling slightly | Often mid-task, neutral expression, not posed |

`pathway/02-specialist.jpg` is fine — it is in fact Kevin Dolan source 011 and stays as-is.

`pathway/01-assessment.jpg`, `pathway/03-ongoing.jpg`, and the entire `intake/` set must be regenerated.

---

## 4. Higgsfield prompt framework

Use **higgsfield-generate** with **GPT Image 2** as the engine for editorial photography (it handles documentary realism better than the cinematic models, which over-stylise). For category C (telehealth) scenes that need a laptop UI, GPT Image 2 also handles screen content cleanly.

**Paste the reference anchor verbatim. Do not paraphrase.** Empirically, GPT
Image 2 locks onto the Kevin Dolan world strongly when the anchor paragraph
appears word-for-word at the head of the prompt; paraphrasing dilutes the
effect and the output drifts back toward generic SaaS-stock.

Every prompt is constructed by stitching the same six clauses in this order:

1. **Reference anchor** (always present, verbatim).
2. **Subject** (body type, age, ethnicity, wardrobe, mood — no model tropes).
3. **Action** (what they are *doing* — not posing).
4. **Environment** (realistic Australian home or clinic).
5. **Photographic specification** (lens, light, palette, texture).
6. **Negative clauses** (what to suppress).

### Reference anchor (paste verbatim into every prompt)

> Match the photographic world of Dr Kevin Dolan's real Australian clinic
> photographs: warm-neutral colour temperature ~5400K, large white horizontal
> venetian blinds spilling soft daylight across the back of the frame,
> off-white walls, lived-in Australian clinical or domestic interior,
> untouched skin texture with visible pores and lines, ~35–85mm lens feel,
> moderate depth of field with the background readable but not blurred,
> editorial off-centre composition, mid-task working posture, calm and
> medically serious — not a wellness or SaaS stock ad.

### Subject grammar (pick one phrase, never "model")

- "an overweight Australian woman in her late 40s, ordinary work clothes, no makeup retouching"
- "an obese Australian man in his mid-50s, polo shirt, glasses, real skin"
- "an older Anglo-Australian woman in her 60s, cardigan, reading glasses"
- "a Vietnamese-Australian man in his early 50s, button-down shirt, slight stubble"
- "a Lebanese-Australian woman in her late 30s, headscarf, cotton tunic"
- "an Aboriginal Australian man in his 40s, plain t-shirt"
- "a Pasifika woman in her 50s, plain cotton dress"
- "a younger adult Australian woman in her late 20s, plus size, simple top"

Always include: real skin texture, no makeup smoothing, dignified, calm, not smiling like a stock model.

### Negative clauses (paste verbatim)

> No before/after imagery. No gym setting. No fitness influencer. No pharmaceutical
> advertising gloss. No fake influencer look. No styled wellness aesthetic. No
> beige minimalist designer kitchen. No navy polo on a lean stubbled 30-something
> man. No Firefly-style sparkle watermark. No skin smoothing. No teeth-bared
> stock smile. No body-shaming framing. No weight-related visual jokes. No cool
> grey colour cast. No warm-orange wellness colour cast.

### Photographic specification (paste verbatim)

> Shot on a 35mm DSLR with natural window light, warm-neutral 5400K, mild
> contrast, real shadow on the side of the face, slight grain. Editorial
> documentary feel. Background readable. Composition off-centre. Subject
> three-quarter or candid. No HDR, no cinematic LUT, no glamour retouching.

---

## 5. Image categories — registry

All filenames live under `ventures/digital-clinic/brands/weight-loss/assets/images/`.

### Category A — Assessment moments (`assets/images/pathway/`, `assets/images/intake/`)

| Filename | Replaces | Subject |
|----------|----------|---------|
| `pathway/01-assessment.jpg` | current AI stock | Overweight Australian woman, late 40s, kitchen table, laptop, completing a confidential assessment |
| `intake/intake-welcome.jpg` | current AI stock | Same scene tone, slightly different angle, can be a different patient |
| `intake/intake-questions.jpg` | current AI stock | Overweight Australian man, mid 50s, sofa, phone in hand, reading questions |

### Category B — Waiting for pathway

| Filename | Replaces | Subject |
|----------|----------|---------|
| `intake/intake-review.jpg` | current AI stock | Older woman, late 60s, kitchen, looking at confirmation screen on tablet |
| `intake/intake-pathway.jpg` | current AI stock | Patient sitting back from desk with laptop closed, calm relief, not smiling |
| `pathway/03-ongoing.jpg` | current AI stock | Plus-size younger adult woman, late 20s, home, phone in hand, calm |

### Category C — Doctor consult / telehealth

| Filename | Replaces | Subject |
|----------|----------|---------|
| `intake/intake-clinical.jpg` | current AI stock | Overweight man on telehealth call on laptop, Australian doctor visible on screen |
| `intake/intake-medical.jpg` | current AI stock | Patient with notes/medication list at desk before consult |
| (new) `pathway/03-ongoing-consult.jpg` | n/a — A/B variant | Patient mid-telehealth, calm, taking notes |

### Category D — Everyday Australian realism

| Filename | Replaces | Subject |
|----------|----------|---------|
| (new) `lifestyle/walking-suburb.jpg` | — | Middle-aged overweight couple walking near suburban park, ordinary clothes, not exercise gear |
| (new) `lifestyle/cooking-home.jpg` | — | Older woman cooking at home, normal kitchen, real-size portion |
| (new) `lifestyle/grocery.jpg` | — | Patient pushing trolley in Coles/Woolworths-style supermarket aisle |
| (new) `lifestyle/family-table.jpg` | — | Mixed-age family at dinner table, ordinary meal |

### Category E — Kevin Dolan visual bridge (clinical close-ups)

| Filename | Replaces | Subject |
|----------|----------|---------|
| (new) `clinic/desk-paperwork.jpg` | — | Top-down or 3/4 of clinical paperwork on Kevin's actual-style desk: blood pressure cuff, file, pen |
| (new) `clinic/laptop-assessment-ui.jpg` | — | Laptop screen with assessment interface, on the same desk style as Kevin's office |
| (new) `clinic/hands-writing.jpg` | — | Close-up of clinician's hands writing notes in folder, white-shirt sleeve, watch |
| (new) `clinic/consult-room.jpg` | — | Empty consult room with white blinds, exam table, off-cycle, no people |

These bridge images exist specifically to prevent visual whiplash between
Kevin's real photos and patient-journey scenes. They can sit between the two.

---

## 6. Worked prompt examples

### A1 — `pathway/01-assessment.jpg`

```
Match the photographic world of Dr Kevin Dolan's real Australian clinic
photographs: warm-neutral colour temperature ~5400K, large white horizontal
venetian blinds spilling soft daylight across the back of the frame,
off-white walls, lived-in Australian clinical or domestic interior,
untouched skin texture with visible pores and lines, ~35–85mm lens feel,
moderate depth of field with the background readable but not blurred,
editorial off-centre composition, mid-task working posture, calm and
medically serious — not a wellness or SaaS stock ad.

Subject: an overweight Australian woman in her late 40s, ordinary work
clothes (a soft knit jumper, no makeup retouching, hair down, real skin
texture, dignified and private). She is sitting at a kitchen table in an
ordinary Australian home — Laminex bench visible behind her, a half-empty
mug of tea, a stack of household paperwork off to one side. She is looking
at a laptop screen completing a short confidential health assessment, not
smiling, calm, focused, slightly relieved that she has begun.

Shot on a 35mm DSLR with natural window light, warm-neutral 5400K, mild
contrast, real shadow on the side of the face, slight grain. Editorial
documentary feel. Background readable. Composition off-centre, subject in
the right two-thirds of the frame, daylight from a window behind her left
shoulder.

No before/after imagery. No gym setting. No fitness influencer. No
pharmaceutical advertising gloss. No fake influencer look. No styled
wellness aesthetic. No beige minimalist designer kitchen. No navy polo on
a lean stubbled 30-something man. No Firefly-style sparkle watermark. No
skin smoothing. No teeth-bared stock smile. No body-shaming framing.

Aspect ratio: 4:3 landscape. Final delivery: 1600x1200 (Higgsfield --aspect_ratio 4:3 --resolution 2k renders larger; downsample on save).
```

### B1 — `pathway/03-ongoing.jpg`

```
[REFERENCE ANCHOR — verbatim from Section 4]

Subject: a plus-size Australian woman in her late 20s, ordinary t-shirt,
jeans, hair tied back, real skin texture, no makeup retouching. She is
sitting at home — a small two-seater sofa visible, a folded throw, a glass
of water on a side table. She is reading a confirmation message on her
phone after submitting a clinical assessment, the expression is calm and
relieved, not performative.

[PHOTOGRAPHIC SPEC — verbatim from Section 4]

[NEGATIVE CLAUSES — verbatim from Section 4]

Aspect ratio: 4:3 landscape. Final delivery: 1600x1200 (Higgsfield --aspect_ratio 4:3 --resolution 2k renders larger; downsample on save).
```

### C1 — `intake/intake-clinical.jpg`

```
[REFERENCE ANCHOR — verbatim]

Subject: an overweight Australian man in his mid-50s, plain navy polo (not
designer, just a polo), reading glasses pushed up on his forehead. He is
sitting at a home dining table with a laptop open. On the laptop screen, a
telehealth video-call interface is visible with an Australian female GP on
the call. He is taking notes on a paper notepad next to the laptop. The
mood is attentive, safe, structured.

[PHOTOGRAPHIC SPEC — verbatim]

[NEGATIVE CLAUSES — verbatim]

Aspect ratio: 4:3 landscape. Final delivery: 1600x1200 (Higgsfield --aspect_ratio 4:3 --resolution 2k renders larger; downsample on save).
```

### E1 — `clinic/desk-paperwork.jpg`

```
[REFERENCE ANCHOR — verbatim]

Subject: NO PERSON. Top-down 3/4 view of an Australian small-clinic
working desk: open A4 patient folder with a pre-printed clinical
assessment form, a stainless pen, a black blood pressure cuff coiled at
the edge, a small anatomical model partially visible at the back of the
frame, a laminated clinic brochure, a half-drunk glass of water. Lighting
from a horizontal-blind window behind the frame casting soft daylight bars
across the desk. Tactile, real, not a flat-lay stock shot.

[PHOTOGRAPHIC SPEC — verbatim]

[NEGATIVE CLAUSES — verbatim]

Aspect ratio: 4:3 landscape. Final delivery: 1600x1200 (Higgsfield --aspect_ratio 4:3 --resolution 2k renders larger; downsample on save).
```

---

## 7. Generation workflow

For each image to generate:

1. Pick the row from Section 5 (filename + brief subject).
2. Build the prompt by stitching reference anchor → subject → action → environment → photographic spec → negatives.
3. Run via Higgsfield (`/higgsfield-generate` skill, GPT Image 2 default).
4. Inspect against the Kevin Dolan reference set side-by-side.
5. Reject if the image:
   - has the Adobe Firefly sparkle watermark
   - shows a lean influencer-looking model
   - has the cool grey or warm-orange cast
   - has the manicured beige minimalist kitchen
   - shows centred hero stock composition
6. Save the accepted variant to its target path. Downsample to the spec
   dimensions (1600x1200 for 4:3, 1600x900 for 16:9) and save as JPEG q88 —
   keeps file sizes ~200–340 KB, in line with the existing assets.
7. Record the final prompt and the generation seed/job ID in `docs/visual-library-generations.md` so we can reproduce.

---

## 8. First batch — priority order

These are the images the homepage and quiz visibly use right now and that
clash hardest with the Kevin Dolan photos. Replace these first; everything
else can be queued.

1. `pathway/01-assessment.jpg` — homepage, step 1
2. `pathway/03-ongoing.jpg` — homepage, step 3
3. `intake/intake-welcome.jpg` — quiz, first screen
4. `intake/intake-pathway.jpg` — quiz, late screen
5. `intake/intake-questions.jpg` — quiz, mid screen

`pathway/02-specialist.jpg` and the entire `clinician/` folder are real
Kevin Dolan photographs — leave untouched.

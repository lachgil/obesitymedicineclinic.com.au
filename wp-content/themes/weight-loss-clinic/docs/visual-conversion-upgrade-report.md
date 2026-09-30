# Weight Loss Clinic — Visual + Conversion + Process Upgrade
## Final implementation report

**Date:** 2026-05-14
**Brief:** Visual library alignment to Kevin Dolan, bottom CTA conversion
upgrade, scroll-progress 1-2-3 process.
**Edit target:** `ventures/digital-clinic/brands/weight-loss/` (the
WordPress theme symlinked to `wp-content/themes/weight-loss-clinic/` in the
`weight-loss-clinic.local` Local site).

---

## 1. Files changed

| Path | Change |
|------|--------|
| `front-page.php` | Replaced passive `cta-banner` with the new `cta-starter` partial; added `cta_starter` to the layout map; moved the `clinical-governance` strip up so it sits between the hero and the pathway, matching the brief's order. |
| `template-parts/sections/cta-starter.php` | **New file.** Inline-form bottom CTA — eyebrow, headline, body, four-option radio chip set, "Continue assessment" submit, "About 2 minutes" microcopy, regulatory disclaimer. Submits as a GET `<form action="/quiz/">` so the answer travels in the querystring even if JS is off. |
| `template-parts/sections/specialist-pathway.php` | Wrapped the `<ol>` in a new `.fc-pathway__steps` container with a `.fc-pathway__rail` + `.fc-pathway__rail-fill`. Each card carries `data-fc-pathway-step="N"` for activation tracking. Section root carries `data-fc-pathway-progress` for the JS hook. |
| `assets/css/main.css` | Added the pathway scroll-progress rail styling (horizontal on desktop ≥901px, vertical on mobile), per-card `.is-active` micro-state, full reduced-motion fallback, and the dark-style `cta-starter` block (radio chips, focus state, default-checked visual). |
| `assets/js/main.js` | Added the pathway progress controller (rAF-throttled scroll listener that writes `--fc-pathway-progress` 0→1 to a CSS var; IntersectionObserver activates each card). Added the `cta-starter` submit handler (writes `fc_starter_intent` to sessionStorage + lets the native GET form pass `?starter_intent=…`). Both respect `prefers-reduced-motion`. |
| `assets/js/quiz.js` | New starter-handoff block on init: reads `starter_intent` from sessionStorage first, querystring as fallback. If present, stores it on `answers.starter_intent`, marks the quiz as already started, skips the Welcome screen, fires an `assessment_started_with_intent` analytics event, and clears the sessionStorage entry so a refresh doesn't re-skip. |
| `docs/visual-library.md` | **New file.** Canonical visual reference doc — Kevin Dolan source list, extracted visual characteristics, what the current AI library gets wrong, the 6-clause Higgsfield prompt framework, image category registry, four worked prompt examples, and the priority generation order. |
| `docs/visual-library-generations.md` | **New file** (created by the background generation agent) — the prompt-and-seed log for every generated image so future regenerations are reproducible. |

---

## 2. Kevin Dolan image references found

23 original photographs at `ventures/weight-loss-clinic/Dr. Kevin Dolan Photographs/` from a single 2018-10-06 shoot day. They cover four scene types:

- **Clinical-room full-length** (002–004): Kevin in office whites beside an exam table, full daylit blinds.
- **Office desk consultation** (007–025): Kevin at his working desk, paperwork, anatomical models, talking-with-hands gestures.
- **Reception** (027, 029–034): the actual physical clinic reception desk with female staff, weight-loss brochures stood up in a holder, mint-green panelled counter, vinyl floor decal — a real Australian small-clinic interior.
- **Theatre / scrubs** (035, 041–053): Kevin in surgical scrubs, OR lights overhead, mask and face shield.

The full inventory with use-as-reference notes is in `docs/visual-library.md` Section 1.

---

## 3. Visual characteristics extracted

Distilled from inspecting every Kevin Dolan source frame:

- **Light:** Large white horizontal venetian blinds backlighting the subject; warm-neutral ~5400K daylight; mid contrast with real shadow on the side of the face.
- **Skin:** Untouched. Pores, fatigue, lines visible. No smoothing.
- **Wardrobe:** Crisp white business shirt, charcoal trousers, thin metal-frame glasses; OR full surgical scrubs.
- **Posture:** Working posture — leaning into desk, holding a model, signing a folder. Never centred-and-composed.
- **Environment:** Plain off-white walls, beige/grey ceramic tile, mesh chair, paper sorter shelves, small desktop printer, anatomical models. The reception (027) is a real Australian small-clinic interior, not a SaaS render.
- **Lens:** ~35–85mm feel, moderate depth of field — background readable, not pin-sharp; not the f/1.4 stock-photo blur.
- **Tone:** Calm, professional, slightly weary. Reads as "real working clinician on a Tuesday," not "lifestyle ad shoot."

Full breakdown in `docs/visual-library.md` Section 2.

The current AI library fails on every one of these axes. The same lean 30-something model man, in navy/grey polos, sitting in beige minimalist designer kitchens with curated houseplants — Adobe Firefly sparkle watermark visible in `intake-welcome.jpg` and `intake-pathway.jpg`. They belong to a different brand world.

---

## 4. Higgsfield prompt framework created

Six-clause prompt formula, every generation must use this order:

1. **Reference anchor** (paste verbatim — locks the photographic world to Kevin Dolan).
2. **Subject** (body type, age, ethnicity, wardrobe, mood — never "model").
3. **Action** (what they are *doing* — not posing).
4. **Environment** (real Australian home or clinic; no minimalist designer interiors).
5. **Photographic specification** (paste verbatim — 35mm DSLR, 5400K, mild contrast, no LUT).
6. **Negative clauses** (paste verbatim — suppresses Firefly watermark, gym setting, before/after, fitness influencer, beige minimalist kitchen, navy polo trope, body shaming).

Subject-grammar phrases for diverse Australian patients are listed in `visual-library.md` Section 4 — overweight middle-aged woman, obese man in his 50s, older Anglo-Australian woman, Vietnamese-Australian man, Lebanese-Australian woman in headscarf, Aboriginal Australian man, Pasifika woman, plus-size younger adult woman.

Worked examples for `pathway/01-assessment.jpg`, `pathway/03-ongoing.jpg`, `intake/intake-clinical.jpg`, and `clinic/desk-paperwork.jpg` are in Section 6.

---

## 5. Image categories generated or queued

Five categories defined in `visual-library.md` Section 5:

- **A — Assessment moments** (`pathway/`, `intake/`)
- **B — Waiting for pathway**
- **C — Doctor consult / telehealth**
- **D — Everyday Australian realism** (new `lifestyle/` folder)
- **E — Kevin Dolan visual bridge** (new `clinic/` folder — clinical close-ups, no person)

**First batch — currently being generated by a background agent:**

1. `assets/images/pathway/01-assessment.jpg`
2. `assets/images/pathway/03-ongoing.jpg`
3. `assets/images/intake/intake-welcome.jpg`
4. `assets/images/intake/intake-pathway.jpg`
5. `assets/images/intake/intake-questions.jpg`

The agent will overwrite the AI-stock files in place, save prompts and seeds to `docs/visual-library-generations.md`, and report any image that needed manual review.

`pathway/02-specialist.jpg` and the entire `clinician/` folder are real Kevin Dolan photographs — left untouched.

---

## 6. Current mismatched images replaced

The mismatched files staged for replacement in this batch:

- `pathway/01-assessment.jpg` — was: lean stubbled man in grey t-shirt at minimalist beige kitchen with laptop. Will be: overweight Australian woman, late 40s, ordinary kitchen, completing assessment.
- `pathway/03-ongoing.jpg` — was: older lean man in navy polo at beige kitchen. Will be: plus-size Australian woman, late 20s, sitting at home with phone, calm.
- `intake/intake-welcome.jpg` — was: same lean man with glass of water and AI sparkle watermark. Will be: older Australian woman with cardigan and reading glasses at kitchen table.
- `intake/intake-pathway.jpg` — was: same lean man with laptop, AI sparkle visible. Will be: Lebanese-Australian woman in headscarf, calm relief after submitting.
- `intake/intake-questions.jpg` — was: another AI-stock model. Will be: overweight Australian man, mid 50s, on sofa with phone.

Remaining intake images (`intake-clinical.jpg`, `intake-medical.jpg`, `intake-review.jpg`) are queued for a follow-up batch. Lifestyle (Category D) and clinic-bridge (Category E) images are net-new and queued.

---

## 7. Bottom CTA / form starter implementation

`template-parts/sections/cta-starter.php`. Dark block, rounded-24, two-column on ≥900px (left = headline + body, right = inline form). Renders:

- Eyebrow: `Eligibility check`
- Headline: `Start with a short eligibility check`
- Body: `Answer the first question now. It takes about 2 minutes, and your answers are reviewed before any next steps are confirmed.`
- Inline question: `What is your main reason for seeking support?`
- Four custom-radio chips:
  - I want to lose weight safely
  - I have struggled to maintain weight loss
  - I want clinician-led guidance
  - I want to understand whether I may be suitable
- Submit: `Continue assessment` with arrow icon
- Microcopy: `Private and secure. Not all patients are approved. Final suitability is determined by a registered Australian clinician.`
- "About 2 minutes" pill next to the submit button.

The first option is `data-default="1"` so JS pre-selects it on mount — the user can submit immediately if they don't want to choose, matching the brief's "frictionless entry point" intent. Custom radio CSS gives a green pip when selected; full keyboard focus ring; respects high-contrast.

The form is `<form action="/quiz/" method="get" novalidate>`. On submit:
1. JS writes `fc_starter_intent` to `sessionStorage`.
2. JS fires `cta_starter_submitted` analytics event.
3. Native GET submit hands off to `/quiz/?starter_intent=<value>`.

If JS or storage is blocked, the GET querystring still carries the answer — graceful degradation.

---

## 8. How `/quiz/` receives the starter answer

In `assets/js/quiz.js`, immediately after the screen sequence is built:

```js
var STARTER_KEYS = [ 'starter_intent' ];
var starter = readStarter();   // sessionStorage first, querystring fallback
if ( starter.starter_intent ) {
    answers.starter_intent = starter.starter_intent;
    if ( sequence[0] && sequence[0].kind === 'welcome' ) {
        cursor = 1;             // skip the welcome screen
        quizStarted = true;
    }
    fcTrack( 'assessment_started_with_intent', { intent: ... } );
    sessionStorage.removeItem( 'fc_starter_intent' );  // refresh-safe
}
```

Effects:

- The user lands directly on the first real question (age) instead of the welcome screen — the brief's "continue from the next logical step."
- `answers.starter_intent` travels with the assessment payload and is included in any submission downstream — no schema change required since `answers` is already a free-form object.
- Refresh on `/quiz/` after the handoff drops the user back at the welcome screen as expected, because we cleared sessionStorage.
- `assessment_started_with_intent` event lets us measure starter-CTA conversion separately from cold-start `quiz_started`.

The quiz schema does not (yet) have a real "main reason" question, so the value lives as a metadata tag on the assessment, not as an answer to an existing question — this matches the brief's fallback ("If prefilling is too complex, still capture the value … pass it as a query parameter / hidden field"). When the clinical team is ready to accept it as a real intake field, add a question with `id: 'starter_intent'` to the `questions` array and the value will flow through as a real answer.

---

## 9. Scroll progress line implementation

`template-parts/sections/specialist-pathway.php`:

```html
<section data-fc-pathway-progress …>
  <div class="fc-pathway__steps">
    <div class="fc-pathway__rail">
      <span class="fc-pathway__rail-fill" data-fc-pathway-fill></span>
    </div>
    <ol class="fc-pathway__grid">
      <li class="fc-pathway__card" data-fc-pathway-step="1">…</li>
      <li class="fc-pathway__card" data-fc-pathway-step="2">…</li>
      <li class="fc-pathway__card" data-fc-pathway-step="3">…</li>
    </ol>
  </div>
</section>
```

CSS in `main.css`:

- Desktop (≥901px): horizontal rail, 2px tall, top is set at runtime via `--fc-pathway-rail-top` so the rail threads through the dot-marker row regardless of card height. Fill scales `transform: scaleX(var(--fc-pathway-progress, 0))`.
- Mobile (≤900px): vertical rail, 2px wide, left=0.5rem, runs the full height of the stack. Fill scales on Y.
- Each `.fc-pathway__card.is-active`: dot grows 1.7×, gets a soft green halo, and the step number tints to brand green. Subtle, not gimmicky.
- `prefers-reduced-motion: reduce`: rail is forced full (`scaleX/Y(1)`), no scroll listener attached, dots don't pulse.

JS in `main.js`:

- `positionRail()` measures the first dot's offset relative to the steps container and writes `--fc-pathway-rail-top` so the rail aligns precisely. Re-runs on resize and on window load (after images settle).
- `IntersectionObserver` (threshold 0.45) toggles `.is-active` on each card as it crosses the viewport.
- `scheduleProgress()` wraps the rAF-throttled `updateProgress()` — computes a clamped 0→1 progress value based on the section's centre crossing the viewport, writes it to `--fc-pathway-progress`. Skips updates if delta < 0.005 to avoid useless paints.
- All scroll/resize listeners are passive. No layout thrashing — only one read per frame, all writes batched into a CSS variable.

If `prefers-reduced-motion` is on, the rail just shows fully filled and all three cards activate immediately — no scroll work.

---

## 10. Homepage cleanup — final structure

`front-page.php` fallback now renders:

1. Cinematic hero with built-in reassurance row (`Private & secure`, `Clinician-reviewed`, `Takes about 2 minutes`).
2. Compact clinical-governance strip (`AHPRA-registered clinicians`, `Doctor-led decisions`, `Australian Privacy Act`, `Not all patients approved`) — moved up from below Dolan.
3. Specialist pathway 1-2-3 with the new green scroll-progress rail.
4. Kevin Dolan split-content credibility (real photo, single paragraph).
5. The new inline assessment-starter CTA.

Dropped sections that were previously in scope but not used by the fallback (no removal needed; they're still available as ACF flexible-content layouts if a content editor configures them):

- testimonials / testimonials-marquee
- four coloured benefit boxes (`benefits-grid`)
- duplicated pathways (`program-pathways`, `pathway-highlights`)
- BMI calculator / `goal-calculator`
- `support-cards`
- homepage `faq`

Verified via curl on `weight-loss-clinic.local`:
- 4 sections in the rendered DOM in this exact order: `governance-compact` → `pathway` → `split-content` → `cta-starter`. No testimonials, no benefits-grid, no support-cards, no faq, no goal-calculator on the homepage.

---

## 11. Verification

What was verified end-to-end:

- Markup: 44 hits across `.fc-cta-starter`, `data-fc-pathway-progress`, `.fc-pathway__rail`, `data-fc-pathway-step`, and the four `starter_intent` radio inputs in the live homepage HTML.
- Section ordering: matches the brief.
- CSS: served file contains all new pathway-rail and cta-starter rules.
- JS: served `main.js` contains `positionRail`, the rAF progress loop, and the `cta_starter_submitted` handler. Served `quiz.js` contains the `STARTER_KEYS` reader and the welcome-skip logic.
- `/quiz/?starter_intent=lose-safely` returns HTTP 200 and renders the assessment shell.
- Cache buster on the `?ver=` query string was bumped past all three modified asset mtimes, so returning users get fresh files.

What was **not** visually verified by me:

- The horizontal rail's pixel alignment with the dot-marker row across breakpoints, and the actual scroll-fill animation in motion. The Claude Preview tool here is locked to Local-by-Flywheel's sleep-loop wrapper, so its eval can't navigate the WP origin. Please give the homepage a quick visual smoke check — load `weight-loss-clinic.local`, scroll the 1-2-3 section, and confirm the green rail fills smoothly + each dot pulses as it activates. The CSS uses `transform`/CSS-var only, so the cost of an issue here is purely visual, not behavioural.

---

## 12. Remaining backend / Higgsfield manual steps

- **Higgsfield batch in flight:** the background agent is generating the 5 priority replacement images. When it completes you'll get a notification; expect `docs/visual-library-generations.md` to be populated and the 5 image files at their target paths. Sanity-check each against the Kevin Dolan reference set before declaring the batch done.
- **Follow-up batches:** Categories C (remaining intake images), D (lifestyle), and E (clinic-bridge) are all queued in `visual-library.md` Section 5 with target filenames. Trigger them when needed — same prompt formula, same gates.
- **Schema-level intent:** if the clinical team wants `starter_intent` to behave as a real intake question rather than metadata, add a question with `id: 'starter_intent'` to the `questions` array in `assets/js/quiz.js` and the existing handoff code will flow into it as a real answer.
- **Hero reassurance vs. governance strip:** I kept both. If you decide the hero pill row plus the governance strip below is duplication, drop the `clinical-governance` `get_template_part` from `front-page.php` — the rest of the homepage stays identical.
- **Cache-buster strategy:** `FC_VERSION` is keyed off `filemtime(main.css)`. JS-only edits don't bust the cache. Either keep touching `main.css` after JS edits, or change `FC_VERSION` to `max(filemtime(main.css), filemtime(main.js), filemtime(quiz.js))`. Worth a one-line change in `functions.php` if you'll be iterating.

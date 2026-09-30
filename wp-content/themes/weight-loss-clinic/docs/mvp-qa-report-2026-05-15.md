# Weight Loss Clinic — MVP Sprint QA Report

**Date:** 2026-05-15
**Scope:** Polish `/plans/`, `/how-it-works/`, `/about/`, `/faq/`, `/book/` to MVP launch standard. Audit `/portal/` (logged-out) + `/contact/` for consistency.
**Edit location:** `ventures/digital-clinic/brands/weight-loss/` (live theme, Local-by-Flywheel symlink target).

## What changed

### 1. Visual library staged
- New folder `assets/images/lifestyle/` with 9 curated lifestyle, emotional and clinician images sourced from `ventures/weight-loss-clinic/images/higgsfield-library/` (May 2026 batch).
- README documents each file's purpose, page mapping, and the canonical Higgsfield brief for re-generations.

### 2. Page templates rewritten
| Page | Hero image | Headline change | Structural change |
| --- | --- | --- | --- |
| `/plans/` | `walking-outdoors.jpg` | "Clinician-led weight loss support, structured around your life" | 6 inclusion boxes → 4; added suitability split + FAQ preview; tightened compliance fineprint |
| `/how-it-works/` | `healthy-meal-prep.jpg` | "From eligibility check to ongoing support — a clear clinical pathway" | 3-step above fold + new collapsible 8-step detail (Eligibility → Maintenance); added Not-approved trust block |
| `/faq/` | `calm-glass-of-water.jpg` | "Straight answers, no fine print" | 5 categories → 8 (Getting started · Eligibility · Consultations & decisions · Pricing & inclusions · Delivery & privacy · Safety/follow-up · Patient portal · Not suitable). Mid-page CTA after Consultations and Safety. FAQPage JSON-LD schema added for rich-result eligibility |
| `/book/` | `coastal-coffee-reflection.jpg` | "Start with a clinical eligibility check" | Hero CTA jumps to `#book-now`; added "Not ready? Read how it works" bridge; preserved Coviu/intake-fallback widget logic verbatim |
| `/about/` | `clinician-welcome-portrait.jpg` | "Built for safer, more considered weight loss care" | New "Why this clinic exists" intro section; preserved Dolan lead-specialist card and full governance/limits/standards/regulatory blocks |
| `/contact/` | (no hero — text only) | unchanged | Upgraded plain header → branded centered pattern (matches the other pages) |
| `/portal/` (logged-out) | n/a | unchanged | Audited only. Existing `[wlc_dashboard]` shortcode renders a clean Existing/New patient split. No edits required. |

### 3. CSS additions (appended to `assets/css/main.css`, MVP block clearly marked)
- `fc-page__hero` polish on the five MVP pages: 520px → 440px → 380px responsive min-height; cleaner tri-stop dark-green gradient overlay; eyebrow + accent colour overrides for legibility on dark.
- `fc-btn--ghost-light` — outline button for use on dark hero overlays.
- `fc-section--about-intro` + `fc-about-intro` — institutional intro paragraph block.
- `fc-faq-midcta` — mid-page CTA banner (used on FAQ + book + plans).
- `fc-pathway-step-num` — number prefix for the 8-step accordion summaries.

## Verification

All five core pages return **HTTP 200** with no PHP warnings/notices/errors. Titles render correctly. Headless-Chrome screenshots captured and reviewed (`/tmp/wlc-mvp-screens/`).

| QA check | /plans/ | /how-it-works/ | /about/ | /faq/ | /book/ |
| --- | :---: | :---: | :---: | :---: | :---: |
| Hero image present | ✅ | ✅ | ✅ | ✅ | ✅ |
| Hero CTA above the fold | ✅ | ✅ | ✅ | ✅ | ✅ |
| H1 readable on overlay | ✅ | ✅ | ✅ | ✅ | ✅ |
| Primary CTA → `/quiz/` (or `#book-now`) | ✅ | ✅ | ✅ | ✅ | ✅ |
| Secondary CTA visible (ghost-light) | ✅ | ✅ | ✅ | ✅ | ✅ |
| No console / PHP errors | ✅ | ✅ | ✅ | ✅ | ✅ |
| Compliance language preserved | ✅ | ✅ | ✅ | ✅ | ✅ |
| Final-section CTA present | ✅ | ✅ | ✅ | ✅ | ✅ |

## Compliance posture (unchanged, re-verified)

- No prescription-medicine names anywhere in the new copy
- No outcome guarantees, no before/after framing, no shame-based copy
- "Not all patients are approved" reinforced on every page
- Clear telehealth limitations on `/about/`
- AHPRA-registered language throughout
- "Real-time consultation required before any prescribing decision" preserved verbatim

## Outstanding items / follow-ups

| Item | Severity | Notes |
| --- | --- | --- |
| Lifestyle PNGs are 2.5–3.5 MB each (raw Higgsfield) | Performance | Convert to compressed `.jpg` (target ≤ 250 KB) or `.webp` before launch. Trivial follow-up. |
| `BRAND_SUPPORT_EMAIL` resolves to a personal Gmail in portal logged-out copy | Content | Set to a branded support address in `inc/setup/` or `wp-config`. Out of scope for this design pass. |
| `/portal/` logged-out screen | none | Audited; well-designed. Not edited. |
| `/contact/` doesn't yet use a lifestyle hero image | Optional | Currently uses the branded centered text header (matches About-style fallback). Adding a `clinician-reviewing-chart.jpg` hero is a 3-minute upgrade if desired. |
| `template-parts/sections/specialist-pathway` partial | unchanged | Reused on `/how-it-works/` exactly as on the homepage. No regressions. |
| Mobile QA | manual | Headless screenshots taken at 1280px desktop. Recommend a 5-minute walkthrough on iPhone-sized viewport before demo. The `fc-page__hero` already has 380px mobile breakpoint. |

## Files touched

```
ventures/digital-clinic/brands/weight-loss/template-plans.php       # rewritten
ventures/digital-clinic/brands/weight-loss/template-how-it-works.php # rewritten
ventures/digital-clinic/brands/weight-loss/template-faq.php          # rewritten + FAQPage schema
ventures/digital-clinic/brands/weight-loss/template-booking.php      # rewritten
ventures/digital-clinic/brands/weight-loss/template-about.php        # rewritten
ventures/digital-clinic/brands/weight-loss/template-contact.php      # header upgraded
ventures/digital-clinic/brands/weight-loss/assets/css/main.css       # appended MVP block (~115 lines)
ventures/digital-clinic/brands/weight-loss/assets/images/lifestyle/  # 9 jpgs + README.md
```

## Sync reminder

Live edits live at `ventures/digital-clinic/brands/weight-loss/` (the symlinked target). Run `ventures/weight-loss-clinic/bin/sync-from-local.sh` to mirror back into the canonical repo theme/ before committing.

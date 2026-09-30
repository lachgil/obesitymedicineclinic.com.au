<?php
/**
 * Brand Configuration — DEVELOPER DEFAULTS ONLY.
 *
 * These constants are the shipped baseline for this brand instance.
 * Everything here is editable in the WordPress admin under
 * Appearance → Customize → Theme Settings, and an admin-saved value
 * always wins over these defaults (see inc/helpers/theme-options.php).
 * Only edit this file to change what a fresh install looks like.
 *
 * @package WeightLossClinic
 */

defined( 'ABSPATH' ) || exit;

/*
|--------------------------------------------------------------------------
| Brand Identity
|--------------------------------------------------------------------------
*/
define( 'BRAND_NAME',    'Weight Loss Clinic' );
define( 'BRAND_SLUG',    'weight-loss-clinic' );
define( 'BRAND_TAGLINE', 'Specialist-led weight management, delivered with care' );

/*
|--------------------------------------------------------------------------
| Lead Specialist
|--------------------------------------------------------------------------
| Named specialist threaded across hero, about, and clinician-led pages.
*/
define( 'BRAND_SPECIALIST_NAME',   'Dr Kevin Dolan' );
define( 'BRAND_SPECIALIST_TITLE',  'Bariatric &amp; General Surgeon' );
define( 'BRAND_SPECIALIST_CRED',   'AHPRA-registered specialist' );

/*
|--------------------------------------------------------------------------
| Brand Colors (CSS custom properties — override defaults in main.css)
|--------------------------------------------------------------------------
| Leave empty string to keep the base template defaults.
| Set a hex value to override.
*/
define( 'BRAND_COLOR_PRIMARY',       '' );  // default: #1B7A5A
define( 'BRAND_COLOR_PRIMARY_DARK',  '' );  // default: #145C43
define( 'BRAND_COLOR_PRIMARY_LIGHT', '' );  // default: #2E936F
define( 'BRAND_COLOR_CREAM',         '' );  // default: #FAF8F5
define( 'BRAND_COLOR_SAND',          '' );  // default: #F3EDE4

/*
|--------------------------------------------------------------------------
| Default CTA (used across header, service pages, clinician pages, etc.)
|--------------------------------------------------------------------------
*/
define( 'BRAND_CTA_TEXT', 'Check Eligibility' );
define( 'BRAND_CTA_URL',  '/quiz/' );

/*
|--------------------------------------------------------------------------
| Clinical Pathway CTA (routes to structured intake after quiz)
|--------------------------------------------------------------------------
*/
define( 'BRAND_INTAKE_CTA_TEXT', 'Start Your Assessment' );
define( 'BRAND_INTAKE_URL',     '/patient-intake/' );
define( 'BRAND_DASHBOARD_URL',  '/patient-dashboard/' );

/*
|--------------------------------------------------------------------------
| Primary CTA endpoints (used across the 2026 site architecture)
|--------------------------------------------------------------------------
| Each endpoint is intentional — do not collapse them. See docs/cta-routing-map.md.
|
|   /quiz/             — Check Eligibility (pre-intake filter)
|   /book/             — Book Consultation (telehealth booking, Coviu-backed)
|   /portal/           — Patient Portal (logged-out access / logged-in bounce)
|   /start-treatment/  — Start Program (post-quiz conviction → checkout)
|   /plans/            — Plans & inclusions (service-structured, not product)
|   /how-it-works/     — Dedicated pathway explainer
|   /about/            — Clinical governance / about
|   /faq/              — Dedicated FAQ
|   /contact/          — General enquiries
*/
define( 'BRAND_BOOKING_URL',      '/book/' );
define( 'BRAND_BOOKING_CTA_TEXT', 'Book Consultation' );
define( 'BRAND_PORTAL_URL',       '/portal/' );
define( 'BRAND_PORTAL_CTA_TEXT',  'Patient Portal' );
define( 'BRAND_PLANS_URL',        '/plans/' );
define( 'BRAND_HOW_IT_WORKS_URL', '/how-it-works/' );
define( 'BRAND_ABOUT_URL',        '/about/' );
define( 'BRAND_FAQ_URL',          '/faq/' );
define( 'BRAND_CLINICIAN_URL',    '/clinician-led-care/' );

/*
|--------------------------------------------------------------------------
| Telehealth provider (Coviu) — integration-ready, not hard-wired
|--------------------------------------------------------------------------
| Leave credentials empty until provisioned. The booking page reads these
| values so the integration can be swapped without template changes.
|
|   BRAND_TELEHEALTH_PROVIDER  — 'coviu' | 'placeholder'
|   BRAND_COVIU_BOOKING_URL    — patient-facing booking URL or embed URL
|   BRAND_COVIU_ROOM_BASE      — practitioner room base (e.g. https://coviu.com/room/)
|   BRAND_COVIU_ACCOUNT_ID     — provisioned account identifier (optional)
*/
define( 'BRAND_TELEHEALTH_PROVIDER', 'placeholder' );
define( 'BRAND_COVIU_BOOKING_URL',   '' );
define( 'BRAND_COVIU_ROOM_BASE',     '' );
define( 'BRAND_COVIU_ACCOUNT_ID',    '' );

/*
|--------------------------------------------------------------------------
| Hero Section Defaults (front-page demo fallback)
|--------------------------------------------------------------------------
*/
define( 'BRAND_HERO_HEADLINE',   'A clinically reviewed weight management pathway, built around you' );
define( 'BRAND_HERO_ACCENT',     'built around you' );
define( 'BRAND_HERO_BODY',       'Complete a structured intake. A registered clinician reviews your health profile and, if clinically appropriate, recommends a personalised care plan. Not all patients are approved. Ongoing monitoring included.' );
define( 'BRAND_HERO_TRUST_LINE', 'Medically supervised weight management, delivered Australia-wide' );

/*
|--------------------------------------------------------------------------
| Footer / Navigation Labels
|--------------------------------------------------------------------------
*/
define( 'BRAND_NAV_TREATMENTS_LABEL', 'Programs' );

/*
|--------------------------------------------------------------------------
| Testimonials Section
|--------------------------------------------------------------------------
*/
define( 'BRAND_TESTIMONIALS_EYEBROW', 'Patient Experiences' );

/*
|--------------------------------------------------------------------------
| Funnel / Checkout URLs
|--------------------------------------------------------------------------
| These are the CTA destinations on the quiz result screen.
|
| STRIPE PAYMENT LINK SETUP:
|   Product:  Weight Loss Program (monthly subscription)
|   Price:    from BRAND_PRICE_FROM / month
|   Includes: clinician review, personalised treatment plan,
|             prescription + discreet delivery, ongoing support
|
| When Stripe is live, replace BRAND_CHECKOUT_URL with your
| Stripe Payment Link URL (e.g. https://buy.stripe.com/xxx).
| BRAND_REVIEW_URL can point to the same link or a separate
| intake form if the review pathway requires different handling.
*/
define( 'BRAND_CHECKOUT_URL', '/patient-intake/' );   // eligible → structured clinical intake form
define( 'BRAND_REVIEW_URL',  '/patient-intake/' );    // review → same intake (clinician review framing)
define( 'BRAND_CONTACT_URL', '/contact/' );            // unsuitable → support / contact page

/*
|--------------------------------------------------------------------------
| Stripe Payment Link
|--------------------------------------------------------------------------
| Replace this with your live Stripe Payment Link URL when ready.
| e.g. https://buy.stripe.com/xxxxxxx
| This URL is used on the pre-checkout page as the final CTA destination.
| Leave as '#stripe-not-configured' until Stripe is set up.
*/
define( 'BRAND_STRIPE_URL', '#stripe-not-configured' );

/*
|--------------------------------------------------------------------------
| Thank You / Onboarding
|--------------------------------------------------------------------------
*/
define( 'BRAND_THANKYOU_URL', '/thank-you/' );

/*
|--------------------------------------------------------------------------
| Pricing
|--------------------------------------------------------------------------
| Single source of truth for price anchors shown in the funnel.
| Update here when pricing changes — JS reads it via data-price-from.
*/
define( 'BRAND_PRICE_FROM', 299 );  // dollars per month, starting price

/*
|--------------------------------------------------------------------------
| Contact / Meta
|--------------------------------------------------------------------------
*/
define( 'BRAND_SUPPORT_EMAIL', 'hello@weight-loss-clinic.com' );
define( 'BRAND_SUPPORT_PHONE', '' );

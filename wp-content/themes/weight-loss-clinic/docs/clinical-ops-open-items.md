# Clinical Operations — Open Items

> Items requiring resolution before launch. Organised by priority.

---

## MUST RESOLVE BEFORE LAUNCH

### Legal Entity & Compliance
- [ ] Confirm legal entity (company, ABN) that operates the service
- [ ] Determine if the operator needs health service provider registration
- [ ] Engage lawyer for Terms of Service, Privacy Policy, clinical agreements
- [ ] Engage health compliance adviser for copy review
- [ ] Confirm professional indemnity insurance requirements

### Clinician Engagement
- [ ] Identify and engage prescribing clinician
- [ ] Verify AHPRA registration (no adverse conditions)
- [ ] Execute service agreement
- [ ] Agree on clinical protocol / SOP for patient assessment
- [ ] Agree on telehealth consultation process and platform
- [ ] Agree on turnaround time for assessment reviews
- [ ] Confirm remuneration model

### Pharmacy Partner
- [ ] Identify and engage dispensing pharmacy
- [ ] Confirm which medications will be available
- [ ] Confirm dispensing and delivery timeframes
- [ ] Agree on prescription transmission process
- [ ] Execute commercial agreement

### Patient Journey
- [ ] Define how patient data flows from payment to clinician
- [ ] Set up telehealth platform for consultations
- [ ] Create patient consent form for telehealth
- [ ] Define refund process for unsuitable patients
- [ ] Set up support email and response SLA

### Policy Pages
- [ ] Privacy Policy — drafted by lawyer, covering health information
- [ ] Terms of Service — drafted by lawyer, covering refunds, disclaimers
- [ ] Medical Disclaimer — reviewed by compliance adviser
- [ ] Consent to Telehealth — if required as separate document

---

## MUST RESOLVE BEFORE PAID TRAFFIC

### Copy & Advertising Compliance
- [ ] All site copy reviewed by health compliance adviser
- [ ] TGA advertising compliance verified
- [ ] AHPRA advertising guidelines compliance verified
- [ ] Testimonials verified (real patients, consent obtained, disclaimers in place)
- [ ] Remove or update demo testimonials with real content

### Stripe & Payments
- [ ] Stripe account live and verified
- [ ] Payment Link created and tested
- [ ] BRAND_STRIPE_URL updated in brand-config.php
- [ ] Full funnel tested end-to-end (quiz → checkout → thank-you)
- [ ] Refund process tested

### Email & Communications
- [ ] Email sending configured (wp_mail or SMTP plugin)
- [ ] Confirmation email trigger connected (webhook or automation)
- [ ] Email templates tested
- [ ] Support email monitored

### Operational Readiness
- [ ] Clinician available for initial patient reviews
- [ ] Support team briefed on FAQs and escalation paths
- [ ] Adverse event reporting process documented and communicated
- [ ] Complaints handling process documented

---

## POST-LAUNCH IMPROVEMENTS

### Analytics & Optimisation
- [ ] GA4 / GTM connected to tracking events
- [ ] Conversion funnel dashboard set up
- [ ] Monitor drop-off between quiz completion and pre-checkout
- [ ] Monitor drop-off between pre-checkout and Stripe payment
- [ ] A/B test CTA copy on pre-checkout page

### Clinical Operations
- [ ] Establish regular review cadence with clinician
- [ ] Build patient portal or case management system
- [ ] Automate patient-to-clinician data flow
- [ ] Set up automated follow-up/check-in communications

### Content & SEO
- [ ] Replace demo testimonials with real patient stories (with consent)
- [ ] Add real clinician photos and profiles (with consent)
- [ ] Create educational blog content (weight management, lifestyle, etc.)
- [ ] Build out service pages for specific program variants

---

## CONFIG VALUES THE OPERATOR MUST SET

These values in `brand-config.php` must be updated before launch:

| Config Key | Current Value | Action Required |
|---|---|---|
| `BRAND_STRIPE_URL` | `#stripe-not-configured` | Replace with live Stripe Payment Link URL |
| `BRAND_SUPPORT_EMAIL` | `hello@weight-loss-clinic.com` | Confirm or update to live support email |
| `BRAND_SUPPORT_PHONE` | (empty) | Add phone number if support line exists |
| `BRAND_PRICE_FROM` | `299` | Confirm pricing matches Stripe Product |
| `BRAND_CHECKOUT_URL` | `/start-treatment/` | No change needed (routes to pre-checkout) |
| `BRAND_REVIEW_URL` | `/start-treatment/` | No change needed |
| `BRAND_CONTACT_URL` | `/contact/` | No change needed |
| `BRAND_THANKYOU_URL` | `/thank-you/` | No change needed |

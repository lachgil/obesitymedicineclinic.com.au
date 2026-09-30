# Compliance Launch Pack

> This document is an implementation and review framework — NOT legal advice.
> All items must be reviewed by a qualified health compliance adviser and/or
> lawyer before launch, particularly those relating to the Therapeutic Goods
> Act, AHPRA advertising guidelines, and telehealth regulations.

---

## 1. Copy Principles Used in This Build

### What we DO say:
- "Clinician-guided weight management program"
- "Medically supervised" / "clinical assessment"
- "Treatment subject to clinical suitability"
- "A registered clinician reviews your information"
- "If clinically appropriate" / "if suitable"
- "Individual results vary"
- "Telehealth consultation may be required"
- "AHPRA-registered healthcare providers"
- "Australian-registered pharmacy"

### What we DO NOT say:
- No specific medication names (Ozempic, semaglutide, Wegovy, Mounjaro, tirzepatide) in consumer-facing copy
- No guaranteed outcomes ("lose X kg", "guaranteed weight loss")
- No before/after imagery or testimonials implying guaranteed results
- No language suggesting the quiz alone determines prescribing
- No language implying automatic prescription access
- No "doctor will prescribe" — always "if clinically appropriate"
- No specific percentage claims without clinical evidence citations

### Copy risk areas to monitor:
- Testimonials: must include disclaimer that individual results vary
- BMI display: informational only, not a diagnostic statement
- Pricing: must not imply payment guarantees treatment
- CTA language: "Continue to Next Step" rather than "Get Your Prescription"

---

## 2. Prohibited Wording Examples

These phrases must NOT appear anywhere on the site:

| Prohibited | Why | Acceptable Alternative |
|---|---|---|
| "Get Ozempic online" | TGA advertising restrictions on prescription medicines | "Clinician-guided weight management program" |
| "Guaranteed weight loss" | Misleading, breach of ACL | "Individual results vary" |
| "Lose 20kg in 12 weeks" | Outcome guarantee, misleading | "Your clinician sets realistic expectations" |
| "No doctor visit needed" | Misleading — telehealth IS a doctor visit | "100% online consultations" |
| "Instant prescription" | Misleading — clinical review required | "Treatment subject to clinician review" |
| "FDA approved" | Wrong jurisdiction for AU | "TGA-approved medications" (only if verified) |
| "Our doctors will prescribe" | Implies guaranteed prescribing | "If clinically appropriate, treatment may be recommended" |

---

## 3. Telehealth / Clinician Review Assumptions

The funnel currently assumes:
1. Quiz collects initial health information (NOT sufficient for prescribing)
2. Payment secures a clinician consultation/review slot
3. A registered clinician independently assesses suitability
4. A telehealth consultation may be required before prescribing
5. Prescribing decision is made independently by the clinician
6. If unsuitable, patient is refunded

### Open questions for legal/compliance review:
- [ ] Is the current flow (payment before clinical review) acceptable under Australian telehealth regulations?
- [ ] Does the refund commitment need to be in the Terms of Service?
- [ ] Is the quiz data collection sufficient for initial triage, or does it need to be more comprehensive?
- [ ] Are there state/territory-specific telehealth regulations that affect this model?
- [ ] Does the prescribing model require a specific type of practitioner (GP vs specialist)?

---

## 4. Regulatory Framework References

### Key legislation and guidelines:
- **Therapeutic Goods Act 1989** (TGA) — advertising of therapeutic goods
- **AHPRA Advertising Guidelines** — healthcare provider advertising obligations
- **Australian Consumer Law (ACL)** — misleading and deceptive conduct
- **Privacy Act 1988** — handling of personal health information
- **My Health Records Act 2012** — if applicable to digital health records
- **State/territory Health Records Acts** — jurisdiction-specific privacy
- **Telehealth Guidelines** — RACGP, AMA, and relevant college standards
- **Poisons Standard (SUSMP)** — scheduling of medicines

### Key regulatory bodies:
- TGA (Therapeutic Goods Administration)
- AHPRA (Australian Health Practitioner Regulation Agency)
- Medical Board of Australia
- ACCC (Australian Competition and Consumer Commission)
- OAIC (Office of the Australian Information Commissioner)

---

## 5. Open Legal/Compliance Items

### Must resolve BEFORE launch:
- [ ] Legal entity structure confirmed (who is the health service provider?)
- [ ] Doctor/clinician engagement agreement executed
- [ ] AHPRA registration of prescribing clinician(s) verified
- [ ] Professional indemnity insurance confirmed for telehealth
- [ ] Privacy Policy reviewed by lawyer (currently placeholder)
- [ ] Terms of Service reviewed by lawyer (currently placeholder)
- [ ] Medical Disclaimer reviewed by healthcare compliance adviser
- [ ] Refund/cancellation policy finalised and documented
- [ ] Complaints handling process documented
- [ ] Adverse event reporting process established

### Should resolve BEFORE paid traffic:
- [ ] All consumer-facing copy reviewed by health compliance adviser
- [ ] Testimonials (if real) — consent forms obtained, disclaimer verified
- [ ] TGA advertising compliance check completed
- [ ] AHPRA advertising guidelines compliance check completed
- [ ] Payment-before-consultation model reviewed for regulatory acceptability
- [ ] Data handling and storage practices documented
- [ ] Pharmacy dispensing partner confirmed and agreement in place

---

## 6. Policy Pages Required

| Page | Status | Notes |
|---|---|---|
| Privacy Policy | Placeholder created | Must be drafted by lawyer, cover health information handling |
| Terms of Service | Placeholder created | Must include refund policy, service limitations, clinical disclaimers |
| Medical Disclaimer | Placeholder created | Must clarify that content is not medical advice, treatment subject to clinical review |
| Consent to Telehealth | Not yet created | May be needed as part of onboarding flow |
| Complaints / Feedback | Not yet created | Required for health service compliance |

---

## 7. Data Handling Requirements

- [ ] Document what personal health information is collected at each stage
- [ ] Confirm data storage location (Australian servers preferred/required)
- [ ] Establish data retention and deletion policies
- [ ] Document who has access to patient health data
- [ ] Ensure clinician access to patient data is appropriately secured
- [ ] Consider whether a Health Privacy Impact Assessment is required

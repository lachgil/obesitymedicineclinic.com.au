# Doctor / Clinician Engagement Checklist

> This document outlines the operational requirements for engaging a prescribing
> clinician. It is NOT a legal document. All agreements must be drafted or reviewed
> by a lawyer experienced in Australian health law.

---

## 1. What the Clinic Needs from the Doctor Relationship

### Core operational requirements:
- A registered medical practitioner (AHPRA-registered) willing to:
  - Review patient assessments submitted through the online platform
  - Conduct telehealth consultations where clinically required
  - Make independent prescribing decisions based on clinical assessment
  - Provide ongoing clinical oversight of patient treatment plans
  - Be available for follow-up consultations and plan adjustments

### Clinical independence is non-negotiable:
- The clinician retains full clinical independence over prescribing decisions
- The platform/operator cannot direct, influence, or incentivise prescribing
- The clinician may decline to treat any patient at their sole discretion
- The clinician's clinical judgement overrides any commercial consideration

---

## 2. Documents Likely Required

### Legal agreements:
- [ ] **Independent Contractor Agreement** or **Service Agreement** — defines the commercial relationship, scope, remuneration, term, termination
- [ ] **Clinical Services Agreement** — defines clinical responsibilities, scope of practice, consultation standards, prescribing protocols
- [ ] **Professional Indemnity Insurance** — clinician must hold current PI insurance covering telehealth and the services provided
- [ ] **AHPRA Registration Verification** — current registration with no conditions that would prevent this work
- [ ] **Privacy and Confidentiality Agreement** — obligations under the Privacy Act and health records legislation
- [ ] **Data Access Agreement** — terms under which the clinician accesses patient health information on the platform

### Operational documents:
- [ ] **Clinical Protocol / Standard Operating Procedure** — what the clinician reviews, how they assess suitability, prescribing guidelines, escalation pathways
- [ ] **Patient Consent Framework** — what patients consent to, how consent is recorded, informed consent for telehealth
- [ ] **Adverse Event Reporting Protocol** — how adverse events are reported, documented, and escalated
- [ ] **Complaints Handling Procedure** — how patient complaints about clinical care are managed
- [ ] **Record Keeping Standards** — what clinical records are maintained, where, and for how long

---

## 3. Suggested Structure for Legal Review

Recommended approach for engaging a lawyer:

1. **Brief the lawyer on the operating model:**
   - Online weight management program
   - Patient completes online assessment and pays for consultation
   - Clinician reviews assessment and conducts telehealth consultation if needed
   - Clinician makes independent prescribing decision
   - Medication dispensed by registered pharmacy and shipped to patient
   - Ongoing clinical oversight provided

2. **Ask the lawyer to advise on:**
   - Appropriate legal structure for the clinician relationship (employee vs contractor)
   - Whether the platform operator needs its own health service registration
   - Compliance with AHPRA advertising guidelines for the current site copy
   - Whether the payment-before-consultation model requires specific disclosures
   - Privacy obligations specific to health information
   - Any state/territory-specific requirements for telehealth services
   - Professional indemnity requirements for the platform operator

3. **Ask the lawyer to draft:**
   - Clinician Service Agreement
   - Patient Terms of Service (covering clinical limitations and refund rights)
   - Privacy Policy (covering health information collection and handling)
   - Patient Consent Form for telehealth

---

## 4. What Cannot Be Represented in Marketing Until Confirmed

Do NOT claim in any marketing or on the website until confirmed and documented:

- [ ] Specific clinician names, qualifications, or photos (requires clinician consent)
- [ ] "AHPRA-registered" (requires verified registration — currently assumed but not confirmed)
- [ ] Specific medication names (requires TGA advertising compliance review)
- [ ] Specific clinical outcomes or statistics (requires evidence base)
- [ ] Partnership with specific pharmacies (requires agreement in place)
- [ ] Specific delivery timeframes (requires pharmacy/logistics confirmation)
- [ ] "Ongoing monitoring" or "regular check-ins" (requires clinical protocol defining frequency)

---

## 5. Questions to Resolve Before Paid Traffic

### Clinical model:
- [ ] Who is the prescribing clinician and what is their AHPRA registration number?
- [ ] What is their scope of practice and are there any conditions on their registration?
- [ ] What clinical protocol will they follow for assessing suitability?
- [ ] How will telehealth consultations be conducted (video/phone, platform, scheduling)?
- [ ] What is the turnaround time commitment for reviewing assessments?
- [ ] What happens if the clinician is unavailable (holiday, illness)?

### Pharmacy / dispensing:
- [ ] Which pharmacy will dispense prescriptions?
- [ ] Is there an agreement in place with the pharmacy?
- [ ] What medications will be available through the program?
- [ ] What are the actual dispensing and delivery timeframes?
- [ ] How are prescriptions transmitted to the pharmacy?

### Commercial:
- [ ] What is the clinician's remuneration model (per consultation, retainer, hybrid)?
- [ ] Who bears the cost of refunds for clinically unsuitable patients?
- [ ] What is the expected consultation volume at launch?
- [ ] Who is the contracting entity (ABN, company, individual)?
- [ ] Who is the "health service provider" in the legal sense — the platform or the clinician?

### Support and operations:
- [ ] Who handles patient enquiries (clinical vs administrative)?
- [ ] What is the escalation path for clinical concerns?
- [ ] How are adverse events reported and to whom?
- [ ] Who handles complaints (clinical complaints vs commercial complaints)?
- [ ] What records are kept and where are they stored?

---

## 6. Onboarding Workflow: Payment to Clinician Review

Current designed flow:

```
1. Patient completes quiz → eligible/review result
2. Patient views pre-checkout page (/start-treatment/)
3. Patient completes Stripe payment
4. Patient sees thank-you page (/thank-you/)
5. [GAP] Patient information must reach the clinician
6. Clinician reviews and assesses
7. Clinician conducts telehealth consultation if needed
8. Clinician makes prescribing decision
9. If approved → prescription sent to pharmacy → medication dispatched
10. If not approved → patient contacted → refund processed
```

### Open implementation gaps:
- [ ] Step 5: How does patient data get from the quiz/payment to the clinician? Options:
  - Manual: operator reviews Stripe payments and forwards to clinician
  - Semi-automated: Zapier/Make triggers on Stripe payment, creates a case/email
  - Automated: custom integration (not yet built)
- [ ] Steps 6-8: What platform does the clinician use for review and telehealth?
- [ ] Step 9: How is the prescription transmitted to the pharmacy?
- [ ] Step 10: Who initiates the refund and how is the patient notified?

---

## 7. Copy Approval Workflow

Before launch and before any copy changes post-launch:

1. Marketing/operator drafts copy
2. Health compliance adviser reviews for TGA/AHPRA compliance
3. Clinician reviews for clinical accuracy
4. Lawyer reviews for ACL/consumer law compliance (if material claims)
5. Final sign-off documented

Post-launch, any copy changes involving clinical claims, medication references, or outcome statements should go through this review process.

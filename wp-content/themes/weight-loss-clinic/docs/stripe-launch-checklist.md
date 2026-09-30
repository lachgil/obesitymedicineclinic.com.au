# Stripe Launch Checklist

## Pre-Launch Setup

### 1. Stripe Account
- [ ] Stripe account created and verified (Australian entity)
- [ ] Business details confirmed (ABN, business name, address)
- [ ] Bank account connected for payouts
- [ ] Tax settings configured (GST if applicable)

### 2. Stripe Payment Link
- [ ] Create a Product in Stripe Dashboard:
  - Name: "Weight Management Program — Clinician Consultation & Treatment Plan"
  - DO NOT name the product after a specific medication
  - Price: $299/month (or as per BRAND_PRICE_FROM in brand-config.php)
  - Billing: Recurring (monthly)
- [ ] Create a Payment Link for this product
- [ ] Configure Payment Link settings:
  - Collect customer email: YES
  - Collect customer name: YES
  - Collect billing address: YES (required for Australian compliance)
  - After payment redirect: set to `https://yourdomain.com/thank-you/`
  - Allow promotion codes: optional
- [ ] Copy the Payment Link URL

### 3. Connect to Site
- [ ] Open `brand-config.php`
- [ ] Replace `BRAND_STRIPE_URL` value with your Stripe Payment Link URL:
  ```php
  define( 'BRAND_STRIPE_URL', 'https://buy.stripe.com/your-link-id' );
  ```
- [ ] Verify the pre-checkout page (`/start-treatment/`) CTA now links to Stripe
- [ ] Test the full flow: Quiz → Pre-checkout → Stripe → Thank You

### 4. Stripe Webhook (for automated emails)
If you want automated email confirmations after payment:
- [ ] In Stripe Dashboard → Developers → Webhooks
- [ ] Add endpoint: `https://yourdomain.com/wp-json/fc/v1/stripe-webhook`
- [ ] Select event: `checkout.session.completed`
- [ ] Note: The webhook endpoint is NOT yet built in the codebase. Options:
  - **Option A (recommended):** Use Zapier/Make to listen for Stripe events and trigger emails via your email provider
  - **Option B:** Build a simple REST endpoint in WordPress (see email-templates.php for the send helper)
- [ ] Test webhook delivery in Stripe Dashboard

### 5. Post-Payment Redirect
- [ ] Confirm Stripe Payment Link redirects to `/thank-you/` after successful payment
- [ ] Verify thank-you page loads correctly
- [ ] Test on mobile

## Testing Checklist

- [ ] Complete quiz → eligible result → pre-checkout → Stripe checkout
- [ ] Complete quiz → review result → pre-checkout → Stripe checkout
- [ ] Complete quiz → unsuitable result → contact page
- [ ] Test Stripe checkout with test card (4242 4242 4242 4242)
- [ ] Confirm redirect to thank-you page after test payment
- [ ] Verify Stripe Dashboard shows the test payment
- [ ] Test on mobile (iOS Safari, Android Chrome)
- [ ] Test with ad blockers enabled (ensure CTA still works)

## Go-Live

- [ ] Switch Stripe from test mode to live mode
- [ ] Update Payment Link URL in brand-config.php if different for live mode
- [ ] Verify first real payment processes correctly
- [ ] Set up Stripe email receipts (Stripe Dashboard → Settings → Emails)
- [ ] Configure dispute/chargeback notifications
- [ ] Set up refund process documentation for support team

## Refund Policy

Document and implement the refund position:
- [ ] If clinician deems treatment unsuitable → automatic full refund
- [ ] Cancellation within X days → refund policy TBD
- [ ] Ongoing subscription cancellation → no refund for current period
- [ ] Document this in Terms of Service page

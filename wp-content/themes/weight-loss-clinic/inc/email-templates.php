<?php
/**
 * Email Templates & Send Helper
 *
 * Transactional email templates for the weight-loss funnel.
 * Templates are rendered as HTML emails using wp_mail().
 *
 * INTEGRATION NOTE:
 * These templates are ready to use. To trigger them automatically:
 *   Option A: Stripe Webhook → WordPress endpoint → fc_send_confirmation_email()
 *   Option B: Zapier/Make listens to Stripe "checkout.session.completed" → calls WP REST endpoint
 *   Option C: Manual trigger from WP admin after payment verification
 *
 * For now, the thank-you page serves as the immediate confirmation.
 * Email sending requires a trigger mechanism (webhook or automation).
 *
 * @package DigitalClinic
 */

defined( 'ABSPATH' ) || exit;

/**
 * Send a transactional email using a named template.
 *
 * @param string $to        Recipient email address.
 * @param string $template  Template name: 'confirmation' | 'next_steps'.
 * @param array  $data      Merge data for the template.
 * @return bool Whether the email was sent.
 */
function fc_send_email( string $to, string $template, array $data = [] ) : bool {
    $brand_name    = fc_setting( 'brand_name' );
    $support_email = fc_setting( 'support_email' );

    $defaults = [
        'brand_name'    => $brand_name,
        'support_email' => $support_email,
        'first_name'    => '',
        'site_url'      => home_url(),
    ];
    $data = wp_parse_args( $data, $defaults );

    $subject = '';
    $body    = '';

    switch ( $template ) {
        case 'confirmation':
            $subject = fc_email_subject_confirmation( $data );
            $body    = fc_email_body_confirmation( $data );
            break;

        case 'next_steps':
            $subject = fc_email_subject_next_steps( $data );
            $body    = fc_email_body_next_steps( $data );
            break;

        default:
            return false;
    }

    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . $data['brand_name'] . ' <' . ( $support_email ?: 'noreply@' . wp_parse_url( home_url(), PHP_URL_HOST ) ) . '>',
    ];

    if ( $support_email ) {
        $headers[] = 'Reply-To: ' . $support_email;
    }

    return wp_mail( $to, $subject, fc_email_wrap( $body, $data ), $headers );
}

/**
 * Wrap email body in a simple, clean HTML layout.
 */
function fc_email_wrap( string $content, array $data ) : string {
    $brand = esc_html( $data['brand_name'] );
    $year  = wp_date( 'Y' );
    $support = $data['support_email'] ? '<a href="mailto:' . esc_attr( $data['support_email'] ) . '">' . esc_html( $data['support_email'] ) . '</a>' : '';

    return <<<HTML
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"></head>
<body style="margin:0;padding:0;background:#FAF8F5;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#FAF8F5;padding:40px 20px;">
<tr><td align="center">
<table width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;background:#FFFFFF;border-radius:12px;overflow:hidden;">

<!-- Header -->
<tr><td style="padding:32px 32px 0;text-align:center;">
    <p style="font-size:18px;font-weight:700;color:#1A1A18;margin:0;">{$brand}</p>
</td></tr>

<!-- Content -->
<tr><td style="padding:24px 32px 32px;">
    {$content}
</td></tr>

<!-- Footer -->
<tr><td style="padding:20px 32px;border-top:1px solid #E8E4DF;font-size:12px;color:#7A7672;line-height:1.5;">
    <p style="margin:0 0 8px;">&copy; {$year} {$brand}. All rights reserved.</p>
    <p style="margin:0 0 8px;">All treatment is subject to clinical review and approval by a registered healthcare provider. Individual results vary.</p>
    {$support}
</td></tr>

</table>
</td></tr>
</table>
</body>
</html>
HTML;
}

/* ── Template: Payment Confirmation ─────────────────────────── */

function fc_email_subject_confirmation( array $data ) : string {
    return 'Your ' . $data['brand_name'] . ' consultation has been secured';
}

function fc_email_body_confirmation( array $data ) : string {
    $name = $data['first_name'] ? esc_html( $data['first_name'] ) : 'there';

    return <<<HTML
<h1 style="font-size:22px;color:#1A1A18;margin:0 0 16px;">Thank you, {$name}</h1>
<p style="font-size:15px;color:#4A4744;line-height:1.65;margin:0 0 16px;">Your payment has been received and your clinician review is now in progress.</p>

<div style="background:#FAF8F5;border-radius:12px;padding:20px 24px;margin:0 0 24px;">
    <p style="font-size:14px;font-weight:600;color:#1A1A18;margin:0 0 12px;">What happens next:</p>
    <p style="font-size:14px;color:#4A4744;line-height:1.65;margin:0 0 8px;">1. You choose a consultation time from your patient portal</p>
    <p style="font-size:14px;color:#4A4744;line-height:1.65;margin:0 0 8px;">2. An AHPRA-registered clinician conducts your telehealth consultation</p>
    <p style="font-size:14px;color:#4A4744;line-height:1.65;margin:0;">3. If clinically appropriate, your personalised care plan is confirmed</p>
</div>

<p style="font-size:14px;color:#4A4744;line-height:1.65;margin:0 0 16px;">Your payment covers the clinical consultation. Any prescribed items are separate, subject to your clinician&rsquo;s independent decision, and dispensed by Australian-registered pharmacies.</p>

<p style="font-size:13px;color:#7A7672;line-height:1.65;margin:0;">Not all patients are approved — suitability is determined during the consultation. Your information is handled confidentially.</p>
HTML;
}

/* ── Template: Next Steps / Clinician Review ────────────────── */

function fc_email_subject_next_steps( array $data ) : string {
    return 'Your clinician review — what to expect';
}

function fc_email_body_next_steps( array $data ) : string {
    $name = $data['first_name'] ? esc_html( $data['first_name'] ) : 'there';

    return <<<HTML
<h1 style="font-size:22px;color:#1A1A18;margin:0 0 16px;">Hi {$name},</h1>
<p style="font-size:15px;color:#4A4744;line-height:1.65;margin:0 0 16px;">Your health information is currently being reviewed by a licensed clinician. Here is what you can expect:</p>

<div style="background:#FAF8F5;border-radius:12px;padding:20px 24px;margin:0 0 24px;">
    <p style="font-size:14px;font-weight:600;color:#1A1A18;margin:0 0 12px;">Timeline:</p>
    <p style="font-size:14px;color:#4A4744;line-height:1.65;margin:0 0 8px;"><strong>Within 1&ndash;2 business days:</strong> Your clinician completes their review.</p>
    <p style="font-size:14px;color:#4A4744;line-height:1.65;margin:0 0 8px;"><strong>If appropriate:</strong> You&rsquo;re invited to book your telehealth consultation.</p>
    <p style="font-size:14px;color:#4A4744;line-height:1.65;margin:0;"><strong>Consultation:</strong> Your clinician discusses suitable options and confirms your care plan with you directly.</p>
</div>

<p style="font-size:14px;color:#4A4744;line-height:1.65;margin:0 0 16px;">If your clinician prescribes anything as part of your care plan, it is dispensed separately by an Australian-registered pharmacy and shipped discreetly to your nominated address.</p>

<p style="font-size:14px;font-weight:600;color:#1A1A18;margin:0 0 8px;">In the meantime:</p>
<ul style="font-size:14px;color:#4A4744;line-height:1.65;margin:0 0 16px;padding-left:20px;">
    <li>Keep your phone available in case our clinical team needs to reach you</li>
    <li>Consider informing your GP about your participation in this program</li>
    <li>Review any current medications you are taking, as this information may be discussed during your consultation</li>
</ul>

<p style="font-size:13px;color:#7A7672;line-height:1.65;margin:0;">This program is delivered under the supervision of Australian-registered healthcare providers. Your personal health information is handled in accordance with Australian privacy legislation and is never shared without your consent.</p>
HTML;
}

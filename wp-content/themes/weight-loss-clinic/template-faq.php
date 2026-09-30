<?php
/**
 * Template Name: FAQ
 *
 * MVP layout (May 2026):
 *   - Image hero (lifestyle, calm/dignified)
 *   - Expanded category structure aligned with conversion + objection handling
 *   - Mid-page CTA after key categories
 *   - Closing CTA / contact bridge
 *
 * Categories (May 2026 brief):
 *   - Getting started
 *   - Eligibility
 *   - Consultations & decisions
 *   - Pricing & inclusions
 *   - Delivery & privacy
 *   - Safety, follow-up & escalation
 *   - Patient portal
 *   - Not suitable / alternatives
 *
 * Page slug: /faq/
 *
 * @package WeightLossClinic
 */

get_header();

$quiz_url    = fc_setting( 'cta_url' );
$booking_url = fc_setting( 'booking_url' );
$contact_url = fc_setting( 'contact_url' );
$portal_url  = fc_setting( 'portal_url' );
$hiw_url     = fc_setting( 'how_it_works_url' );
$lifestyle_uri = FC_URI . '/assets/images/lifestyle';

/*
 * FAQs are editable in the admin under "FAQs" (fc_faq post type, grouped
 * by the FAQ Group taxonomy). The hardcoded set below is only a fallback
 * so a fresh install renders a complete page before any FAQs are added.
 */
$default_groups = [
    [
        'label' => 'Getting started',
        'title' => 'How to begin',
        'items' => [
            [
                'q' => 'How do I start?',
                'a' => 'Begin with the 60-second eligibility check. If suitable, you&rsquo;ll be invited to complete a structured intake and book a telehealth consultation with an AHPRA-registered clinician.',
            ],
            [
                'q' => 'Can I start without a consultation?',
                'a' => 'No. A real-time clinician consultation is required before any prescribing decision. Completing the intake form alone is not a substitute for a consultation.',
            ],
            [
                'q' => 'How long does the whole process take?',
                'a' => 'The eligibility check takes about two minutes. Intake takes 10&ndash;15 minutes. Most patients are seen in consultation within a few business days. Your clinician&rsquo;s decision is delivered during the consultation itself.',
            ],
        ],
    ],
    [
        'label' => 'Eligibility',
        'title' => 'Who can access the pathway',
        'items' => [
            [
                'q' => 'Is everyone approved for the program?',
                'a' => 'No. Approval depends on your individual health profile, medical history, and clinical suitability. Our clinicians exercise independent judgment and may decline patients who are not suitable for this pathway.',
            ],
            [
                'q' => 'Who is eligible to apply?',
                'a' => 'Generally, Australian adults (18+) who are comfortable with telehealth and willing to complete a clinical intake and consultation. The eligibility quiz filters out obvious exclusions up front; your clinician makes the final determination.',
            ],
            [
                'q' => 'Can I use this service from anywhere in Australia?',
                'a' => 'The service operates Australia-wide via telehealth. Some clinical presentations require local in-person assessment; your clinician will advise if that applies to you.',
            ],
        ],
    ],
    [
        'label' => 'Consultations & decisions',
        'title' => 'How clinical decisions work',
        'items' => [
            [
                'q' => 'How long is the consultation?',
                'a' => 'Typically 20&ndash;30 minutes over secure video. Your clinician uses your intake as the starting point, asks follow-up questions, and discusses what, if anything, is clinically appropriate.',
            ],
            [
                'q' => 'Does booking a consultation guarantee approval?',
                'a' => 'No. A consultation is a clinical review, not a pre-approval step. Its purpose is to determine whether this pathway is clinically appropriate for you.',
            ],
            [
                'q' => 'Will I always see the same clinician?',
                'a' => 'We aim to keep you with a consistent clinician wherever possible. If your primary clinician is unavailable, another AHPRA-registered clinician in the care team will cover.',
            ],
            [
                'q' => 'What if I disagree with my clinician\'s decision?',
                'a' => 'You can request a second clinical opinion via our care team, or take the clinical summary to your primary care provider for independent review. You&rsquo;re not locked into any single pathway.',
            ],
        ],
        'cta' => true,
    ],
    [
        'label' => 'Pricing & inclusions',
        'title' => 'What you pay for and what you get',
        'items' => [
            [
                'q' => 'What is included in the program fee?',
                'a' => 'Your fee covers the clinical service: scheduled clinician check-ins, care-plan reviews, secure messaging, and continuity with your care team. The patient portal is included.',
            ],
            [
                'q' => 'How are clinically prescribed items billed?',
                'a' => 'Any clinically prescribed items are separate, subject to independent clinician decision and appropriate dispensing channels, with relevant pharmacy fees applied. They are not bundled into the program fee.',
            ],
            [
                'q' => 'Are there any lock-in contracts?',
                'a' => 'No. There are no long-term contracts. You can pause or cancel through your patient portal or by contacting our care team at any time.',
            ],
        ],
    ],
    [
        'label' => 'Delivery & privacy',
        'title' => 'How information and items are handled',
        'items' => [
            [
                'q' => 'Is my information private?',
                'a' => 'Yes. Your personal health information is handled in accordance with the Australian Privacy Act and relevant health-records legislation. Your data is never shared with third parties without your explicit consent.',
            ],
            [
                'q' => 'How does delivery work where prescribed items are involved?',
                'a' => 'Where clinically appropriate, prescribed items are dispensed by an appropriate pharmacy and delivered discreetly. The dispensing pathway is independent of website browsing and follows standard pharmacy procedures.',
            ],
            [
                'q' => 'Will my employer or insurer be told?',
                'a' => 'No &mdash; not without your explicit consent. The clinical relationship is between you and your clinician.',
            ],
        ],
    ],
    [
        'label' => 'Safety, follow-up & escalation',
        'title' => 'How ongoing care is structured',
        'items' => [
            [
                'q' => 'How does ongoing monitoring work?',
                'a' => 'Your care team schedules regular check-ins to review progress, monitor relevant health markers, and adjust your care plan as needed. You can communicate with your clinician through the patient portal between scheduled check-ins.',
            ],
            [
                'q' => 'What if I need specialist care?',
                'a' => 'Your clinician can facilitate referral to appropriate specialists (e.g. endocrinology) and coordinate with your primary care provider. Escalation is a normal part of safe clinical care.',
            ],
            [
                'q' => 'What about urgent or emergency situations?',
                'a' => 'If you&rsquo;re experiencing a medical emergency, contact local emergency services (000) immediately. Our telehealth service is not designed for emergency care.',
            ],
            [
                'q' => 'Can I still see my GP while on the program?',
                'a' => 'Yes &mdash; and we encourage it. We provide a clinical summary you can share with your primary care provider so your broader care remains coordinated.',
            ],
        ],
        'cta' => true,
    ],
    [
        'label' => 'Patient portal',
        'title' => 'How the portal works',
        'items' => [
            [
                'q' => 'What can I do in the patient portal?',
                'a' => 'Review your care plan, schedule and manage appointments, message your care team securely, view documents and clinical summaries, and manage billing.',
            ],
            [
                'q' => 'How do I access the portal?',
                'a' => 'After your first consultation you&rsquo;ll receive sign-in details by email. New patients can also access the portal&rsquo;s logged-out start screen at any time to begin a fresh assessment.',
            ],
            [
                'q' => 'Is the portal secure?',
                'a' => 'Yes. Sign-in is protected; all messaging and document storage uses encrypted channels. Your information is handled in accordance with the Australian Privacy Act.',
            ],
        ],
    ],
    [
        'label' => 'Not suitable / alternatives',
        'title' => 'If this pathway isn&rsquo;t right for you',
        'items' => [
            [
                'q' => 'What happens if I&rsquo;m not approved?',
                'a' => 'You&rsquo;ll be told directly during the consultation and, where possible, redirected to a more suitable pathway &mdash; whether that&rsquo;s a specialist, in-person assessment, or coordination with your GP.',
            ],
            [
                'q' => 'Is telehealth always appropriate?',
                'a' => 'No. Telehealth is not suitable for all patients or all clinical presentations. Some cases require in-person assessment, specialist referral, or additional diagnostic work. Your clinician will advise if telehealth is not appropriate for your situation.',
            ],
            [
                'q' => 'How do I cancel or pause the program?',
                'a' => 'Through your patient portal, or by contacting our care team. There are no cancellation fees and no lock-in contracts.',
            ],
        ],
    ],
];

// Published FAQs (admin-managed) win; fall back to the shipped defaults.
$groups = function_exists( 'fc_get_faq_groups' ) ? fc_get_faq_groups() : [];
if ( empty( $groups ) ) {
    $groups = $default_groups;
}

// Preserve the mid-page CTA rhythm: after the 3rd and 6th groups.
foreach ( $groups as $i => $group ) {
    if ( ! isset( $group['cta'] ) && in_array( $i + 1, [ 3, 6 ], true ) ) {
        $groups[ $i ]['cta'] = true;
    }
}

// FAQPage schema (helps Google's rich-result eligibility)
$schema_items = [];
foreach ( $groups as $g ) {
    foreach ( $g['items'] as $item ) {
        $schema_items[] = [
            '@type'          => 'Question',
            'name'           => wp_strip_all_tags( $item['q'] ),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text'  => wp_strip_all_tags( $item['a'] ),
            ],
        ];
    }
}
$faq_schema = [
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => $schema_items,
];
?>

<article class="fc-page fc-page--faq">

    <div class="fc-page__hero" role="presentation">
        <img
            src="<?php echo esc_url( $lifestyle_uri . '/calm-glass-of-water.jpg' ); ?>"
            alt=""
            class="fc-page__hero-img"
            width="2400"
            height="1600"
            loading="eager"
            decoding="async"
            fetchpriority="high">
        <div class="fc-page__hero-overlay" aria-hidden="true"></div>
        <div class="fc-container">
            <header class="fc-page__header fc-page__header--over-image fc-reveal">
                <p class="fc-eyebrow"><?php echo esc_html( fc_page_hero( 'faq', 'eyebrow' ) ); ?></p>
                <h1 class="fc-h1"><?php echo fc_accent_headline( fc_page_hero( 'faq', 'headline' ), fc_page_hero( 'faq', 'accent' ) ); ?></h1>
                <p class="fc-page__intro"><?php echo wp_kses_post( fc_page_hero( 'faq', 'intro' ) ); ?></p>
                <div class="fc-page__header-actions">
                    <a href="<?php echo esc_url( $quiz_url ); ?>" class="fc-btn fc-btn--primary">Check eligibility</a>
                    <a href="<?php echo esc_url( $contact_url ); ?>" class="fc-btn fc-btn--ghost-light">Ask a question</a>
                </div>
            </header>
        </div>
    </div>

    <section class="fc-section fc-section--faq-body">
        <div class="fc-container fc-container--narrow">

            <?php foreach ( $groups as $g_index => $group ) : ?>
                <div class="fc-faq-group fc-reveal">
                    <div class="fc-faq-group__header">
                        <p class="fc-eyebrow"><?php echo esc_html( $group['label'] ); ?></p>
                        <h2 class="fc-h3"><?php echo wp_kses_post( $group['title'] ); ?></h2>
                    </div>
                    <div class="fc-faq-group__items">
                        <?php foreach ( $group['items'] as $i_index => $item ) : ?>
                            <details class="fc-faq-item"<?php echo ( $g_index === 0 && $i_index === 0 ) ? ' open' : ''; ?>>
                                <summary class="fc-faq-item__summary">
                                    <span class="fc-faq-item__question"><?php echo esc_html( $item['q'] ); ?></span>
                                    <span class="fc-faq-item__icon" aria-hidden="true">+</span>
                                </summary>
                                <div class="fc-faq-item__answer">
                                    <p><?php echo wp_kses_post( $item['a'] ); ?></p>
                                </div>
                            </details>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php if ( ! empty( $group['cta'] ) ) : ?>
                    <div class="fc-faq-midcta fc-reveal">
                        <div class="fc-faq-midcta__inner">
                            <p>Ready to see if this pathway is right for you?</p>
                            <a href="<?php echo esc_url( $quiz_url ); ?>" class="fc-btn fc-btn--primary">Check eligibility</a>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

        </div>
    </section>

    <section class="fc-section fc-section--faq-cta">
        <div class="fc-container fc-container--narrow">
            <div class="fc-plan-cta fc-reveal">
                <h2 class="fc-h2">Still have a question?</h2>
                <p>Our care team answers scheduling and administrative questions within one business day. Clinical questions are answered by your clinician during your consultation.</p>
                <div class="fc-plan-cta__actions">
                    <a href="<?php echo esc_url( $contact_url ); ?>" class="fc-btn fc-btn--primary">Contact support</a>
                    <a href="<?php echo esc_url( $booking_url ); ?>" class="fc-btn fc-btn--ghost">Book a consultation</a>
                </div>
            </div>
        </div>
    </section>

</article>

<script type="application/ld+json"><?php echo wp_json_encode( $faq_schema, JSON_UNESCAPED_SLASHES ); ?></script>

<?php get_footer(); ?>

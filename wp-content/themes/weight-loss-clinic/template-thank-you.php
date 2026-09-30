<?php
/**
 * Template Name: Thank You / Confirmation
 *
 * Confirmation screen after the patient has booked a consultation
 * or submitted their assessment. Sets clear expectations for the
 * clinical review, provides a short prep checklist, and offers a
 * contact line for follow-up. Deliberately free of treatment claims
 * and prescription-medicine references.
 *
 * Page slug: /thank-you/
 *
 * @package WeightLossClinic
 */

get_header();

$brand_name    = fc_setting( 'brand_name' );
$support_email = fc_setting( 'support_email' );
$booking_url   = fc_setting( 'booking_url' );
$contact_url   = fc_setting( 'contact_url' );
$portal_url    = fc_setting( 'portal_url' );
?>

<article class="fc-page fc-page--thankyou">

    <div class="fc-section fc-section--thankyou">
        <div class="fc-container fc-container--narrow">

            <div class="fc-thankyou" data-fc-track="confirmation_viewed">

                <header class="fc-thankyou__header">
                    <div class="fc-thankyou__icon" aria-hidden="true">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                    <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'thanks_hero_eyebrow' ) ); ?></p>
                    <h1 class="fc-h2"><?php echo esc_html( fc_setting( 'thanks_hero_headline' ) ); ?></h1>
                    <p class="fc-thankyou__subhead"><?php echo esc_html( fc_setting( 'thanks_hero_subhead' ) ); ?></p>
                </header>

                <section class="fc-thankyou__timeline">
                    <h2 class="fc-h4"><?php echo esc_html( fc_setting( 'thanks_timeline_heading' ) ); ?></h2>
                    <ol class="fc-thankyou__steps">
                        <?php foreach ( fc_setting_pairs( 'thanks_steps', [ 'label', 'detail' ] ) as $step ) : ?>
                        <li>
                            <strong><?php echo esc_html( $step['label'] ); ?></strong>
                            <span><?php echo esc_html( $step['detail'] ); ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ol>
                </section>

                <section class="fc-thankyou__prep">
                    <h2 class="fc-h4"><?php echo esc_html( fc_setting( 'thanks_prep_heading' ) ); ?></h2>
                    <p class="fc-thankyou__prep-intro"><?php echo esc_html( fc_setting( 'thanks_prep_intro' ) ); ?></p>
                    <ul class="fc-thankyou__checklist" role="list">
                        <?php foreach ( fc_setting_lines( 'thanks_checklist_items' ) as $checklist_item ) : ?>
                        <li>
                            <span class="fc-thankyou__check" aria-hidden="true">&#10003;</span>
                            <span><?php echo esc_html( $checklist_item ); ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="fc-thankyou__calendar" data-fc-track="add_to_calendar_clicked">
                        <p class="fc-thankyou__calendar-label"><?php echo esc_html( fc_setting( 'thanks_calendar_label' ) ); ?></p>
                        <p class="fc-thankyou__calendar-note"><?php echo esc_html( fc_setting( 'thanks_calendar_note' ) ); ?></p>
                    </div>
                </section>

                <section class="fc-thankyou__important">
                    <h2 class="fc-h4"><?php echo esc_html( fc_setting( 'thanks_important_heading' ) ); ?></h2>
                    <ul>
                        <?php foreach ( fc_setting_lines( 'thanks_important_items' ) as $important_item ) : ?>
                        <li><?php echo esc_html( $important_item ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </section>

                <section class="fc-thankyou__support">
                    <h2 class="fc-h4"><?php echo esc_html( fc_setting( 'thanks_support_heading' ) ); ?></h2>
                    <?php if ( $support_email ) : ?>
                        <?php $support_link = '<a href="mailto:' . esc_attr( $support_email ) . '">' . esc_html( $support_email ) . '</a>'; ?>
                        <p><?php echo wp_kses( str_replace( '{email}', $support_link, esc_html( fc_setting( 'thanks_support_body' ) ) ), [ 'a' => [ 'href' => [] ] ] ); ?></p>
                    <?php else : ?>
                        <?php $contact_link = '<a href="' . esc_url( $contact_url ) . '">' . esc_html__( 'Contact the clinic', 'flavour-clinic' ) . '</a>'; ?>
                        <p><?php echo wp_kses( str_replace( '{contact}', $contact_link, esc_html( fc_setting( 'thanks_support_body_alt' ) ) ), [ 'a' => [ 'href' => [] ] ] ); ?></p>
                    <?php endif; ?>
                </section>

                <div class="fc-thankyou__cta-wrap">
                    <a href="<?php echo esc_url( $booking_url ); ?>" class="fc-btn fc-btn--ghost"><?php echo esc_html( fc_setting( 'thanks_cta_booking_text' ) ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="fc-btn fc-btn--outline"><?php echo esc_html( fc_setting( 'thanks_cta_home_text' ) ); ?></a>
                </div>

            </div>

        </div>
    </div>

</article>

<?php get_footer(); ?>

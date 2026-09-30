<?php
/**
 * Template Name: Start Treatment
 *
 * Pre-checkout conviction page. Sits between quiz result and Stripe Payment Link.
 * Reinforces eligibility, sets expectations, shows trust signals, drives to checkout.
 *
 * Create a WordPress page with slug "start-treatment" and assign this template.
 */

get_header();

$checkout_url  = fc_setting( 'stripe_url' );
$price_from    = (int) fc_setting( 'price_from' );
$brand_name    = fc_setting( 'brand_name' );
$support_email = fc_setting( 'support_email' );
?>

<article class="fc-page fc-page--precheckout">

    <div class="fc-section fc-section--precheckout">
        <div class="fc-container fc-container--narrow">

            <div class="fc-precheckout" data-fc-track="precheckout_viewed">

                <!-- Eligibility Confirmation -->
                <div class="fc-precheckout__header">
                    <div class="fc-precheckout__badge">
                        <span class="fc-precheckout__badge-icon">&#10003;</span>
                    </div>
                    <h1 class="fc-h2"><?php echo esc_html( fc_setting( 'stt_hero_headline' ) ); ?></h1>
                    <p class="fc-precheckout__subhead"><?php echo esc_html( fc_setting( 'stt_hero_subhead' ) ); ?></p>
                </div>

                <!-- 3-Step Process -->
                <div class="fc-precheckout__process">
                    <h2 class="fc-h4"><?php echo esc_html( fc_setting( 'stt_process_heading' ) ); ?></h2>
                    <ol class="fc-precheckout__steps">
                        <?php foreach ( fc_setting_pairs( 'stt_steps', [ 'label', 'detail' ] ) as $step ) : ?>
                        <li>
                            <strong><?php echo esc_html( $step['label'] ); ?></strong>
                            <span><?php echo esc_html( $step['detail'] ); ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ol>
                </div>

                <!-- Pricing Block -->
                <div class="fc-precheckout__pricing">
                    <p class="fc-precheckout__price">
                        <?php echo esc_html( fc_setting( 'stt_price_initial_label' ) ); ?> <strong>$<?php echo esc_html( $price_from ); ?></strong> &middot; <?php echo esc_html( fc_setting( 'stt_price_followup_label' ) ); ?> <strong>$<?php echo esc_html( (int) fc_setting( 'price_followup' ) ); ?></strong>
                    </p>
                    <p class="fc-precheckout__price-note"><?php echo esc_html( fc_setting( 'stt_price_note' ) ); ?></p>
                </div>

                <!-- Trust Signals -->
                <div class="fc-precheckout__trust">
                    <?php foreach ( fc_setting_pairs( 'stt_trust_items', [ 'icon', 'text' ] ) as $trust_item ) : ?>
                    <div class="fc-precheckout__trust-item">
                        <span class="fc-precheckout__trust-icon"><?php echo esc_html( $trust_item['icon'] ); ?></span>
                        <span><?php echo esc_html( $trust_item['text'] ); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Primary CTA -->
                <div class="fc-precheckout__cta-wrap">
                    <a href="<?php echo esc_url( $checkout_url ); ?>" class="fc-btn fc-btn--primary fc-precheckout__cta" data-fc-track="checkout_clicked">
                        <?php echo esc_html( fc_setting( 'stt_cta_text' ) ); ?>
                    </a>
                    <p class="fc-precheckout__cta-note"><?php echo esc_html( fc_setting( 'stt_cta_note' ) ); ?></p>
                </div>

                <!-- Compliance Disclaimer -->
                <div class="fc-precheckout__disclaimer">
                    <p><?php echo esc_html( fc_setting( 'stt_disclaimer' ) ); ?></p>
                    <?php if ( $support_email ) : ?>
                        <p>Questions? Contact us at <a href="mailto:<?php echo esc_attr( $support_email ); ?>"><?php echo esc_html( $support_email ); ?></a></p>
                    <?php endif; ?>
                </div>

            </div>

        </div>
    </div>

</article>

<?php get_footer(); ?>

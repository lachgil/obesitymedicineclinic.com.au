<?php
/**
 * Footer
 *
 * Contact details, disclaimer, and social links come from the Customizer
 * (Theme Settings → Footer). Legacy ACF options win when set.
 */
$has_acf    = function_exists( 'get_field' );
$email      = ( $has_acf ? get_field( 'footer_email', 'option' ) : '' )      ?: fc_setting( 'footer_email', '' );
$phone      = ( $has_acf ? get_field( 'footer_phone', 'option' ) : '' )      ?: fc_setting( 'footer_phone', '' );
$address    = ( $has_acf ? get_field( 'footer_address', 'option' ) : '' )    ?: fc_setting( 'footer_address', '' );
$disclaimer = ( $has_acf ? get_field( 'footer_disclaimer', 'option' ) : '' ) ?: fc_setting( 'footer_disclaimer', '' );
$social     = $has_acf ? ( get_field( 'footer_social', 'option' ) ?: [] ) : [];

if ( empty( $social ) ) {
    $social = fc_setting_pairs( 'footer_social', [ 'label', 'url' ] );
}
?>

<footer class="fc-footer" role="contentinfo">
    <div class="fc-container">

        <!-- Top Bar -->
        <div class="fc-footer__top">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="fc-footer__logo-text" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
            </a>
            <?php if ( $email || $phone || $address ) : ?>
                <address class="fc-footer__contact">
                    <?php if ( $email ) : ?>
                        <a href="mailto:<?php echo esc_attr( $email ); ?>" class="fc-footer__contact-item">
                            <?php echo esc_html( $email ); ?>
                        </a>
                    <?php endif; ?>
                    <?php if ( $phone ) : ?>
                        <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" class="fc-footer__contact-item">
                            <?php echo esc_html( $phone ); ?>
                        </a>
                    <?php endif; ?>
                    <?php if ( $address ) : ?>
                        <span class="fc-footer__contact-item"><?php echo esc_html( $address ); ?></span>
                    <?php endif; ?>
                </address>
            <?php endif; ?>
        </div>

        <!-- Navigation Columns -->
        <div class="fc-footer__nav">
            <?php if ( has_nav_menu( 'footer' ) ) : ?>
                <div>
                    <p class="fc-footer__nav-heading"><?php echo esc_html( fc_setting( 'nav_treatments_label' ) ); ?></p>
                    <ul class="fc-footer__nav-list" role="list">
                        <?php
                        wp_nav_menu( [
                            'theme_location' => 'footer',
                            'container'      => false,
                            'items_wrap'     => '%3$s',
                            'depth'          => 1,
                            'fallback_cb'    => false,
                        ] );
                        ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div>
                <p class="fc-footer__nav-heading"><?php esc_html_e( 'Company', 'flavour-clinic' ); ?></p>
                <ul class="fc-footer__nav-list" role="list">
                    <li><a href="<?php echo esc_url( home_url( fc_setting( 'how_it_works_url' ) ) ); ?>"><?php esc_html_e( 'How It Works', 'flavour-clinic' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( fc_setting( 'about_url' ) ) ); ?>"><?php esc_html_e( 'About & Governance', 'flavour-clinic' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( fc_setting( 'plans_url' ) ) ); ?>"><?php esc_html_e( 'Plans', 'flavour-clinic' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( fc_setting( 'contact_url' ) ) ); ?>"><?php esc_html_e( 'Contact', 'flavour-clinic' ); ?></a></li>
                </ul>
            </div>
            <div>
                <p class="fc-footer__nav-heading"><?php esc_html_e( 'Your care', 'flavour-clinic' ); ?></p>
                <ul class="fc-footer__nav-list" role="list">
                    <li><a href="<?php echo esc_url( home_url( fc_setting( 'booking_url' ) ) ); ?>"><?php esc_html_e( 'Book Consultation', 'flavour-clinic' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( fc_setting( 'cta_url' ) ) ); ?>"><?php esc_html_e( 'Check Eligibility', 'flavour-clinic' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( fc_setting( 'portal_url' ) ) ); ?>"><?php esc_html_e( 'Patient Portal', 'flavour-clinic' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( fc_setting( 'faq_url' ) ) ); ?>"><?php esc_html_e( 'FAQ', 'flavour-clinic' ); ?></a></li>
                </ul>
            </div>
            <div>
                <p class="fc-footer__nav-heading"><?php esc_html_e( 'Legal', 'flavour-clinic' ); ?></p>
                <ul class="fc-footer__nav-list" role="list">
                    <li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'flavour-clinic' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>"><?php esc_html_e( 'Terms of Service', 'flavour-clinic' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/medical-disclaimer/' ) ); ?>"><?php esc_html_e( 'Medical Disclaimer', 'flavour-clinic' ); ?></a></li>
                </ul>
            </div>
        </div>

        <!-- Disclaimer -->
        <div class="fc-footer__disclaimer">
            <?php if ( $disclaimer ) : ?>
                <?php echo wp_kses_post( $disclaimer ); ?>
            <?php else : ?>
                <p>This website provides general health information and is not a substitute for professional medical advice. All treatment is subject to clinical assessment and approval by a registered healthcare provider. Individual results vary and depend on clinical factors, adherence, and lifestyle. A telehealth consultation may be required before any treatment is prescribed. Medication is dispensed by Australian-registered pharmacies. Your personal health information is handled confidentially in accordance with Australian privacy legislation.</p>
            <?php endif; ?>
        </div>

        <!-- Bottom Bar -->
        <div class="fc-footer__bottom">
            <span>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>. <?php esc_html_e( 'All rights reserved.', 'flavour-clinic' ); ?></span>

            <nav class="fc-footer__legal-nav" aria-label="<?php esc_attr_e( 'Legal', 'flavour-clinic' ); ?>">
                <?php
                wp_nav_menu( [
                    'theme_location' => 'legal',
                    'container'      => false,
                    'items_wrap'     => '%3$s',
                    'depth'          => 1,
                    'fallback_cb'    => function () {
                        ?>
                        <a href="/privacy-policy/"><?php esc_html_e( 'Privacy Policy', 'flavour-clinic' ); ?></a>
                        <a href="/terms/"><?php esc_html_e( 'Terms of Service', 'flavour-clinic' ); ?></a>
                        <?php
                    },
                ] );
                ?>
            </nav>

            <?php if ( ! empty( $social ) ) : ?>
                <div class="fc-footer__social">
                    <?php foreach ( $social as $link ) : ?>
                        <?php if ( ! empty( $link['url'] ) && ! empty( $link['label'] ) ) : ?>
                            <a href="<?php echo esc_url( $link['url'] ); ?>" target="_blank" rel="noopener noreferrer">
                                <?php echo esc_html( $link['label'] ); ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</footer>

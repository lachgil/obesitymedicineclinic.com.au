<?php
/**
 * Navigation Drawer
 *
 * Premium right-side slide-out navigation. Opens from the menu trigger
 * on both mobile and desktop. Contains treatment links, company links,
 * support links, and a primary CTA.
 */
$cta = fc_get_cta();
?>
<div class="fc-mobile-nav" id="fc-mobile-nav" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Navigation menu', 'flavour-clinic' ); ?>" aria-hidden="true">
    <div class="fc-mobile-nav__overlay" id="fc-mobile-nav-overlay"></div>
    <div class="fc-mobile-nav__panel">

        <!-- ── Drawer Header ── -->
        <div class="fc-drawer-header">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="fc-drawer-header__logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                <?php if ( has_custom_logo() ) : ?>
                    <?php
                    // Direct <img> — the_custom_logo() nests an <a> inside this
                    // <a>, which browsers hoist out, breaking logo sizing.
                    echo wp_get_attachment_image(
                        (int) get_theme_mod( 'custom_logo' ),
                        'medium',
                        false,
                        [ 'class' => 'fc-drawer-header__logo-img', 'alt' => get_bloginfo( 'name' ) ]
                    );
                    ?>
                <?php else : ?>
                    <span class="fc-drawer-header__logo-text"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
                <?php endif; ?>
            </a>
            <button class="fc-mobile-nav__close" id="fc-menu-close" aria-label="<?php esc_attr_e( 'Close menu', 'flavour-clinic' ); ?>">
                <?php echo fc_icon( 'close' ); ?>
            </button>
        </div>

        <!-- ── Drawer Navigation ── -->
        <nav class="fc-mobile-nav__menu" aria-label="<?php esc_attr_e( 'Site navigation', 'flavour-clinic' ); ?>">

            <!-- ── Treatments ── -->
            <div class="fc-drawer-section">
                <p class="fc-drawer-section__label"><?php echo esc_html( fc_setting( 'nav_treatments_label' ) ); ?></p>
                <?php
                wp_nav_menu( [
                    'theme_location' => 'footer',
                    'container'      => false,
                    'items_wrap'     => '<ul class="fc-drawer-section__list" role="list">%3$s</ul>',
                    'depth'          => 1,
                    'fallback_cb'    => function () {
                        ?>
                        <ul class="fc-drawer-section__list" role="list">
                            <li><a href="<?php echo esc_url( home_url( fc_setting( 'cta_url' ) ) ); ?>"><?php esc_html_e( 'Weight Loss Program', 'flavour-clinic' ); ?></a></li>
                        </ul>
                        <?php
                    },
                ] );
                ?>
            </div>

            <!-- ── Explore ── -->
            <div class="fc-drawer-section">
                <p class="fc-drawer-section__label"><?php esc_html_e( 'Explore', 'flavour-clinic' ); ?></p>
                <?php
                $plans_url    = fc_setting( 'plans_url' );
                $hiw_url      = fc_setting( 'how_it_works_url' );
                $about_url    = fc_setting( 'about_url' );
                $faq_url      = fc_setting( 'faq_url' );
                $booking_url  = fc_setting( 'booking_url' );
                $portal_url_m = fc_setting( 'portal_url' );
                wp_nav_menu( [
                    'theme_location' => 'primary',
                    'container'      => false,
                    'items_wrap'     => '<ul class="fc-drawer-section__list" role="list">%3$s</ul>',
                    'depth'          => 1,
                    'fallback_cb'    => function () use ( $plans_url, $hiw_url, $about_url, $faq_url ) {
                        ?>
                        <ul class="fc-drawer-section__list" role="list">
                            <li><a href="<?php echo esc_url( home_url( $plans_url ) ); ?>"><?php esc_html_e( 'Plans &amp; Programs', 'flavour-clinic' ); ?></a></li>
                            <li><a href="<?php echo esc_url( home_url( $hiw_url ) ); ?>"><?php esc_html_e( 'How It Works', 'flavour-clinic' ); ?></a></li>
                            <li><a href="<?php echo esc_url( home_url( $about_url ) ); ?>"><?php esc_html_e( 'About & Governance', 'flavour-clinic' ); ?></a></li>
                            <li><a href="<?php echo esc_url( home_url( $faq_url ) ); ?>"><?php esc_html_e( 'FAQ', 'flavour-clinic' ); ?></a></li>
                        </ul>
                        <?php
                    },
                ] );
                ?>
            </div>

            <!-- ── Your Care ── -->
            <div class="fc-drawer-section">
                <p class="fc-drawer-section__label"><?php esc_html_e( 'Your care', 'flavour-clinic' ); ?></p>
                <ul class="fc-drawer-section__list" role="list">
                    <li><a href="<?php echo esc_url( home_url( $booking_url ) ); ?>"><?php esc_html_e( 'Book a Consultation', 'flavour-clinic' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( $portal_url_m ) ); ?>"><?php esc_html_e( 'Patient Portal', 'flavour-clinic' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( fc_setting( 'contact_url' ) ) ); ?>"><?php esc_html_e( 'Contact', 'flavour-clinic' ); ?></a></li>
                </ul>
            </div>

        </nav>

        <!-- ── Drawer Footer ── -->
        <div class="fc-drawer-footer">
            <?php fc_button( $cta['text'], $cta['url'], 'primary', [ 'class' => 'fc-drawer-footer__cta' ] ); ?>
            <a href="<?php echo esc_url( home_url( $portal_url_m ) ); ?>" class="fc-drawer-footer__portal"><?php esc_html_e( 'Access patient portal', 'flavour-clinic' ); ?></a>
        </div>

    </div>
</div>

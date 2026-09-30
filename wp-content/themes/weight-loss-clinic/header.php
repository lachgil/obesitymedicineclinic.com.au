<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <noscript><style>.fc-reveal{opacity:1!important;transform:none!important;}</style></noscript>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a href="#fc-main" class="fc-skip-link fc-sr-only"><?php esc_html_e( 'Skip to content', 'flavour-clinic' ); ?></a>

<?php get_template_part( 'template-parts/header/announcement-bar' ); ?>
<?php get_template_part( 'template-parts/header/trust-bar' ); ?>

<header class="fc-header" id="fc-header" role="banner">
    <div class="fc-header__inner">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="fc-header__logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> — <?php esc_attr_e( 'Home', 'flavour-clinic' ); ?>">
            <?php if ( has_custom_logo() ) : ?>
                <?php
                // Render the logo <img> directly — the_custom_logo() emits its
                // own <a>, and an <a> inside this <a> is invalid HTML: browsers
                // hoist the image out of the header, breaking its sizing.
                echo wp_get_attachment_image(
                    (int) get_theme_mod( 'custom_logo' ),
                    'medium',
                    false,
                    [ 'class' => 'fc-header__logo-img', 'alt' => get_bloginfo( 'name' ) ]
                );
                ?>
            <?php else : ?>
                <span class="fc-header__logo-mark" aria-hidden="true">
                    <svg width="28" height="28" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="16" cy="16" r="15" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M11 16.5L14.5 20L21 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <span class="fc-header__logo-text"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
            <?php endif; ?>
        </a>

        <nav class="fc-header__nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'flavour-clinic' ); ?>">
            <?php
            wp_nav_menu( [
                'theme_location' => 'primary',
                'container'      => false,
                'items_wrap'     => '<ul class="fc-header__nav-list" role="list">%3$s</ul>',
                'depth'          => 1,
                'fallback_cb'    => function () {
                    $hiw       = fc_setting( 'how_it_works_url' );
                    $clinician = fc_setting( 'clinician_url' );
                    $about     = fc_setting( 'about_url' );
                    $faq       = fc_setting( 'faq_url' );
                    $booking   = fc_setting( 'booking_url' );
                    ?>
                    <ul class="fc-header__nav-list" role="list">
                        <li><a href="<?php echo esc_url( home_url( $hiw ) ); ?>"><?php esc_html_e( 'How It Works', 'flavour-clinic' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( $clinician ) ); ?>"><?php esc_html_e( 'Clinician-Led Care', 'flavour-clinic' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( $about ) ); ?>"><?php esc_html_e( 'About', 'flavour-clinic' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( $faq ) ); ?>"><?php esc_html_e( 'FAQ', 'flavour-clinic' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( $booking ) ); ?>"><?php esc_html_e( 'Book', 'flavour-clinic' ); ?></a></li>
                    </ul>
                    <?php
                },
            ] );
            ?>
        </nav>

        <div class="fc-header__right">
            <?php
            $portal_url   = fc_setting( 'portal_url' );
            $portal_label = fc_setting( 'portal_cta_text' );
            $cta = fc_get_cta();
            ?>
            <a href="<?php echo esc_url( home_url( $portal_url ) ); ?>" class="fc-header__portal-link" aria-label="<?php esc_attr_e( 'Patient portal', 'flavour-clinic' ); ?>">
                <?php echo fc_icon( 'lock', 'fc-icon--sm' ); ?>
                <span><?php echo esc_html( $portal_label ); ?></span>
            </a>
            <?php fc_button( $cta['text'], $cta['url'], 'primary', [ 'class' => 'fc-header__cta' ] ); ?>
            <button class="fc-header__menu-toggle" id="fc-menu-open" aria-label="<?php esc_attr_e( 'Open menu', 'flavour-clinic' ); ?>" aria-expanded="false" aria-controls="fc-mobile-nav">
                <?php echo fc_icon( 'menu' ); ?>
            </button>
        </div>
    </div>
</header>

<?php get_template_part( 'template-parts/header/mobile-nav' ); ?>

<main id="fc-main">

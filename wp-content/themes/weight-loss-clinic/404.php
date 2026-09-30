<?php
/**
 * 404 Page Template
 */
get_header();
?>

<section class="fc-section fc-section--404">
    <div class="fc-container fc-container--narrow" style="text-align:center;min-height:50vh;display:flex;flex-direction:column;align-items:center;justify-content:center;">
        <p class="fc-eyebrow"><?php esc_html_e( '404', 'flavour-clinic' ); ?></p>
        <h1 class="fc-h1" style="margin-bottom:var(--fc-space-md);"><?php esc_html_e( 'Page not found', 'flavour-clinic' ); ?></h1>
        <p style="color:var(--fc-gray-700);margin-bottom:var(--fc-space-xl);max-width:480px;">
            <?php esc_html_e( 'The page you are looking for may have been moved, removed, or is temporarily unavailable.', 'flavour-clinic' ); ?>
        </p>
        <?php fc_button( __( 'Return Home', 'flavour-clinic' ), home_url( '/' ), 'primary' ); ?>
    </div>
</section>

<?php get_footer(); ?>

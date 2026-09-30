<?php
/**
 * Header: Clinical Trust Bar
 *
 * Top-of-page green strip with clinical trust signals. Sits above the fixed
 * header (rendered immediately after the optional announcement bar) and
 * stays sticky on scroll. Visible site-wide.
 *
 * Items are read from ACF Options (`trust_bar_items`) when available,
 * otherwise a compliant default set is used.
 */

defined( 'ABSPATH' ) || exit;

// Customizer toggle (Theme Settings → Trust Bar).
if ( ! fc_setting( 'trust_bar_enabled' ) ) {
    return;
}

// Allow ACF override; fall back to Customizer items (one per line).
$items = function_exists( 'get_field' ) ? get_field( 'trust_bar_items', 'option' ) : null;

if ( empty( $items ) || ! is_array( $items ) ) {
    $items = fc_setting_lines( 'trust_bar_items' );
}

// Allow programmatic disable per request (e.g. portal templates).
if ( apply_filters( 'fc_trust_bar_disabled', false ) ) {
    return;
}
?>
<div class="fc-trust-bar" id="fc-trust-bar" role="complementary" aria-label="<?php esc_attr_e( 'Clinical trust indicators', 'flavour-clinic' ); ?>">
    <div class="fc-trust-bar__inner">
        <?php foreach ( $items as $item ) :
            $text = is_array( $item ) ? ( $item['text'] ?? '' ) : (string) $item;
            if ( ! $text ) continue;
        ?>
            <span class="fc-trust-bar__item">
                <svg class="fc-trust-bar__icon" width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M8 0a8 8 0 100 16A8 8 0 008 0zm3.5 6.2l-4 4a.5.5 0 01-.7 0l-2-2a.5.5 0 11.7-.7L7.1 9.1l3.6-3.6a.5.5 0 01.7.7z" fill="currentColor"/>
                </svg>
                <?php echo esc_html( $text ); ?>
            </span>
        <?php endforeach; ?>
    </div>
</div>

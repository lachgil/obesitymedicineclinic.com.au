<?php
/**
 * Announcement Bar
 *
 * Content comes from the Customizer (Theme Settings → Announcement Bar).
 * When ACF is active and its legacy options are set, those win.
 */

defined( 'ABSPATH' ) || exit;

$has_acf = function_exists( 'get_field' );

$enabled     = $has_acf && get_field( 'announcement_enabled', 'option' ) ? true : (bool) fc_setting( 'announcement_enabled' );
$text        = ( $has_acf ? get_field( 'announcement_text', 'option' ) : '' ) ?: fc_setting( 'announcement_text', '' );
$dismissible = $has_acf && null !== get_field( 'announcement_dismissible', 'option' )
	? (bool) get_field( 'announcement_dismissible', 'option' )
	: (bool) fc_setting( 'announcement_dismissible' );

// Link: ACF link array (legacy) or Customizer URL + label.
$link_url    = '';
$link_text   = '';
$link_target = '';

$acf_link = $has_acf ? get_field( 'announcement_link', 'option' ) : null;
if ( is_array( $acf_link ) && ! empty( $acf_link['url'] ) ) {
	$link_url    = $acf_link['url'];
	$link_text   = $acf_link['title'] ?? '';
	$link_target = $acf_link['target'] ?? '';
} else {
	$link_url  = (string) fc_setting( 'announcement_link_url', '' );
	$link_text = (string) fc_setting( 'announcement_link_text' );
}

if ( ! $enabled || ! $text ) {
	return;
}
?>

<div class="fc-announcement" id="fc-announcement">
    <span>
        <?php echo esc_html( $text ); ?>
        <?php if ( $link_url ) : ?>
            <a href="<?php echo esc_url( $link_url ); ?>"
               <?php echo $link_target ? 'target="' . esc_attr( $link_target ) . '" rel="noopener noreferrer"' : ''; ?>>
                <?php echo esc_html( $link_text ?: __( 'Learn more', 'flavour-clinic' ) ); ?>
            </a>
        <?php endif; ?>
    </span>
    <?php if ( $dismissible ) : ?>
        <button class="fc-announcement__dismiss" id="fc-dismiss-announcement" aria-label="<?php esc_attr_e( 'Dismiss', 'flavour-clinic' ); ?>">
            <?php echo fc_icon( 'close' ); ?>
        </button>
    <?php endif; ?>
</div>

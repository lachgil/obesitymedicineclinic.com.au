<?php
/**
 * Section: Split Content (Editorial)
 */
$data = $args['data'] ?? [];

$eyebrow  = $data['eyebrow'] ?? '';
$headline = $data['headline'] ?? '';
$accent   = $data['headline_accent'] ?? '';
$body     = $data['body'] ?? '';
$cta_text = $data['cta_text'] ?? '';
$cta_url  = ( $data['cta_url'] ?? '' ) ?: '#';
$image    = $data['image'] ?? null;
$position = $data['image_position'] ?? 'right';

if ( ! $headline && ! $body ) return;

$headline_html = fc_accent_headline( $headline, $accent );
$has_image     = ! empty( $image );
$reverse_class = ( $has_image && $position === 'left' ) ? '' : ( $has_image ? ' fc-split--reverse' : '' );
$full_class    = $has_image ? '' : ' fc-split--full';
?>

<section class="fc-section fc-section--split-content">
    <div class="fc-container">
        <div class="fc-split<?php echo esc_attr( $reverse_class . $full_class ); ?>">

            <?php if ( $has_image ) : ?>
                <div class="fc-split-content__image fc-reveal">
                    <?php fc_image( $image, 'large' ); ?>
                </div>
            <?php endif; ?>

            <div class="fc-split-content__text fc-reveal">
                <?php if ( $eyebrow ) : ?>
                    <p class="fc-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
                <?php endif; ?>
                <?php if ( $headline ) : ?>
                    <h2 class="fc-h2"><?php echo $headline_html; ?></h2>
                <?php endif; ?>
                <?php if ( $body ) : ?>
                    <div class="fc-body"><?php echo wp_kses_post( $body ); ?></div>
                <?php endif; ?>
                <?php if ( $cta_text ) : ?>
                    <?php fc_button( $cta_text, $cta_url, 'primary' ); ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>

<?php
/**
 * Section: CTA Banner
 */
$data = $args['data'] ?? [];

$headline  = $data['headline'] ?? '';
$body      = $data['body'] ?? '';
$cta_text  = $data['cta_text'] ?? '';
$cta_url   = ( $data['cta_url'] ?? '' ) ?: '#';
$cta2_text = $data['cta2_text'] ?? '';
$cta2_url  = ( $data['cta2_url'] ?? '' ) ?: '#';
$style     = $data['style'] ?? 'dark';

if ( ! $headline ) return;

$btn_style = $style === 'dark' ? 'white' : ( $style === 'accent' ? 'white' : 'primary' );
$btn2_style = $style === 'dark' ? 'ghost' : 'ghost';
?>

<section class="fc-section fc-section--cta-banner">
    <div class="fc-container">
        <div class="fc-cta-banner fc-cta-banner--<?php echo esc_attr( $style ); ?> fc-reveal">
            <h2 class="fc-cta-banner__headline"><?php echo esc_html( $headline ); ?></h2>
            <?php if ( $body ) : ?>
                <p class="fc-cta-banner__body"><?php echo esc_html( $body ); ?></p>
            <?php endif; ?>
            <div class="fc-cta-banner__actions">
                <?php if ( $cta_text ) : ?>
                    <?php fc_button( $cta_text, $cta_url, $btn_style ); ?>
                <?php endif; ?>
                <?php if ( $cta2_text ) : ?>
                    <?php fc_button( $cta2_text, $cta2_url, $btn2_style ); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

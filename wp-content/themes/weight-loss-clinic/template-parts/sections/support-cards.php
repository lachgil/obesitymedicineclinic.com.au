<?php
/**
 * Section: Support Cards
 *
 * Two premium cards showcasing patient portal and 24/7 support.
 * Each card has an image placeholder position and text content.
 */
$data  = $args['data'] ?? [];
$cards = $data['cards'] ?? [];

if ( empty( $cards ) ) return;
?>

<section class="fc-section fc-section--support-cards">
    <div class="fc-container">
        <div class="fc-support-cards">
            <?php foreach ( $cards as $card ) :
                if ( empty( $card['title'] ) ) continue;
                $image = $card['image'] ?? null;
            ?>
                <div class="fc-support-card fc-reveal">
                    <div class="fc-support-card__image">
                        <?php if ( is_array( $image ) && ! empty( $image['url'] ) ) : ?>
                            <?php fc_image( $image, 'large', 'fc-support-card__img' ); ?>
                        <?php else : ?>
                            <div class="fc-support-card__placeholder" aria-hidden="true">
                                <span class="fc-support-card__placeholder-label"><?php echo esc_html( $card['placeholder_label'] ?? 'Image' ); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="fc-support-card__content">
                        <h3 class="fc-support-card__title"><?php echo esc_html( $card['title'] ); ?></h3>
                        <?php if ( ! empty( $card['body'] ) ) : ?>
                            <p class="fc-support-card__body"><?php echo esc_html( $card['body'] ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

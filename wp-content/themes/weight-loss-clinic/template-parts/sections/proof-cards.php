<?php
/**
 * Section: Proof Cards
 *
 * Image-led 4-card proof/trust section. Each card has an image placeholder
 * at top, a title, and supporting copy. Mirrors the MEDVi "details matter" pattern.
 */
$data     = $args['data'] ?? [];
$eyebrow  = $data['eyebrow'] ?? '';
$headline = $data['headline'] ?? '';
$body     = $data['body'] ?? '';
$items    = $data['items'] ?? [];

if ( empty( $items ) ) return;
?>

<section class="fc-section fc-section--proof-cards">
    <div class="fc-container">
        <?php if ( $eyebrow || $headline ) : ?>
            <div class="fc-section-header fc-section-header--center fc-reveal">
                <?php if ( $eyebrow ) : ?>
                    <p class="fc-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
                <?php endif; ?>
                <?php if ( $headline ) : ?>
                    <h2 class="fc-h2"><?php echo esc_html( $headline ); ?></h2>
                <?php endif; ?>
                <?php if ( $body ) : ?>
                    <p><?php echo esc_html( $body ); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="fc-proof-grid">
            <?php foreach ( $items as $item ) :
                if ( empty( $item['title'] ) ) continue;
                $image = $item['image'] ?? null;
            ?>
                <div class="fc-proof-card fc-reveal">
                    <div class="fc-proof-card__image">
                        <?php if ( is_array( $image ) && ! empty( $image['url'] ) ) : ?>
                            <?php fc_image( $image, 'fc-card', 'fc-proof-card__img' ); ?>
                        <?php else : ?>
                            <div class="fc-proof-card__placeholder" aria-hidden="true">
                                <span class="fc-proof-card__placeholder-label"><?php echo esc_html( $item['placeholder_label'] ?? 'Image' ); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="fc-proof-card__content">
                        <h3 class="fc-proof-card__title"><?php echo esc_html( $item['title'] ); ?></h3>
                        <?php if ( ! empty( $item['description'] ) ) : ?>
                            <p class="fc-proof-card__desc"><?php echo esc_html( $item['description'] ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

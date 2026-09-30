<?php
/**
 * Section: Program Pathways
 *
 * Card-based pathway overview. NOT products — clinical program stages.
 * Each card represents a step or component of the clinical weight management pathway.
 */
$data     = $args['data'] ?? [];
$eyebrow  = $data['eyebrow'] ?? '';
$headline = $data['headline'] ?? '';
$accent   = $data['headline_accent'] ?? '';
$body     = $data['body'] ?? '';
$cards    = $data['cards'] ?? [];

if ( empty( $cards ) ) return;

$headline_html = fc_accent_headline( $headline, $accent );
?>

<section class="fc-section fc-section--pathways" id="program-pathways">
    <div class="fc-container">
        <?php if ( $eyebrow || $headline ) : ?>
            <div class="fc-section-header fc-section-header--center fc-reveal">
                <?php if ( $eyebrow ) : ?>
                    <p class="fc-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
                <?php endif; ?>
                <?php if ( $headline ) : ?>
                    <h2 class="fc-h2"><?php echo $headline_html; ?></h2>
                <?php endif; ?>
                <?php if ( $body ) : ?>
                    <p class="fc-section-header__body"><?php echo esc_html( $body ); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="fc-pathways-grid">
            <?php foreach ( $cards as $i => $card ) :
                if ( empty( $card['title'] ) ) continue;
                $icon = $card['icon'] ?? '';
                $cta  = $card['cta_text'] ?? '';
                $url  = $card['cta_url'] ?? '#';
            ?>
                <div class="fc-pathway-card fc-reveal">
                    <div class="fc-pathway-card__icon-wrap">
                        <?php if ( $icon ) echo fc_icon( $icon, 'fc-icon--lg' ); ?>
                    </div>
                    <h3 class="fc-pathway-card__title"><?php echo esc_html( $card['title'] ); ?></h3>
                    <?php if ( ! empty( $card['description'] ) ) : ?>
                        <p class="fc-pathway-card__desc"><?php echo esc_html( $card['description'] ); ?></p>
                    <?php endif; ?>
                    <?php if ( $cta ) : ?>
                        <a href="<?php echo esc_url( $url ); ?>" class="fc-pathway-card__link">
                            <?php echo esc_html( $cta ); ?>
                            <?php echo fc_icon( 'arrow-right', 'fc-icon--sm' ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

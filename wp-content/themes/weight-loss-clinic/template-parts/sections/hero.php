<?php
/**
 * Section: Hero
 *
 * @var array $args ACF layout sub-fields passed via get_template_part.
 */
$data = $args['data'] ?? [];

$eyebrow   = $data['eyebrow'] ?? '';
$headline  = $data['headline'] ?? '';
$accent    = $data['headline_accent'] ?? '';
$body      = $data['body'] ?? '';
$cta_text  = $data['cta_text'] ?? '';
$cta_url   = ( $data['cta_url'] ?? '' ) ?: '#';
$cta2_text = $data['cta2_text'] ?? '';
$cta2_url  = ( $data['cta2_url'] ?? '' ) ?: '#';
$trust     = $data['trust_line'] ?? '';
$image     = $data['image'] ?? null;
$cards     = $data['hero_cards'] ?? [];

if ( ! $headline ) return;

$headline_html = fc_accent_headline( $headline, $accent );
$has_cards     = ! empty( $cards );
?>

<section class="fc-section fc-section--hero <?php echo $has_cards ? 'fc-section--hero-has-cards' : ''; ?>">
    <div class="fc-container">
        <?php if ( $trust ) : ?>
            <p class="fc-hero__trust-line fc-reveal"><?php echo wp_kses_post( $trust ); ?></p>
        <?php endif; ?>

        <h1 class="fc-hero__headline fc-reveal"><?php echo $headline_html; ?></h1>

        <?php if ( $body ) : ?>
            <p class="fc-hero__body fc-reveal"><?php echo esc_html( $body ); ?></p>
        <?php endif; ?>

        <?php if ( $cta_text ) : ?>
            <div class="fc-hero__cta fc-reveal">
                <a href="<?php echo esc_url( $cta_url ); ?>" class="fc-btn fc-btn--primary fc-btn--lg"><?php echo esc_html( $cta_text ); ?></a>
                <?php if ( $cta2_text ) : ?>
                    <a href="<?php echo esc_url( $cta2_url ); ?>" class="fc-btn fc-btn--secondary fc-btn--lg"><?php echo esc_html( $cta2_text ); ?></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="fc-hero__clinical-bar fc-reveal">
            <span class="fc-hero__clinical-item">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 0a8 8 0 100 16A8 8 0 008 0zm3.5 6.2l-4 4a.5.5 0 01-.7 0l-2-2a.5.5 0 11.7-.7L7.1 9.1l3.6-3.6a.5.5 0 01.7.7z" fill="currentColor"/></svg>
                Clinically reviewed
            </span>
            <span class="fc-hero__clinical-item">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 0a8 8 0 100 16A8 8 0 008 0zm3.5 6.2l-4 4a.5.5 0 01-.7 0l-2-2a.5.5 0 11.7-.7L7.1 9.1l3.6-3.6a.5.5 0 01.7.7z" fill="currentColor"/></svg>
                Not all patients approved
            </span>
            <span class="fc-hero__clinical-item">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 0a8 8 0 100 16A8 8 0 008 0zm3.5 6.2l-4 4a.5.5 0 01-.7 0l-2-2a.5.5 0 11.7-.7L7.1 9.1l3.6-3.6a.5.5 0 01.7.7z" fill="currentColor"/></svg>
                AHPRA-registered clinicians
            </span>
        </div>

        <?php if ( $image ) : ?>
            <div class="fc-hero__image fc-reveal">
                <?php fc_image( $image, 'fc-hero' ); ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if ( $has_cards ) : ?>
        <div class="fc-hero-cards fc-reveal">
            <div class="fc-hero-cards__grid">
                <?php foreach ( $cards as $card ) :
                    if ( empty( $card['label'] ) ) continue;
                    $card_url   = $card['url'] ?? '#';
                    $card_image = $card['image'] ?? null;
                    $card_color = $card['accent'] ?? '';
                ?>
                    <a href="<?php echo esc_url( $card_url ); ?>" class="fc-hero-card">
                        <div class="fc-hero-card__image" <?php if ( $card_color ) : ?>style="background-color: <?php echo esc_attr( $card_color ); ?>"<?php endif; ?>>
                            <?php if ( is_array( $card_image ) && ! empty( $card_image['url'] ) ) : ?>
                                <?php fc_image( $card_image, 'fc-card', 'fc-hero-card__img' ); ?>
                            <?php else : ?>
                                <div class="fc-hero-card__placeholder">
                                    <span><?php echo esc_html( $card['placeholder_label'] ?? $card['label'] ); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="fc-hero-card__label">
                            <span class="fc-hero-card__text"><?php echo esc_html( $card['label'] ); ?></span>
                            <?php echo fc_icon( 'arrow-right', 'fc-hero-card__arrow' ); ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</section>

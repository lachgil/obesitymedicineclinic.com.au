<?php
/**
 * Section: Hero Carousel
 *
 * Premium 3-slide editorial hero. Three slide kinds:
 *   - "clinical"  → photograph-led (Slide 01: clinician-led care)
 *   - "outcomes"  → restrained infographic / stat blocks (Slide 02)
 *   - "pricing"   → soft, transparent pricing (Slide 03)
 *
 * Inputs (via $args['data']):
 *   - autoplay_ms     int   (default 7000)
 *   - aria_label      string
 *   - slides          array of slide configs, each:
 *       - kind            'clinical' | 'outcomes' | 'pricing'
 *       - eyebrow         string
 *       - headline        string
 *       - headline_accent string (optional)
 *       - body            string
 *       - cta_text        string
 *       - cta_url         string
 *       - reassurance     array of strings (clinical / pricing)
 *       - attribution     string (clinical)
 *       - poster_image    string (clinical / pricing — image URL)
 *       - poster_alt      string
 *       - stats           array of [ 'label' => '', 'detail' => '' ]  (outcomes)
 *       - footnote        string (pricing small print)
 *       - price_lead      string (pricing — large lead, e.g. "$299")
 *       - price_suffix    string (pricing — e.g. "/month")
 *       - price_caption   string (pricing — under price)
 *
 * All slides share one fixed-height frame so the carousel never causes
 * layout shift between slides.
 *
 * @package WeightLossClinic
 */

defined( 'ABSPATH' ) || exit;

$data = $args['data'] ?? [];

$slides      = isset( $data['slides'] ) && is_array( $data['slides'] ) ? $data['slides'] : [];
$autoplay_ms = isset( $data['autoplay_ms'] ) ? (int) $data['autoplay_ms'] : 7000;
$aria_label  = $data['aria_label'] ?? __( 'Introduction', 'weight-loss-clinic' );

if ( empty( $slides ) ) {
    return;
}

$uid = 'fc-hcar-' . wp_unique_id();
?>

<section class="fc-hcar"
         aria-label="<?php echo esc_attr( $aria_label ); ?>"
         data-fc-hcar
         data-autoplay-ms="<?php echo esc_attr( $autoplay_ms ); ?>"
         id="<?php echo esc_attr( $uid ); ?>">
    <div class="fc-hcar__viewport">
        <ul class="fc-hcar__track" role="list">
            <?php foreach ( $slides as $i => $slide ) :
                $kind            = $slide['kind']            ?? 'clinical';
                $eyebrow         = $slide['eyebrow']         ?? '';
                $headline        = $slide['headline']        ?? '';
                $accent          = $slide['headline_accent'] ?? '';
                $body            = $slide['body']            ?? '';
                $cta_text        = $slide['cta_text']        ?? '';
                $cta_url         = ( $slide['cta_url']       ?? '' ) ?: '#';
                $reassurance     = $slide['reassurance']     ?? [];
                $attribution     = $slide['attribution']     ?? '';
                $poster          = $slide['poster_image']    ?? '';
                $poster_alt      = $slide['poster_alt']      ?? '';
                $stats           = $slide['stats']           ?? [];
                $footnote        = $slide['footnote']        ?? '';
                $price_lead      = $slide['price_lead']      ?? '';
                $price_suffix    = $slide['price_suffix']    ?? '';
                $price_caption   = $slide['price_caption']   ?? '';

                if ( ! $headline ) continue;

                $headline_html = function_exists( 'fc_accent_headline' )
                    ? fc_accent_headline( $headline, $accent )
                    : esc_html( $headline );

                $is_first = ( 0 === $i );
            ?>
                <li class="fc-hcar__slide fc-hcar__slide--<?php echo esc_attr( $kind ); ?> <?php echo $is_first ? 'is-active' : ''; ?>"
                    role="group"
                    aria-roledescription="<?php esc_attr_e( 'slide', 'weight-loss-clinic' ); ?>"
                    aria-label="<?php echo esc_attr( sprintf( __( 'Slide %1$d of %2$d', 'weight-loss-clinic' ), $i + 1, count( $slides ) ) ); ?>"
                    aria-hidden="<?php echo $is_first ? 'false' : 'true'; ?>"
                    data-fc-hcar-slide="<?php echo esc_attr( $i ); ?>">
                    <div class="fc-hcar__inner">

                        <div class="fc-hcar__content">
                            <?php if ( $eyebrow ) : ?>
                                <p class="fc-hcar__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
                            <?php endif; ?>

                            <h1 class="fc-hcar__headline"><?php echo $headline_html; // already escaped via fc_accent_headline ?></h1>

                            <?php if ( $body ) : ?>
                                <p class="fc-hcar__body"><?php echo wp_kses_post( $body ); ?></p>
                            <?php endif; ?>

                            <?php if ( $cta_text ) : ?>
                                <div class="fc-hcar__cta">
                                    <a href="<?php echo esc_url( $cta_url ); ?>" class="fc-btn fc-btn--primary fc-btn--lg">
                                        <?php echo esc_html( $cta_text ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if ( ! empty( $reassurance ) ) : ?>
                                <ul class="fc-hcar__reassurance" role="list">
                                    <?php foreach ( $reassurance as $item ) : ?>
                                        <li>
                                            <svg width="14" height="14" viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M8 0a8 8 0 100 16A8 8 0 008 0zm3.5 6.2l-4 4a.5.5 0 01-.7 0l-2-2a.5.5 0 11.7-.7L7.1 9.1l3.6-3.6a.5.5 0 01.7.7z" fill="currentColor"/></svg>
                                            <span><?php echo esc_html( $item ); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                            <?php if ( $footnote ) : ?>
                                <p class="fc-hcar__footnote"><?php echo esc_html( $footnote ); ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="fc-hcar__media">
                            <div class="fc-hcar__frame fc-hcar__frame--<?php echo esc_attr( $kind ); ?>">

                                <?php if ( 'outcomes' === $kind && ! empty( $stats ) ) : ?>
                                    <div class="fc-hcar__editorial" aria-hidden="false">
                                        <div class="fc-hcar__editorial-header">
                                            <span class="fc-hcar__editorial-rule" aria-hidden="true"></span>
                                            <span class="fc-hcar__editorial-tag"><?php esc_html_e( 'Clinical pathway', 'weight-loss-clinic' ); ?></span>
                                        </div>
                                        <ul class="fc-hcar__stats" role="list">
                                            <?php foreach ( $stats as $stat ) :
                                                $label  = $stat['label']  ?? '';
                                                $detail = $stat['detail'] ?? '';
                                                if ( ! $label ) continue;
                                            ?>
                                                <li class="fc-hcar__stat">
                                                    <span class="fc-hcar__stat-dot" aria-hidden="true">
                                                        <svg width="10" height="10" viewBox="0 0 10 10" focusable="false"><circle cx="5" cy="5" r="4" fill="currentColor"/></svg>
                                                    </span>
                                                    <div class="fc-hcar__stat-text">
                                                        <p class="fc-hcar__stat-label"><?php echo esc_html( $label ); ?></p>
                                                        <?php if ( $detail ) : ?>
                                                            <p class="fc-hcar__stat-detail"><?php echo esc_html( $detail ); ?></p>
                                                        <?php endif; ?>
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>

                                <?php elseif ( 'pricing' === $kind ) : ?>
                                    <?php if ( $poster ) : ?>
                                        <img class="fc-hcar__image"
                                             src="<?php echo esc_url( $poster ); ?>"
                                             alt="<?php echo esc_attr( $poster_alt ); ?>"
                                             loading="lazy"
                                             decoding="async">
                                        <div class="fc-hcar__overlay fc-hcar__overlay--soft" aria-hidden="true"></div>
                                    <?php endif; ?>
                                    <div class="fc-hcar__pricecard" aria-hidden="false">
                                        <p class="fc-hcar__pricecard-eyebrow"><?php esc_html_e( 'From', 'weight-loss-clinic' ); ?></p>
                                        <p class="fc-hcar__pricecard-lead">
                                            <span class="fc-hcar__pricecard-figure"><?php echo esc_html( $price_lead ?: '$299' ); ?></span>
                                            <?php if ( $price_suffix ) : ?>
                                                <span class="fc-hcar__pricecard-suffix"><?php echo esc_html( $price_suffix ); ?></span>
                                            <?php endif; ?>
                                        </p>
                                        <?php if ( $price_caption ) : ?>
                                            <p class="fc-hcar__pricecard-caption"><?php echo esc_html( $price_caption ); ?></p>
                                        <?php endif; ?>
                                    </div>

                                <?php else : ?>
                                    <?php if ( $poster ) : ?>
                                        <img class="fc-hcar__image"
                                             src="<?php echo esc_url( $poster ); ?>"
                                             alt="<?php echo esc_attr( $poster_alt ); ?>"
                                             loading="<?php echo $is_first ? 'eager' : 'lazy'; ?>"
                                             decoding="async"
                                             <?php echo $is_first ? 'fetchpriority="high"' : ''; ?>>
                                        <div class="fc-hcar__overlay" aria-hidden="true"></div>
                                    <?php endif; ?>
                                <?php endif; ?>

                            </div>

                            <?php if ( $attribution ) : ?>
                                <p class="fc-hcar__attribution"><?php echo esc_html( $attribution ); ?></p>
                            <?php endif; ?>
                        </div>

                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php if ( count( $slides ) > 1 ) : ?>
            <div class="fc-hcar__controls" aria-label="<?php esc_attr_e( 'Carousel controls', 'weight-loss-clinic' ); ?>">
                <button type="button"
                        class="fc-hcar__nav fc-hcar__nav--prev"
                        data-fc-hcar-prev
                        aria-label="<?php esc_attr_e( 'Previous slide', 'weight-loss-clinic' ); ?>">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><polyline points="15 18 9 12 15 6"/></svg>
                </button>

                <ol class="fc-hcar__dots" role="tablist">
                    <?php foreach ( $slides as $i => $slide ) :
                        $is_first = ( 0 === $i );
                    ?>
                        <li>
                            <button type="button"
                                    class="fc-hcar__dot <?php echo $is_first ? 'is-active' : ''; ?>"
                                    role="tab"
                                    aria-selected="<?php echo $is_first ? 'true' : 'false'; ?>"
                                    aria-label="<?php echo esc_attr( sprintf( __( 'Go to slide %d', 'weight-loss-clinic' ), $i + 1 ) ); ?>"
                                    data-fc-hcar-dot="<?php echo esc_attr( $i ); ?>">
                                <span class="fc-hcar__dot-progress" aria-hidden="true"></span>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ol>

                <button type="button"
                        class="fc-hcar__nav fc-hcar__nav--next"
                        data-fc-hcar-next
                        aria-label="<?php esc_attr_e( 'Next slide', 'weight-loss-clinic' ); ?>">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </div>
        <?php endif; ?>
    </div>
</section>

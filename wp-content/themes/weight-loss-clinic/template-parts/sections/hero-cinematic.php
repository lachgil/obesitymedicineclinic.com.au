<?php
/**
 * Section: Cinematic Hero
 *
 * Premium editorial hero with optional 8-second background video and
 * a high-quality still image fallback. Designed for the Weight Loss
 * Clinic specialist-pathway homepage.
 *
 * Inputs (via $args['data']):
 *   - eyebrow        string
 *   - headline       string  (required)
 *   - headline_accent string (optional emphasis substring)
 *   - body           string
 *   - cta_text       string
 *   - cta_url        string
 *   - cta2_text      string
 *   - cta2_url       string
 *   - poster_image   string  (URL — fallback still, always rendered)
 *   - video_url      string  (optional — .mp4)
 *   - video_url_webm string  (optional — .webm)
 *   - reassurance    array   ['Clinician-led', 'Bariatric oversight', 'Australia-wide']
 *   - attribution    string  (small caption under hero)
 *
 * Video loads only at md+ widths and is muted/autoplaying with playsinline.
 * Layout shift is prevented via fixed aspect ratio on the media frame.
 *
 * @package WeightLossClinic
 */

defined( 'ABSPATH' ) || exit;

$data = $args['data'] ?? [];

$eyebrow      = $data['eyebrow']         ?? '';
$headline     = $data['headline']        ?? '';
$accent       = $data['headline_accent'] ?? '';
$body         = $data['body']            ?? '';
$cta_text     = $data['cta_text']        ?? '';
$cta_url      = ( $data['cta_url']       ?? '' ) ?: '#';
$cta2_text    = $data['cta2_text']       ?? '';
$cta2_url     = ( $data['cta2_url']      ?? '' ) ?: '#';
$poster       = $data['poster_image']    ?? '';
$video        = $data['video_url']       ?? '';
$video_webm   = $data['video_url_webm']  ?? '';
$reassurance  = $data['reassurance']     ?? [];
$attribution  = $data['attribution']     ?? '';

if ( ! $headline || ! $poster ) {
    return;
}

$headline_html = function_exists( 'fc_accent_headline' )
    ? fc_accent_headline( $headline, $accent )
    : esc_html( $headline );

$has_video = ! empty( $video );
?>

<section class="fc-cinehero" aria-label="<?php esc_attr_e( 'Introduction', 'weight-loss-clinic' ); ?>">
    <div class="fc-cinehero__inner">

        <div class="fc-cinehero__content">
            <?php if ( $eyebrow ) : ?>
                <p class="fc-cinehero__eyebrow fc-reveal"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>

            <h1 class="fc-cinehero__headline fc-reveal"><?php echo $headline_html; // already escaped via fc_accent_headline ?></h1>

            <?php if ( $body ) : ?>
                <p class="fc-cinehero__body fc-reveal"><?php echo wp_kses_post( $body ); ?></p>
            <?php endif; ?>

            <?php if ( $cta_text ) : ?>
                <div class="fc-cinehero__cta fc-reveal">
                    <a href="<?php echo esc_url( $cta_url ); ?>" class="fc-btn fc-btn--primary fc-btn--lg">
                        <?php echo esc_html( $cta_text ); ?>
                    </a>
                    <?php if ( $cta2_text ) : ?>
                        <a href="<?php echo esc_url( $cta2_url ); ?>" class="fc-btn fc-btn--ghost fc-btn--lg fc-cinehero__cta-secondary">
                            <?php echo esc_html( $cta2_text ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ( ! empty( $reassurance ) ) : ?>
                <ul class="fc-cinehero__reassurance fc-reveal" role="list">
                    <?php foreach ( $reassurance as $item ) : ?>
                        <li>
                            <svg width="14" height="14" viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M8 0a8 8 0 100 16A8 8 0 008 0zm3.5 6.2l-4 4a.5.5 0 01-.7 0l-2-2a.5.5 0 11.7-.7L7.1 9.1l3.6-3.6a.5.5 0 01.7.7z" fill="currentColor"/></svg>
                            <span><?php echo esc_html( $item ); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <div class="fc-cinehero__media fc-reveal">
            <div class="fc-cinehero__frame">
                <?php if ( $has_video ) : ?>
                    <video
                        class="fc-cinehero__video"
                        poster="<?php echo esc_url( $poster ); ?>"
                        autoplay
                        muted
                        loop
                        playsinline
                        preload="metadata"
                        aria-hidden="true">
                        <?php if ( $video_webm ) : ?>
                            <source src="<?php echo esc_url( $video_webm ); ?>" type="video/webm">
                        <?php endif; ?>
                        <source src="<?php echo esc_url( $video ); ?>" type="video/mp4">
                    </video>
                <?php else : ?>
                    <img
                        class="fc-cinehero__image"
                        src="<?php echo esc_url( $poster ); ?>"
                        alt="<?php esc_attr_e( 'Dr Kevin Dolan in consultation', 'weight-loss-clinic' ); ?>"
                        width="1600"
                        height="1280"
                        loading="eager"
                        decoding="async"
                        fetchpriority="high">
                <?php endif; ?>
                <div class="fc-cinehero__overlay" aria-hidden="true"></div>
            </div>

            <?php if ( $attribution ) : ?>
                <p class="fc-cinehero__attribution"><?php echo esc_html( $attribution ); ?></p>
            <?php endif; ?>
        </div>

    </div>
</section>

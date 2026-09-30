<?php
/**
 * Section: Specialist Pathway (Vertical, MEDVi-inspired)
 *
 * Three-step vertical pathway. Left intro column (eyebrow, headline, body,
 * CTA), centre numbered rail, right column of stacked steps with large
 * rounded image cards. Collapses to a single column with a left-side rail
 * below the medium breakpoint.
 *
 * Inputs (via $args['data']):
 *   - eyebrow       string
 *   - headline      string (supports <br> and <span>)
 *   - headline_aux  string (intro body copy — falls back to legacy field)
 *   - intro_body    string (preferred intro copy)
 *   - cta_text      string (intro CTA)
 *   - cta_url       string
 *   - steps         array of [ 'n', 'title', 'body', 'meta', 'image', 'alt', 'object_position' ]
 *   - footnote      string
 *
 * @package WeightLossClinic
 */

defined( 'ABSPATH' ) || exit;

$data         = $args['data'] ?? [];
$eyebrow      = $data['eyebrow']      ?? '';
$headline     = $data['headline']     ?? '';
$intro_body   = $data['intro_body']   ?? ( $data['headline_aux'] ?? '' );
$steps        = $data['steps']        ?? [];
$cta_text     = $data['cta_text']     ?? '';
$cta_url      = $data['cta_url']      ?? '';
$footnote     = $data['footnote']     ?? '';

if ( empty( $steps ) ) {
    return;
}
?>
<section class="fc-section fc-section--pathway fc-section--pathway-vertical" id="how-it-works" data-fc-pathway-progress aria-label="<?php esc_attr_e( 'How the pathway works', 'weight-loss-clinic' ); ?>">
    <div class="fc-container">
        <div class="fc-pathway-v">

            <div class="fc-pathway-v__intro fc-reveal">
                <?php if ( $eyebrow ) : ?>
                    <p class="fc-pathway__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
                <?php endif; ?>
                <?php if ( $headline ) : ?>
                    <h2 class="fc-pathway-v__headline"><?php echo wp_kses( $headline, [ 'br' => [], 'span' => [ 'class' => [] ] ] ); ?></h2>
                <?php endif; ?>
                <?php if ( $intro_body ) : ?>
                    <p class="fc-pathway-v__body"><?php echo wp_kses_post( $intro_body ); ?></p>
                <?php endif; ?>
                <?php if ( $cta_text ) : ?>
                    <a class="fc-btn fc-btn--primary fc-pathway-v__cta" href="<?php echo esc_url( $cta_url ?: '#' ); ?>">
                        <?php echo esc_html( $cta_text ); ?>
                    </a>
                <?php endif; ?>
            </div>

            <div class="fc-pathway-v__rail" aria-hidden="true">
                <span class="fc-pathway-v__rail-line"></span>
                <span class="fc-pathway-v__rail-fill" data-fc-pathway-fill></span>
            </div>

            <ol class="fc-pathway-v__steps" role="list">
                <?php foreach ( $steps as $i => $step ) :
                    $num   = $step['n']     ?? sprintf( '%02d', $i + 1 );
                    $title = $step['title'] ?? '';
                    $body  = $step['body']  ?? '';
                    $meta  = $step['meta']  ?? '';
                    $image = $step['image'] ?? '';
                    $alt   = $step['alt']   ?? '';
                    $obj   = $step['object_position'] ?? 'center center';
                    if ( ! $title ) continue;
                ?>
                    <li class="fc-pathway-v__step fc-reveal" data-fc-pathway-step="<?php echo esc_attr( $i + 1 ); ?>">
                        <span class="fc-pathway-v__marker" aria-hidden="true">
                            <span class="fc-pathway-v__num"><?php echo esc_html( $num ); ?></span>
                        </span>
                        <figure class="fc-pathway-v__media">
                            <?php if ( $image ) : ?>
                                <img
                                    src="<?php echo esc_url( $image ); ?>"
                                    alt="<?php echo esc_attr( $alt ); ?>"
                                    loading="lazy"
                                    decoding="async"
                                    style="object-position: <?php echo esc_attr( $obj ); ?>;">
                            <?php endif; ?>
                        </figure>
                        <div class="fc-pathway-v__copy">
                            <h3 class="fc-pathway-v__title"><?php echo esc_html( $title ); ?></h3>
                            <?php if ( $body ) : ?>
                                <p class="fc-pathway-v__desc"><?php echo esc_html( $body ); ?></p>
                            <?php endif; ?>
                            <?php if ( $meta ) : ?>
                                <p class="fc-pathway-v__meta"><?php echo esc_html( $meta ); ?></p>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ol>

        </div>

        <?php if ( $footnote ) : ?>
            <p class="fc-pathway-v__footnote"><?php echo esc_html( $footnote ); ?></p>
        <?php endif; ?>
    </div>
</section>

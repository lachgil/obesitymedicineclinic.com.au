<?php
/**
 * Section: Testimonials
 */
$data     = $args['data'] ?? [];
$eyebrow  = $data['eyebrow'] ?? '';
$headline = $data['headline'] ?? '';
$source   = $data['source'] ?? 'cpt';
$has_acf  = function_exists( 'get_field' );

$testimonials = [];

if ( $source === 'cpt' && $has_acf ) {
    $query = new WP_Query( [
        'post_type'      => 'fc_testimonial',
        'posts_per_page' => 12,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ] );
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $testimonials[] = [
                'quote'     => get_field( 'testimonial_quote' ) ?: '',
                'name'      => get_field( 'testimonial_name' ) ?: get_the_title(),
                'treatment' => get_field( 'testimonial_treatment' ) ?: '',
                'rating'    => (int) ( get_field( 'testimonial_rating' ) ?: 5 ),
                'image_url' => get_the_post_thumbnail_url( get_the_ID(), 'fc-testimonial' ) ?: '',
            ];
        }
        wp_reset_postdata();
    }
} elseif ( ! empty( $data['manual_testimonials'] ) ) {
    foreach ( $data['manual_testimonials'] as $t ) {
        $testimonials[] = [
            'quote'     => $t['quote'] ?? '',
            'name'      => $t['name'] ?? '',
            'treatment' => $t['treatment'] ?? '',
            'rating'    => (int) ( $t['rating'] ?? 5 ),
            'image_url' => ! empty( $t['image'] ) ? ( $t['image']['sizes']['fc-testimonial'] ?? $t['image']['url'] ?? '' ) : '',
        ];
    }
}

if ( empty( $testimonials ) ) return;
?>

<section class="fc-section fc-section--testimonials">
    <div class="fc-container">
        <div class="fc-section-header fc-section-header--center fc-reveal">
            <?php if ( $eyebrow ) : ?>
                <p class="fc-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $headline ) : ?>
                <h2 class="fc-h2"><?php echo esc_html( $headline ); ?></h2>
            <?php endif; ?>
        </div>
    </div>

    <div class="fc-testimonials-track" role="region" aria-label="<?php esc_attr_e( 'Patient testimonials', 'flavour-clinic' ); ?>" tabindex="0">
        <?php foreach ( $testimonials as $t ) : ?>
            <?php if ( empty( $t['quote'] ) ) continue; ?>
            <article class="fc-testimonial-card">
                <div class="fc-testimonial-card__header">
                    <?php if ( $t['image_url'] ) : ?>
                        <div class="fc-testimonial-card__avatar">
                            <img src="<?php echo esc_url( $t['image_url'] ); ?>"
                                 alt=""
                                 width="80" height="80"
                                 loading="lazy">
                        </div>
                    <?php endif; ?>
                    <div class="fc-testimonial-card__meta">
                        <span class="fc-testimonial-card__name"><?php echo esc_html( $t['name'] ); ?></span>
                        <?php if ( $t['treatment'] ) : ?>
                            <span class="fc-testimonial-card__treatment"><?php echo esc_html( $t['treatment'] ); ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ( $t['rating'] ) : ?>
                    <div class="fc-stars" role="img" aria-label="<?php echo esc_attr( sprintf( __( 'Rated %d out of 5', 'flavour-clinic' ), $t['rating'] ) ); ?>">
                        <?php for ( $i = 0; $i < $t['rating']; $i++ ) : ?>
                            <?php echo fc_icon( 'star' ); ?>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>

                <blockquote class="fc-testimonial-card__quote">
                    <p><?php echo esc_html( $t['quote'] ); ?></p>
                </blockquote>
            </article>
        <?php endforeach; ?>
    </div>
</section>

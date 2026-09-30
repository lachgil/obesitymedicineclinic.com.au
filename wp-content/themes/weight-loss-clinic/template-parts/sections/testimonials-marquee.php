<?php
/**
 * Section: Testimonials Marquee
 *
 * Dual-row horizontally scrolling testimonial ticker.
 * Row 1 scrolls left, Row 2 scrolls right.
 * Every 4th card is an image placeholder card.
 * Pure CSS animation, no JS required.
 */
$data     = $args['data'] ?? [];
$eyebrow  = $data['eyebrow'] ?? '';
$headline = $data['headline'] ?? '';
$body     = $data['body'] ?? '';
$reviews  = $data['reviews'] ?? [];

if ( empty( $reviews ) ) return;

// Split reviews into two rows.
$mid  = (int) ceil( count( $reviews ) / 2 );
$row1 = array_slice( $reviews, 0, $mid );
$row2 = array_slice( $reviews, $mid );

/**
 * Render a row of review + image cards for the marquee.
 * Duplicates content for seamless loop. Inserts image placeholder every 4th card.
 */
if ( ! function_exists( 'fc_render_marquee_row' ) ) :
function fc_render_marquee_row( array $items, string $direction = 'left' ) : void {
    $dir_class = $direction === 'right' ? 'fc-review-marquee__track--reverse' : '';
    // Total items including image placeholders.
    $cards = [];
    $counter = 0;
    foreach ( $items as $item ) {
        $counter++;
        $cards[] = [ 'type' => 'review', 'data' => $item ];
        if ( $counter % 3 === 0 ) {
            $cards[] = [ 'type' => 'image' ];
        }
    }

    echo '<div class="fc-review-marquee__track ' . esc_attr( $dir_class ) . '">';
    // Duplicate for seamless loop.
    for ( $loop = 0; $loop < 2; $loop++ ) {
        echo '<div class="fc-review-marquee__set" aria-hidden="' . ( $loop > 0 ? 'true' : 'false' ) . '">';
        foreach ( $cards as $card ) {
            if ( $card['type'] === 'image' ) {
                echo '<div class="fc-review-marquee__image-card">';
                echo '<div class="fc-review-marquee__image-placeholder" aria-hidden="true">';
                echo '<span>Lifestyle Photo</span>';
                echo '</div>';
                echo '</div>';
            } else {
                $review = $card['data'];
                $name   = esc_html( $review['name'] ?? '' );
                $quote  = esc_html( $review['quote'] ?? '' );
                $rating = (int) ( $review['rating'] ?? 5 );

                echo '<div class="fc-review-marquee__card">';

                // Stars.
                echo '<div class="fc-review-marquee__stars" aria-label="' . esc_attr( sprintf( __( '%d out of 5 stars', 'flavour-clinic' ), $rating ) ) . '">';
                for ( $s = 0; $s < $rating; $s++ ) {
                    echo fc_icon( 'star', 'fc-icon--star' );
                }
                echo '</div>';

                if ( $name ) {
                    echo '<p class="fc-review-marquee__name">' . $name . '</p>';
                }
                if ( $quote ) {
                    echo '<p class="fc-review-marquee__quote">' . $quote . '</p>';
                }
                echo '</div>';
            }
        }
        echo '</div>';
    }
    echo '</div>';
}
endif;
?>

<section class="fc-section fc-section--testimonials-marquee">
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
    </div>

    <div class="fc-review-marquee" aria-label="<?php esc_attr_e( 'Patient reviews', 'flavour-clinic' ); ?>">
        <?php fc_render_marquee_row( $row1, 'left' ); ?>
        <?php fc_render_marquee_row( $row2, 'right' ); ?>
    </div>
</section>

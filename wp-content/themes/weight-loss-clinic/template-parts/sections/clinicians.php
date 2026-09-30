<?php
/**
 * Section: Clinicians / Team
 */
$data     = $args['data'] ?? [];
$eyebrow  = $data['eyebrow'] ?? '';
$headline = $data['headline'] ?? '';
$body     = $data['body'] ?? '';
$source   = $data['source'] ?? 'cpt';

$clinicians = [];
$has_acf    = function_exists( 'get_field' );

if ( $source === 'demo' ) {
    // Demo/fallback clinicians for theme preview (MEDVi-style 2-doctor layout)
    $clinicians = [
        [
            'name'  => 'Dr. Sarah Chen, MD',
            'title' => 'Internal Medicine, Weight Management',
            'image' => '',
            'bio'   => '',
            'link'  => '',
        ],
        [
            'name'  => 'Dr. James Harlow, DO',
            'title' => 'Family Medicine, Metabolic Health',
            'image' => '',
            'bio'   => '',
            'link'  => '',
        ],
    ];
} elseif ( $source === 'cpt' ) {
    $query = new WP_Query( [
        'post_type'      => 'fc_clinician',
        'posts_per_page' => 6,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ] );
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $clinicians[] = [
                'name'  => get_the_title(),
                'title' => $has_acf ? ( get_field( 'clinician_title' ) ?: '' ) : '',
                'image' => get_the_post_thumbnail( get_the_ID(), 'fc-clinician', [ 'loading' => 'lazy' ] ),
                'bio'   => get_the_excerpt(),
                'link'  => get_permalink(),
            ];
        }
        wp_reset_postdata();
    }
} elseif ( ! empty( $data['manual_clinicians'] ) && $has_acf ) {
    foreach ( $data['manual_clinicians'] as $post ) {
        $clinicians[] = [
            'name'  => $post->post_title ?? '',
            'title' => get_field( 'clinician_title', $post->ID ) ?: '',
            'image' => get_the_post_thumbnail( $post->ID, 'fc-clinician', [ 'loading' => 'lazy' ] ),
            'bio'   => $post->post_excerpt ?? '',
            'link'  => get_permalink( $post->ID ),
        ];
    }
}

if ( empty( $clinicians ) ) return;
?>

<section class="fc-section fc-section--clinicians">
    <div class="fc-container">
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

        <div class="fc-clinicians-grid">
            <?php foreach ( $clinicians as $doc ) :
                $tag_open  = $doc['link'] ? '<a href="' . esc_url( $doc['link'] ) . '" class="fc-clinician-card fc-reveal">' : '<div class="fc-clinician-card fc-reveal">';
                $tag_close = $doc['link'] ? '</a>' : '</div>';
            ?>
                <?php echo $tag_open; ?>
                    <div class="fc-clinician-card__image">
                        <?php if ( $doc['image'] ) : ?>
                            <?php echo $doc['image']; ?>
                        <?php else : ?>
                            <div class="fc-clinician-card__placeholder" aria-hidden="true"></div>
                        <?php endif; ?>
                    </div>
                    <div class="fc-clinician-card__info">
                        <p class="fc-clinician-card__name"><?php echo esc_html( $doc['name'] ); ?></p>
                        <?php if ( $doc['title'] ) : ?>
                            <p class="fc-clinician-card__title"><?php echo esc_html( $doc['title'] ); ?></p>
                        <?php endif; ?>
                    </div>
                <?php echo $tag_close; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

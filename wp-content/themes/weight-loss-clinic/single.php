<?php
/**
 * Single Post Template
 *
 * Polished article layout for blog posts, announcements, and educational content.
 * Uses featured image hero, .fc-prose for body, and optional CTA block.
 */
get_header();

$has_thumbnail = has_post_thumbnail();
$category      = get_the_category();
$cat_name      = ! empty( $category ) ? $category[0]->name : '';
$cat_link      = ! empty( $category ) ? get_category_link( $category[0]->term_id ) : '';
$content       = get_the_content();
$toc_html      = fc_table_of_contents( $content );
?>

<article class="fc-article" id="post-<?php the_ID(); ?>">

    <!-- ═══════════════ ARTICLE HEADER ═══════════════ -->
    <header class="fc-article-header">
        <div class="fc-container fc-container--narrow">
            <?php fc_breadcrumbs(); ?>

            <div class="fc-article-header__inner fc-reveal">
                <?php if ( $cat_name ) : ?>
                    <a href="<?php echo esc_url( $cat_link ); ?>" class="fc-article-header__category">
                        <?php echo esc_html( $cat_name ); ?>
                    </a>
                <?php endif; ?>

                <h1 class="fc-article-header__title"><?php the_title(); ?></h1>

                <div class="fc-article-header__meta">
                    <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                        <?php echo esc_html( get_the_date() ); ?>
                    </time>
                    <?php
                    $read_time = fc_reading_time();
                    if ( $read_time ) : ?>
                        <span class="fc-article-header__sep" aria-hidden="true">&middot;</span>
                        <span><?php echo esc_html( $read_time ); ?> min read</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <!-- ═══════════════ FEATURED IMAGE ═══════════════ -->
    <?php if ( $has_thumbnail ) : ?>
        <div class="fc-article-image fc-reveal">
            <div class="fc-container">
                <?php the_post_thumbnail( 'fc-hero', [
                    'class'   => 'fc-article-image__img',
                    'loading' => 'eager',
                ] ); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- ═══════════════ ARTICLE BODY ═══════════════ -->
    <div class="fc-section">
        <div class="fc-container fc-container--narrow">

            <?php if ( $toc_html ) : ?>
                <?php echo $toc_html; ?>
            <?php endif; ?>

            <div class="fc-prose">
                <?php the_content(); ?>
            </div>
        </div>
    </div>

    <!-- ═══════════════ POST FOOTER ═══════════════ -->
    <?php
    $tags = get_the_tags();
    if ( $tags ) : ?>
        <div class="fc-article-tags">
            <div class="fc-container fc-container--narrow">
                <div class="fc-article-tags__list fc-reveal">
                    <?php foreach ( $tags as $tag ) : ?>
                        <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="fc-article-tag">
                            <?php echo esc_html( $tag->name ); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- ═══════════════ DISCLAIMER ═══════════════ -->
    <?php fc_disclaimer(); ?>

</article>

<!-- ═══════════════ CTA BANNER ═══════════════ -->
<?php
$post_cta = fc_get_post_cta();
get_template_part( 'template-parts/sections/cta-banner', null, [
    'data' => [
        'headline'  => 'Ready to take the next step?',
        'body'      => 'Connect with a licensed clinician and start your personalized treatment plan today.',
        'cta_text'  => $post_cta['text'],
        'cta_url'   => $post_cta['url'],
        'cta2_text' => '',
        'cta2_url'  => '',
        'style'     => 'accent',
    ],
] );
?>

<!-- ═══════════════ RELATED POSTS ═══════════════ -->
<?php
// Try same-category posts first, fall back to recent posts.
$current_id = get_the_ID();
$cat_ids    = wp_get_post_categories( $current_id );

$related_args = [
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'post__not_in'   => [ $current_id ],
    'orderby'        => 'date',
    'order'          => 'DESC',
];

if ( ! empty( $cat_ids ) ) {
    $related_args['category__in'] = $cat_ids;
}

$related = new WP_Query( $related_args );

// Fallback: if same-category yielded fewer than 3, try recent posts.
if ( $related->post_count < 3 && ! empty( $cat_ids ) ) {
    wp_reset_postdata();
    unset( $related_args['category__in'] );
    $related = new WP_Query( $related_args );
}

if ( $related->have_posts() ) : ?>
    <section class="fc-section fc-section--related-posts">
        <div class="fc-container">
            <div class="fc-section-header fc-section-header--center fc-reveal">
                <p class="fc-eyebrow"><?php esc_html_e( 'Keep Reading', 'flavour-clinic' ); ?></p>
                <h2 class="fc-h2"><?php esc_html_e( 'Related articles', 'flavour-clinic' ); ?></h2>
            </div>

            <div class="fc-grid fc-grid--3">
                <?php while ( $related->have_posts() ) : $related->the_post(); ?>
                    <?php get_template_part( 'template-parts/blog/card' ); ?>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <?php wp_reset_postdata(); ?>
<?php endif; ?>

<?php get_footer(); ?>

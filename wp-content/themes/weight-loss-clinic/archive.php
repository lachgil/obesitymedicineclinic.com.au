<?php
/**
 * Archive Template
 *
 * Handles category, tag, date, and author archives.
 * Uses the same card grid and pagination as the blog index.
 */
get_header();
?>

<div class="fc-page__header-wrap">
    <div class="fc-container">
        <?php fc_breadcrumbs(); ?>
        <header class="fc-page__header fc-reveal">
            <p class="fc-eyebrow"><?php esc_html_e( 'Insights', 'flavour-clinic' ); ?></p>
            <h1 class="fc-h1"><?php the_archive_title(); ?></h1>
            <?php if ( get_the_archive_description() ) : ?>
                <p class="fc-page__intro"><?php echo wp_kses_post( get_the_archive_description() ); ?></p>
            <?php endif; ?>
        </header>
    </div>
</div>

<section class="fc-section fc-section--blog-index">
    <div class="fc-container">
        <?php if ( have_posts() ) : ?>

            <div class="fc-grid fc-grid--3">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/blog/card' ); ?>
                <?php endwhile; ?>
            </div>

            <?php fc_pagination(); ?>

        <?php else : ?>
            <div class="fc-blog-empty fc-reveal">
                <p class="fc-h3"><?php esc_html_e( 'No articles found', 'flavour-clinic' ); ?></p>
                <p style="color:var(--fc-gray-700);margin-top:var(--fc-space-sm);">
                    <?php esc_html_e( 'There are no articles in this category yet. Check back soon.', 'flavour-clinic' ); ?>
                </p>
                <?php fc_button( __( 'View All Articles', 'flavour-clinic' ), get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ), 'primary' ); ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>

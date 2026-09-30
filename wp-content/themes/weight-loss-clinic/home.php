<?php
/**
 * Blog Index Template (home.php)
 *
 * Displays the posts listing page. WordPress uses home.php for the
 * "posts page" whether set as the front page or a dedicated page.
 */
get_header();
?>

<div class="fc-page__header-wrap">
    <div class="fc-container">
        <?php fc_breadcrumbs(); ?>
        <header class="fc-page__header fc-reveal">
            <p class="fc-eyebrow"><?php esc_html_e( 'Insights', 'flavour-clinic' ); ?></p>
            <h1 class="fc-h1"><?php esc_html_e( 'Articles & Resources', 'flavour-clinic' ); ?></h1>
            <p class="fc-page__intro"><?php esc_html_e( 'Evidence-based insights, treatment guides, and clinical updates from our care team.', 'flavour-clinic' ); ?></p>
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
                <p class="fc-h3"><?php esc_html_e( 'No articles yet', 'flavour-clinic' ); ?></p>
                <p style="color:var(--fc-gray-700);margin-top:var(--fc-space-sm);">
                    <?php esc_html_e( 'Check back soon for insights and updates from our clinical team.', 'flavour-clinic' ); ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>

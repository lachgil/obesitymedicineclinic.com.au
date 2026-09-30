<?php
/**
 * Default index template.
 * Falls through to front-page.php for the homepage.
 */
get_header();
?>

<section class="fc-section">
    <div class="fc-container fc-container--narrow">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>">
                    <h1 class="fc-h1"><?php the_title(); ?></h1>
                    <div class="fc-body">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p><?php esc_html_e( 'No content found.', 'flavour-clinic' ); ?></p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>

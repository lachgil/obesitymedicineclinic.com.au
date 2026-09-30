<?php
/**
 * Generic Page Template
 *
 * Handles About, Contact, Privacy, Terms, and any standard content page.
 * Uses a lightweight page header with optional featured image,
 * then renders editor content inside a prose-styled container.
 */
get_header();

$has_thumbnail = has_post_thumbnail();
$excerpt       = get_the_excerpt();
?>

<article class="fc-page" id="post-<?php the_ID(); ?>">

    <?php if ( $has_thumbnail ) : ?>
        <div class="fc-page__hero">
            <?php the_post_thumbnail( 'large', [
                'class'   => 'fc-page__hero-img',
                'loading' => 'eager',
            ] ); ?>
            <div class="fc-page__hero-overlay"></div>
            <div class="fc-container">
                <header class="fc-page__header fc-page__header--over-image">
                    <h1 class="fc-h1"><?php the_title(); ?></h1>
                    <?php if ( $excerpt ) : ?>
                        <p class="fc-page__intro"><?php echo esc_html( $excerpt ); ?></p>
                    <?php endif; ?>
                </header>
            </div>
        </div>
    <?php else : ?>
        <div class="fc-page__header-wrap">
            <div class="fc-container fc-container--narrow">
                <header class="fc-page__header">
                    <h1 class="fc-h1"><?php the_title(); ?></h1>
                    <?php if ( $excerpt ) : ?>
                        <p class="fc-page__intro"><?php echo esc_html( $excerpt ); ?></p>
                    <?php endif; ?>
                </header>
            </div>
        </div>
    <?php endif; ?>

    <div class="fc-section">
        <div class="fc-container fc-container--narrow">
            <div class="fc-prose">
                <?php the_content(); ?>
            </div>
        </div>
    </div>

</article>

<?php get_footer(); ?>

<?php
/**
 * Blog Card Component
 *
 * Renders a single post card for blog index and archive pages.
 * Expects to be called inside the loop.
 */
$category = get_the_category();
$cat_name = ! empty( $category ) ? $category[0]->name : '';
?>

<article class="fc-post-card fc-reveal" id="post-<?php the_ID(); ?>">
    <a href="<?php the_permalink(); ?>" class="fc-post-card__link">
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="fc-post-card__image">
                <?php the_post_thumbnail( 'fc-blog-card', [
                    'class'   => 'fc-post-card__img',
                    'loading' => 'lazy',
                ] ); ?>
            </div>
        <?php else : ?>
            <div class="fc-post-card__image fc-post-card__image--placeholder">
                <div class="fc-post-card__placeholder" aria-hidden="true"></div>
            </div>
        <?php endif; ?>

        <div class="fc-post-card__body">
            <?php if ( $cat_name ) : ?>
                <span class="fc-post-card__category"><?php echo esc_html( $cat_name ); ?></span>
            <?php endif; ?>

            <h3 class="fc-post-card__title"><?php the_title(); ?></h3>

            <?php if ( has_excerpt() || get_the_content() ) : ?>
                <p class="fc-post-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
            <?php endif; ?>

            <div class="fc-post-card__meta">
                <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                    <?php echo esc_html( get_the_date() ); ?>
                </time>
                <?php
                $read_time = fc_reading_time();
                if ( $read_time ) : ?>
                    <span class="fc-post-card__sep" aria-hidden="true">&middot;</span>
                    <span><?php echo esc_html( $read_time ); ?> min</span>
                <?php endif; ?>
            </div>
        </div>
    </a>
</article>
